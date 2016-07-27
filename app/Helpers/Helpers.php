<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use App\Models\Category;

class Helpers {

    public static function recursion($sub_category, $parent_id){

        if(empty($sub_category[$parent_id])) {
            return;
        }
        echo '<ul class="submenu">';
        foreach ($sub_category[$parent_id] as $item){

            echo '<li><a href="/category/'.$parent_id.'/'.$item->id.'">'.$item->name .'</a>';


            self::recursion($sub_category,$item->id);
            echo '</li>';

        }
        echo '</ul>';
    }

    public static function recursionSelect($sub_category, $parent_id){

        if(empty($sub_category[$parent_id])) {
            return;
        }
        echo '<ul class="submenu">';
        foreach ($sub_category[$parent_id] as $item){

            echo '<li><a href="#" onmouseover="this.style.color=\'black\'" onclick="document.getElementById(\'cat_id_parent\').value ='.$item->id.';document.getElementById(\'cat_id\').value ='.$parent_id.'; this.style.color=\'red\';">'.$item->name .'</a>';


            self::recursionSelect($sub_category,$item->id);
            echo '</li>';

        }
        echo '</ul>';
    }

    public static function recursionComments($comments, $parent_id)
    {

        if (empty($comments[$parent_id])) {
            return;
        }

//        $cnt = count($comments[$parent_id]);
        foreach ($comments[$parent_id] as $item) {
            echo '<div class="media-left">';
            if (isset($item->photo)) {
                echo '<img class="media-object" src="/' . $item->photo . '" style="width:120px; height: 120px">';
            } else {
                echo '<img class="media-object" src="/uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">';
            }
            echo '</div>';

            echo '<div class="media-body">';
            echo '<h4 class="media-heading">' . $item->user_name . '</h4>';
            echo '<b><p>' . $item->content . '</p></b>
                     <div class="panel-heading">' . $item->published_at . '</div>
                     <div align="right">';
            
            if(Request::path() =="admin-panel/all-announcement"){
                echo '<button class="btn btn-primary" type="button">
                      <a href="/admin-panel/delete-response/' . $item->id . '" style="color: white">Delete</a>
                  </button>';

                echo '<button class="btn btn-primary" type="button">
                      <a href="#bottom" style="color: white">Update</a>
                  </button>';

            }else {
                echo '<button class="btn btn-primary" type="button">
                      <a href="response/' . $item->id . '" style="color: white">Send Response</a>
                  </button>';
            }
            echo '</div>';

            self::recursionComments($comments, $item->id);
            echo '</div><br>';
        }
    }
//        public static function recursionAllCategory($category, $parent_id){
//
//            if(empty($category[$parent_id])) {
//                return;
//            }
//            echo '<ul class="list-group">';
//            foreach ($category[$parent_id] as $item){
//
//                echo '<li class="list-group-item"><b>ID:</b>'. $item->id .' <br> <b>Name:</b>' . $item->name .
//                '; <b>Published:</b>'.$item->published.'; <b>Created:</b>'.$item->created_at;
//                echo '<li class="list-group-item"><p><a class="sta" href = "/admin-panel/delete-category/'.$item->id.'"><button type="button" class="btn btn-xs btn-default">Delete</button></a>
//
//                    <a href="#id" onclick="document.getElementById(\'parent_id\').value =' . $item->id .'"><button type="button"
//                                                                                                          class="btn btn-xs btn-default">CreateSubCategory</button> </a></li>';
//
//
//                self::recursionAllCategory($category,$item->id);
//                echo '</li>';
//
//            }
//            echo '</ul>';
//        }
//
//    public static function recursionDeleteCategory($category, $parent_id){
//
//        if(empty($category[$parent_id])) {
//            return;
//        }
//
//        foreach ($category[$parent_id] as $item){
//            $id = $item->id;
//            Category::destroy($item->id);
//            self::recursionDeleteCategory($category,$id);
//        }
//
//    }

    public static function recursionDeletePost($post, $parent_id){

        if(empty($post[$parent_id])) {
            return;
        }

        foreach ($post[$parent_id] as $item){
            $id = $item->id;
            Post::destroy($item->id);
            self::recursionDeleteCategoPost($post,$id);
        }

    }
}