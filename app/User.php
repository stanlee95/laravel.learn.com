<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'facebook_id', 'google_id','yandex_id', 'mail_id', 'odno_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    public static function uploadAvatar($file, $name){
        
        $data = NULL;
            $rules = array('file' => 'required');
            $validator = Validator::make(array('file'=> $file), $rules);
            if($validator->passes()){
                $destinationPath = 'uploads/user_image/';
                $file_extension = $file->getClientOriginalExtension();
                $filename = $name . '.' . $file_extension;
                $upload_success = $file->move($destinationPath, $filename);
                $data = $destinationPath . $filename;
            }
        return $data;
    }
}
