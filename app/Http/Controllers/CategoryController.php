<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests;
use Validator;


class CategoryController extends Controller
{
    public function index($id){
        $posts = Post::getAllPostById($id);
        return view('category.index', ['posts'=>$posts]);
    }

    public function sub($id, $parent_id = 0){

        $posts = Post::getAllPost($id, $parent_id);
        return view('category.index', ['posts'=>$posts]);
    }



}