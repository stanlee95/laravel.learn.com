<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name', 'path', 'published', 'created_at'];

    public function post(){

        return $this->hasMany('App\Models\Post');
    }

    public function category_sub(){

        return $this->hasMany('App\Models\CategorySub');
    }

    public static function getCategory(){

//        return static::where('published','1')->where('parent_id', NULL)->get();
        return static::where('published','1')->get();

    }

    public static function getSubCategory($id){

        return static::where('parent_id',$id)->where('published', '1')->get();
    }

    public static function getAllSubCategory($id){

        return static::where('parent_id',$id)->get();
    }

    public static function getAllCategory(){

        $category = static::all();
        $cat = array();
        $sub_category = array();

        foreach ($category as $item){
            if($item->parent_id==NULL){
                $cat[]= $item;
            }
            if(self::getSubCategory($item->id)!==NULL) {
                $sub_category[$item->id] = self::getAllSubCategory($item->id);
            }
        }

        return array($cat, $sub_category);
    }
}
