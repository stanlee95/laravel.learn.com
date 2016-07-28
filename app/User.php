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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function projects()
    {
        return $this->hasMany('App\Models\UserProject');
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getUserProjects($id)
    {
        $users = \DB::table('projects')
            ->select('users.id',
                'users.card_id',
                'projects.project_id',
                'projects.status',
                'projects.started_at',
                'projects.finished_at',
                'proposed_projects.title',
                'proposed_projects.description',
                'proposed_projects.software_requirements',
                'proposed_projects.recomended_literature')
            ->leftJoin('proposed_projects', 'projects.project_id', '=', 'proposed_projects.project_id')
            ->join('user_project', 'projects.project_id', '=', 'user_project.project_id')
            ->join('users', 'user_project.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->get();

        return $users;
    }
}
