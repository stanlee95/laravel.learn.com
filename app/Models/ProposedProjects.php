<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposedProjects extends Model
{
    protected $table = 'proposed_projects';
    protected $fillable = ['project_id', 'title', 'description', 'software_requirements', 'recomended_literature'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){

        return $this->hasMany('App\Models\Projects');
    }
}
