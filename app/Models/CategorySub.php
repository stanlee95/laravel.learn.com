<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySub extends Model
{
    protected $table = 'category_sub';
    protected $fillable = ['name', 'category_id', 'created_at'];

    public function category(){

        return $this->belongsTo('App\Models\Category');
    }

    public function post(){

        return $this->hasMany('App\Models\post');
    }



}
