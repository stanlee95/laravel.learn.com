<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = 'photos';
    protected $fillable = ['name', 'path', 'thumbnail_path', 'ext'];
    protected $base_dir = 'uploads/post_uid_string';

    public function post(){

        return $this->belongsTo('App\Models\Post');
    }


    protected function resizePhoto(){
        Image::make($this->path)
            ->fit(250)->save($this->path);

    }

    public static function getPhotos($name){

        return static::where('name',$name)->first();

    }
}
