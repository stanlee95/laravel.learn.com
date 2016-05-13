<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Input;


class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guest()){
            return back()->with('status', 'Authorized, please!');
        }

        if($uri = $request->path() != 'admin-panel/user-profile') {
            return view('user.index');
        }else{
            return view('admin.profile');
        }

    }

    public function change()
    {
        $user = User::find(Auth::user()->id);
        $image = Input::file('avatar');
        if(isset($image)){
            $image_upload = User::uploadAvatar($image, $user->name);
        }else{
            return back()->with('status', 'Select image!');
        }
        $user->avatar = $image_upload;
        if($user->save())
        {
            return back()->with('status', 'Image upload!');
        }
        else{
            return back()->with('status', 'Error!');
    }

    }
}
