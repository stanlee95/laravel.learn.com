<?php

namespace App\Http\Controllers;


use App\Models\Photos;
use App\Models\Category;
use App\User;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use App\Models\Post;


use Illuminate\Contracts\View\Factory;
use App\Models\ProjectFiles;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;

class PostController extends Controller
{

    public $ans  = array();
    public $data = array();

    public function index(){

        $posts = Post::getPublishedPost();

        $post = array();
        $comments = array();
        foreach ($posts as $item){
            if($item->parent_id==NULL){
                $post[]= $item;
            }
            if(Post::getComments($item->id)!==NULL) {
                $comments[$item->id] = Post::getComments($item->id);
            }
        }


        return view('post.index', ['posts'=>$post, 'comments' =>$comments]);
    }


    public function post()
    {
        if(isset(Post::orderBy('id', 'desc')->first()->id)) {

            $post_id = Post::orderBy('id', 'desc')->first()->id + 1;
        }else{
            $post_id = 1;
        }
/*              Validation        */
        $validator = Validator::make(
            array(
                'category' => Input::get('category_id'),
                'title' => Input::get('title'),
                'content' => Input::get('content_full')
            ),
            array(
                'category' => 'required',
                'title' => 'required',
                'content' => 'required|min:3|max:255'
            )
        );

        if($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

//-----------------------UploadFiles----------------------------------------------------------
        if(!Auth::guest()) {
            $files = $this->uploadFiles(Input::file('photo'), $post_id);
            if ($files) {
                Photos::insert($files);
            }
            $files_new = $this->uploadFiles(Input::file('files'), $post_id);
            if ($files_new) {
                ProjectFiles::insert($files_new);
            }
        }

        $post = new Post;
        $post->id = $post_id;
        $post->title = Input::get('title');
        $post->content = Input::get('content_full');
        $post->published = Input::get('published');
        $post->category_id = Input::get('category_id');
        $post->category_sub_id = Input::get('category_sub_id');


        // - - - -- -------For Admin-panel-------------------------
            if(Request::has('admin')) {
                if(Input::get('name')!= 'Guest'){
                    $name = Input::get('name');
                    $user = User::where('name', $name)->first();
                    $post->user_name = $user->name;
                    $post->photo = $user->avatar;
                }else{
                    $post->user_name = 'Guest';
                    $post->photo = NULL;

                }
            }else{
                $post->user_name = Auth::guest() ? 'Guest' : Auth::user()->name;
                $post->photo = Auth::guest() ? NULL : Auth::user()->avatar;
            }

        if($post->save())
        {
            return back()->with('status', 'Post created!');

        }
        else{
            echo 'Its so bad :(';
        }
    }

//------------------------DeleteMethod------------------------------------
    public function delete($id){
        $post = Post::find($id);
        $photos = Photos::where('post_id', $id);
        $files = ProjectFiles::where('post_id', $id);
        $destination = 'uploads/' . $id;
        if($post->delete()){
            File::deleteDirectory($destination);
            $photos->delete();
            $files->delete();
            return back()->with('status', 'Post deleted!');
        }
        else{
            return back()->with('status', 'Post dont deleted!');
        }
    }


    public function deleteImage($name){

        $photo = Photos::getPhotos($name);
        if($photo->delete())
        {
            File::delete($photo->path);
            return back()->with('status', 'Image deleted!');
        }
        else{
                return back()->with('status', 'Error');
        }
    }

    public function deleteFile($name){

        $file = ProjectFiles::getFiles($name);
        if($file->delete())
        {
            File::delete($file->path);
            return  back()->with('status', 'File deleted!');
        }
        else{
            return  back()->with('status', 'Error');
        }
    }


    public function viewPost($id){

        $posts = Post::find($id);
        return view('post.view', ['posts'=>$posts]);
    }



    public function uploadMoreFiles($post_id){

        $files = $this->uploadFiles(Input::file('photo'), $post_id);
        if($files){
            Photos::insert($files);
        }
        $files_new = $this->uploadFiles(Input::file('files'), $post_id);
        if($files_new){
            ProjectFiles::insert($files_new);
        }

        return back()->with('status', 'Files uploaded!');
    }

    public function response($id)
    {
        if ($id) {

            $id_post = (int)$id;
            $post = Post::find($id_post);
            return view('post.response', ['post' => $post]);

        } else {
            return back()->with('status', 'Error!');
        }
    }

        public function responsePost(){

            $validator = Validator::make(
                array(
                    'content' => Input::get('content_full')
                ),
                array(
                    'content' => 'required|min:3|max:255'
                )
            );

            if($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }
            $post = new Post;
            $post->parent_id = Input::get('parent_id');
            $post->title = NULL;
            $post->content = Input::get('content_full');
            $post->user_name = Auth::guest() ? 'Guest' : Auth::user()->name;
            $post->published = 1;

            if($post->save())
            {
                return redirect('/')->with('status', 'Response created!');

            }
            else{
                return back()->with('status', 'Error!');
            }

    }
//SearchAction-----------------------------
    public function search(){
        $search_result = Input::get('search_name');
        $search_result_title = preg_replace('#[^aA-zZ0-9]#', '',$search_result);
        $search_result_date = Input::get('search_date')==NULL ? 'NULL' : Input::get('search_date');
        $search_result_content = Input::get('search_content')==NULL ? 0 : Input::get('search_content');
//        dd($search_result_content);

        $results = DB::table('posts')->where('published', '1')->where('title', 'LIKE', '%'.$search_result_title.'%')
            ->orWhere('created_at', 'LIKE', '%'.$search_result_date.'%')
            ->orWhere('content', 'LIKE', '%'.$search_result_content.'%')
            ->where('parent_id', NULL)
            ->get();
        $comments = array();
        foreach ($results as $item) {
            if (Post::getComments($item->id) !== NULL) {
                $comments[$item->id] = Post::getComments($item->id);
            }
        }
        return view('post.search',['posts'=>$results, 'comments'=>$comments]);

    }
//-------------------------------------------------------------------------------------------------

    protected function uploadFiles($files, $post_id){

        $data = array();
        foreach ($files as $file) {
            $rules = array('file' => 'required');
            $validator = Validator::make(array('file'=> $file), $rules);

            if($validator->passes()){
                $destinationPath = 'uploads/' . $post_id . '/';
                $file_extension = $file->getClientOriginalExtension();
                $filename = str_random(20) . '.' . $file_extension;
                $upload_success = $file->move($destinationPath, $filename);
                $data[] = array('name' => $filename,
                    'path' => $destinationPath . $filename,
                    'post_id' => $post_id,
                    'ext' => $file_extension);
            }
        }
        return $data;

    }





}
