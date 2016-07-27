<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceAccess extends Model
{
    protected $table = 'place_access';
    protected $fillable = ['places', 'user_id', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function users(){

        return $this->hasOne('App\User');
    }
}
