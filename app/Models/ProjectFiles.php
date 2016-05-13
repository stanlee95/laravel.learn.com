<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    protected $table = 'files';
    protected $fillable = ['name', 'path', 'ext'];
    protected $base_dir = 'uploads/post_uid_string';

    public function post(){

        return $this->belongsTo('App\Models\Post');
    }

    public static function getFiles($name){

        return static::where('name',$name)->first();

    }

}
