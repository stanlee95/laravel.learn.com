<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Projects;
use App\Models\ProposedProjects;
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
     * @param Request $request
     *
     * @return Response;
     */
    public function edit(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            array(
                'title'                 => $data['title'],
                'description'           => $data['content_full'],
            ),
            array(
                'title'    => 'required|min:3',
                'description'  => 'required|min:3|max:400',
            )
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if ($data['project_id'] != null) {
            $assign = ProposedProjects::where('id', '=', $data['id']);
            $assign->update(
                [
                    'title'                 => $data['title'],
                    'software_requirements' => $data['software'],
                    'recomended_literature' => $data['literature'],
                    'description'           => $data['content_full'],
                ]
            );

            return back()->with('status', 'Project Updated');
        } else {

            $project = new Projects();

            \DB::beginTransaction();

            try {
                $project->save();
                $projects                        = new ProposedProjects();
                $projects->title                 = $data['title'];
                $projects->description           = $data['content_full'];
                $projects->software_requirements = $data['software'];
                $projects->recomended_literature = $data['literature'];
                $project->proposed_project()->save($projects);
            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }

            \DB::commit();

            return back()->with('status', 'Project was created');
        }
    }

    /**
     * @param int $id
     *
     * @return Response;
     */
    public function delete($id)
    {
        if ((int)$id) {

            \DB::beginTransaction();

            try {
                \DB::table('proposed_projects')->where('project_id', '=', $id)->delete();
                \DB::table('user_project')->where('project_id', '=', $id)->delete();
                \DB::table('projects')->where('project_id', '=', $id)->delete();
            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }

            \DB::commit();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error']);
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
     * @param int $id
     *
     * @return Response;
     */
    public function getProject($id)
    {
        if ((int)$id) {
            if ($data = ProposedProjects::where('project_id', '=', $id)->first()) {
                return response()->json(['data' => $data]);
            } else {
                return response()->json(['status' => 'error']);
            }
        }

        return response()->json(['status' => 'error']);
    }

}