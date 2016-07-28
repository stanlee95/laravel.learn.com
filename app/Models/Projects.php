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

    /**
     * @return array
     */
    public static function getProjectList()
    {

        return \DB::table('projects')
            ->select(
                'projects.*',
                'proposed_projects.title',
                'proposed_projects.description',
                'proposed_projects.software_requirements',
                'proposed_projects.recomended_literature',
                'users.id',
                'users.card_id'
            )
            ->join('proposed_projects', 'projects.project_id', '=', 'proposed_projects.project_id')
            ->leftJoin('user_project', 'projects.project_id', '=', 'user_project.project_id')
            ->leftJoin('users', 'user_project.user_id', '=', 'users.id')
            ->get();
    }
}
