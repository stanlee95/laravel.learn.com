<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';
    protected $fillable = ['started_at', 'finished_at', 'status'];

	/**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){

        return $this->hasMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_projects(){

        return $this->belongsTo('App\Models\UserProject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposed_project(){

        return $this->hasOne('App\Models\ProposedProject');
    }
}
