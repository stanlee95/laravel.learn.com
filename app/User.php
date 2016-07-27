<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    /**
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id',
        'valid_to',
        'role',
        'status',
        'name',
        'first_name',
        'second_name',
        'department_name',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param string $password
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    /**
     * @param array  $file
     * @param string $name
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function uploadAvatar($file, $name)
    {

        $data      = null;
        $rules     = array('file' => 'required');
        $validator = Validator::make(array('file' => $file), $rules);
        if ($validator->passes()) {
            $destinationPath = 'uploads/user_image/';
            $file_extension  = $file->getClientOriginalExtension();
            $filename        = $name . '.' . $file_extension;
            $upload_success  = $file->move($destinationPath, $filename);
            $data            = $destinationPath . $filename;
        }

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function control()
    {
        return $this->hasOne('App\Models\Control');
    }
}
