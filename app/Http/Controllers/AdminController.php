<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Category;
use App\User;
use Illuminate\Support\Facades\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Post;


class AdminController extends Controller
{
    public function index(){

        return view('admin.index');

    }

    public function users(){

        $users = User::all();
        return view('admin.users', ['users'=>$users]);

    }
    //Category---------------------------------------------------------------------------------------
    public function allCategory(){

        $category = Category::getAllCategory();
        return view('admin.all-category', ['category' => $category[0], 'sub_category'=> $category[1]]);

    }

    public function deleteCategory($id){

        $id = (int)$id;
        $category = Category::all();
        foreach ($category as $item){
            $sub_category[$item->id] = Category::getAllSubCategory($item->id);
        }

        if(Category::destroy($id)){
            Helpers::recursionDeleteCategory($sub_category, $id);
            return back()->with('status', 'Category deleted');
        }else{
            return back()->with('status', 'Error!');
        }
        
    }
    
    public function addCategory()
    {
        $category = new Category();
        $category->name = Input::get('name');
        $category->published = Input::get('published');
        $category->parent_id = Input::get('parent_id');

        if($category->save()){

            return back()->with('status', 'Category created');
        }else{
            return back()->with('status', 'Error!');
        }
    }
    //Announcement-----------------------------

    public function allAnnouncement(){
        $posts = Post::getAllPostNonPublished();
        $post = array();
        $comments = array();
        foreach ($posts as $item){
            if($item->parent_id==NULL){
                $post[]= $item;
            }
            if(Post::getAllCommentsNonPublished($item->id)!==NULL) {
                $comments[$item->id] = Post::getAllCommentsNonPublished($item->id);
            }
        }

        return view('admin.all-announcement', ['posts'=>$post, 'comments'=>$comments ]);
    }

    public function deleteResponse($id){
        $id = (int)$id;
        $post = Post::find($id);

        if($post->delete()){
            return back()->with('status', 'Deleted');
        }else{
            return back()->with('status', 'Error');

        }
    }

    public function updateAnnouncement(){

        $post = Post::find(Input::get('id'));
        $post->title = Input::get('title');
        $post->content = Input::get('content_full');
        $post->published  = Input::get('published');

        if($post->save()){
            return back()->with('status', 'Updated');
        }else{
            return back()->with('status', 'Error');
        }

    }

    public function addAnnouncement(){

        $users = User::all();
        return view('admin.add-announcement', ['users'=>$users]);
    }
}