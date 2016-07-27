<?php

namespace App\Http\Controllers;


use App\Models\Photos;
use App\Models\Category;
use App\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use App\Models\Post;

use Illuminate\Contracts\View\Factory;
use App\Models\ProjectFiles;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;

class PostController extends Controller
{

    /**
     *
     * @var array
     */
    protected $ans = [];

    /**
     *
     * @var array
     */
    protected $data = [];

    /**
     *
     * @return \Illuminate\Contracts\View\Factory;
     */
    public function index()
    {

        return view('post.index');
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory;
     */
    public function discuss()
    {
        $posts = Post::getPublishedPost();
        $post     = [];
        $comments = [];
        $projectsResult  = [];
        foreach ($posts as $item) {
            if ($item->parent_id == null) {
                $post[] = $item;
            }
            if (Post::getComments($item->id) !== null) {
                $comments[$item->id] = Post::getComments($item->id);
            }
        }
        
        return view('discuss.index', ['posts' => $post, 'comments' => $comments]);
    }

    /**
     *
     * @return Response;
     */
    public function post()
    {
        if (isset(Post::orderBy('id', 'desc')->first()->id)) {
            $post_id = Post::orderBy('id', 'desc')->first()->id + 1;
        } else {
            $post_id = 1;
        }

        $validator = Validator::make(
            array(
                'title'    => Input::get('title'),
                'content'  => Input::get('content_full'),
            ),
            array(
                'title'    => 'required',
                'content'  => 'required|min:3|max:255',
            )
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if (!Auth::guest()) {
            $files = $this->uploadFiles(Input::file('photo'), $post_id);
            if ($files) {
                Photos::insert($files);
            }
            $files_new = $this->uploadFiles(Input::file('files'), $post_id);
            if ($files_new) {
                ProjectFiles::insert($files_new);
            }
        }

        $post                  = new Post;
        $post->id              = $post_id;
        $post->title           = Input::get('title');
        $post->content         = Input::get('content_full');
        $post->published       = Input::get('published');
        $post->category_id     = Input::get('category_id');
        $post->category_sub_id = Input::get('category_sub_id');

        // - - - -- -------For Admin-panel-------------------------
        if (Request::has('admin')) {
            if (Input::get('card_id') != 'Guest') {
                $name            = Input::get('card_id');
                $user            = User::where('card_id', $name)->first();
                $post->user_name = $user->card_id;
                $post->photo     = $user->avatar;
            } else {
                $post->user_name = 'Guest';
                $post->photo     = null;
            }
        } else {
            $post->user_name = Auth::guest() ? 'Guest' : Auth::user()->card_id;
            $post->photo     = Auth::guest() ? null : Auth::user()->avatar;
        }

        if ($post->save()) {
            return redirect('\discuss')->with('status', 'Post created!');
        } else {
            echo 'Its so bad :(';
        }
    }

    /**
     * @param int $id
     *
     * @return Response;
     */
    public function delete($id)
    {
        $post        = Post::find($id);
        $photos      = Photos::where('post_id', $id);
        $files       = ProjectFiles::where('post_id', $id);
        $destination = 'uploads/' . $id;
        if ($post->delete()) {
            File::deleteDirectory($destination);
            $photos->delete();
            $files->delete();

            return response()->json(['status' => 'success']);
        } else {
            return back()->with('status', 'Post dont deleted!');
        }
    }

    /**
     * @param string $name
     *
     * @return Response;
     */
    public function deleteImage($name)
    {
        $photo = Photos::getPhotos($name);
        if ($photo->delete()) {
            File::delete($photo->path);

            return back()->with('status', 'Image deleted!');
        } else {
            return back()->with('status', 'Error');
        }
    }

    /**
     * @param string $name
     *
     * @return Response;
     */
    public function deleteFile($name)
    {
        $file = ProjectFiles::getFiles($name);
        if ($file->delete()) {
            File::delete($file->path);

            return back()->with('status', 'File deleted!');
        } else {
            return back()->with('status', 'Error');
        }
    }

    /**
     * @param int $id
     *
     * @return View;
     */
    public function viewPost($id)
    {
        $posts = Post::find($id);

        return view('post.view', ['posts' => $posts]);
    }

    /**
     * @param int $post_id
     *
     * @return Response;
     */
    public function uploadMoreFiles($post_id)
    {
        $files = $this->uploadFiles(Input::file('photo'), $post_id);
        if ($files) {
            Photos::insert($files);
        }
        $files_new = $this->uploadFiles(Input::file('files'), $post_id);
        if ($files_new) {
            ProjectFiles::insert($files_new);
        }

        return back()->with('status', 'Files uploaded!');
    }

    /**
     * @param int id
     *
     * @return Response|View;
     */
    public function response($id)
    {
        if ($id) {
            $id_post = (int)$id;
            $post    = Post::find($id_post);

            return view('post.response', ['post' => $post]);
        } else {
            return back()->with('status', 'Error!');
        }
    }

    /**
     * @param int id
     *
     * @return Response;
     */
    public function responsePost()
    {
        $validator = Validator::make(
            array(
                'content' => Input::get('content_full')
            ),
            array(
                'content' => 'required|min:3|max:255'
            )
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $post            = new Post;
        $post->parent_id = Input::get('parent_id');
        $post->title     = null;
        $post->content   = Input::get('content_full');
        $post->user_name = Auth::user()->card_id;
        $post->published = 1;

        if ($post->save()) {
            return redirect('/discuss')->with('status', 'Response created!');
        } else {
            return back()->with('status', 'Error!');
        }
    }

    //SearchAction-----------------------------
    public function search()
    {
        $search_result         = Input::get('search_name');
        $search_result_title   = preg_replace('#[^aA-zZ0-9]#', '', $search_result);
        $search_result_date    = Input::get('search_date') == null ? 'NULL' : Input::get('search_date');
        $search_result_content = Input::get('search_content') == null ? 0 : Input::get('search_content');
        //        dd($search_result_content);

        $results  =
            DB::table('posts')->where('published', '1')->where('title', 'LIKE', '%' . $search_result_title . '%')
                ->orWhere('created_at', 'LIKE', '%' . $search_result_date . '%')
                ->orWhere('content', 'LIKE', '%' . $search_result_content . '%')
                ->where('parent_id', null)
                ->get();

        $comments = [];
        foreach ($results as $item) {
            if (Post::getComments($item->id) !== null) {
                $comments[$item->id] = Post::getComments($item->id);
            }
        }

        return view('post.search', ['posts' => $results, 'comments' => $comments]);
    }

    //-------------------------------------------------------------------------------------------------

    protected function uploadFiles($files, $post_id)
    {

        $data = array();
        foreach ($files as $file) {
            $rules     = array('file' => 'required');
            $validator = Validator::make(array('file' => $file), $rules);

            if ($validator->passes()) {
                $destinationPath = 'uploads/' . $post_id . '/';
                $file_extension  = $file->getClientOriginalExtension();
                $filename        = str_random(20) . '.' . $file_extension;
                $upload_success  = $file->move($destinationPath, $filename);
                $data[]          = array(
                    'name'    => $filename,
                    'path'    => $destinationPath . $filename,
                    'post_id' => $post_id,
                    'ext'     => $file_extension
                );
            }
        }

        return $data;
    }
}




