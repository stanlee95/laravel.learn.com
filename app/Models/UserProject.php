<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = 'user_project';
    protected $fillable = ['project_id', 'user_id'];

    public function projects(){

        return $this->hasOne('App\Models\Projects');
    }

    public function users(){

        return $this->belongsToMany('App\Users');
    }
}
 