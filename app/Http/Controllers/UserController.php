<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;

class UserController extends Controller
{


    /**
     * @param Request $request
     *
     * @return View;
     */
    public function index(Request $request)
    {
        if (Auth::guest()) {
            return back()->with('status', 'Authorized, please!');
        }

        if ($uri = $request->path() != 'admin-panel/user-profile') {
            $userProjects = (User::getUserProjects(Auth::user()->id) != null) ? User::getUserProjects(Auth::user()->id) : null;

            return view('user.index', ['projects' => $userProjects]);
        } else {
            return view('admin.profile');
        }
    }

    /**
 *
 * @return Response;
 */
    public function change()
    {
        $user  = User::find(Auth::user()->id);
        $image = Input::file('avatar');
        if (isset($image)) {
            $image_upload = User::uploadAvatar($image, $user->name);
        } else {
            return back()->with('status', 'Select image!');
        }
        $user->avatar = $image_upload;
        if ($user->save()) {
            return back()->with('status', 'Image upload!');
        } else {
            return back()->with('status', 'Error!');
        }
    }

    /**
     * @param Request $request
     *
     * @return Response;
     */
    public function status(Request $request)
    {
        $now  = date("Y-m-d H:i:s");
        $data = $request->all();
        if ($data) {
            $project = Projects::where('project_id', '=', $data['project_id']);

            switch ($data['status']) {
                case 'todo' :
                    $project->update(
                        [
                            'status'     => $data['status'],
                            'started_at' => $now,
                        ]
                    );
                    break;
                case 'done' :
                    $project->update(
                        [
                            'status'     => $data['status'],
                            'finished_at' => $now,
                        ]
                    );
                    break;
                case 'problem' :
                    $project->update(
                        [
                            'status'     => $data['status']
                        ]
                    );
                    break;
            }
        }

        return response()->json(['status' => $data['status'], "project_id" => $data['project_id']]);
    }
}
