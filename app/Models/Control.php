<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    /**
     *
     * @var string
     */
    protected $table = 'control';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'input_time', 'output_time', 'blocked', 'token', 'is_coming'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function users()
    {

        return $this->hasOne('App\User');
    }
}
