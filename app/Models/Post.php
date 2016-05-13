<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function photos()
    {
        return $this->hasMany('App\Models\Photos');
    }

    public function files()
    {
        return $this->hasMany('App\Models\ProjectFiles');
    }

    public static function getPublishedPost()
    {
        return static::latest('id')->where('published','1')->get();
    }

    public static function getComments($id){

        return static::where('parent_id',$id)->where('published', '1')->get();
    }
    
    public static function getAllPostNonPublished(){

        return static::get();

    }

    public static function getAllCommentsNonPublished($id){

        return static::where('parent_id', $id)->get();

    }

    public static function getAllPost($id, $parent_id)
    {
        return static::where('published','1')->where('category_id', $id)->where('category_sub_id', $parent_id)->get();
    }

    public static function getAllPostById($id)
    {
        return static::where('published','1')->where('category_id', $id)->get();
    }
}
