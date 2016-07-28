<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Category;
use App\User;
use Illuminate\View\View;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Post;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    /**
     *
     * @return View;
     */
    public function index(){

        return view('admin.index');
    }

    /**
     *
     * @return View;
     */
    public function users()
    {
        $users = User::all();

        return view('admin.users', ['users' => $users]);
    }

    /**
     * @param Request $request
     *
     * @return Response;
     */
    public function status(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $user = User::where('id', '=', $data['id']);
            $user->update(
                [
                    'status' => $data['status'],
                ]
            );
        }

        return response()->json(['status' => $data['status'], "id" => $data['id']]);
    }

    /**
     *
     * @return View;
     */
    public function allAnnouncement()
    {
        $posts    = Post::getAllPostNonPublished();
        $post     = array();
        $comments = array();
        foreach ($posts as $item) {
            if ($item->parent_id == null) {
                $post[] = $item;
            }
            if (Post::getAllCommentsNonPublished($item->id) !== null) {
                $comments[$item->id] = Post::getAllCommentsNonPublished($item->id);
            }
        }

        return view('admin.all-announcement', ['posts' => $post, 'comments' => $comments]);
    }

    /**
     * @param int $id
     *
     * @return Respone;
     */
    public function deleteResponse($id)
    {
        $id   = (int)$id;
        $post = Post::find($id);

        if ($post->delete()) {
            return back()->with('status', 'Deleted');
        } else {
            return back()->with('status', 'Error');
        }
    }

    /**
     * @param Input
     *
     * @return Response;
     */
    public function updateAnnouncement()
    {

        $post            = Post::find(Input::get('id'));
        $post->title     = Input::get('title');
        $post->content   = Input::get('content_full');
        $post->published = Input::get('published');

        if ($post->save()) {
            return back()->with('status', 'Updated');
        } else {
            return back()->with('status', 'Error');
        }
    }

    /**
     *
     * @return View;
     */
    public function addAnnouncement(){

        $users = User::all();
        return view('admin.add-announcement', ['users'=>$users]);
    }
}