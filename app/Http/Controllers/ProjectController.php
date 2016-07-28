<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Projects;
use App\Models\UserProject;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Validator;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    /**
     *
     * @return View;
     */
    public function index()
    {
        $projects = Projects::getProjectList();
        $user = User::where('role', '!=', 'admin')->get();

        return view('admin.projects.index', ['projects'=>$projects, 'users' => $user]);
    }

    /**
     *
     * @return View;
     */
    public function edit()
    {

        return view('admin.index');
    }

    /**
     *
     * @return View;
     */
    public function delete()
    {

        return view('admin.index');
    }

    /**
     * @param Request $request
     *
     * @return Response;
     */
    public function assign(Request $request)
    {
        $data = $request->all();
        if ($data) {
            if (UserProject::where('project_id', '=', $data['project_id'])->first()){
                $assign = UserProject::where('project_id', '=', $data['project_id']);
                $assign->update(
                    [
                        'project_id' => $data['project_id'],
                        'user_id'    => $data['user_id'],
                    ]
                );
            } else {
                $userProject             = new UserProject();
                $userProject->user_id    = $data['user_id'];
                $userProject->project_id = $data['project_id'];
                $userProject->save();
            }
        }
        $user = User::where('id', '=', $data['user_id'])->first();
        $name = $user->card_id;

        return response()->json(['project_id' => $data['project_id'], 'name' => $name]);
    }

    /**
     *
     * @return Response;
     */
    public function getProject()
    {
        $data = $request->all();
        if ($data) {
            if (UserProject::where('project_id', '=', $data['project_id'])->first()){
                $assign = UserProject::where('project_id', '=', $data['project_id']);
                $assign->update(
                    [
                        'project_id' => $data['project_id'],
                        'user_id'    => $data['user_id'],
                    ]
                );
            } else {
                $userProject             = new UserProject();
                $userProject->user_id    = $data['user_id'];
                $userProject->project_id = $data['project_id'];
                $userProject->save();
            }
        }
        $user = User::where('id', '=', $data['user_id'])->first();
        $name = $user->card_id;

        return response()->json(['project_id' => $data['project_id'], 'name' => $name]);
    }

}