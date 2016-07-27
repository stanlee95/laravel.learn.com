<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'card_id' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function _validatorLogin(array $data)
    {
        return Validator::make($data, [
            'card_id' => 'required|max:255',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        if (isset($data['avatar'])) {
            $data['avatar'] = User::uploadAvatar($data['avatar'], $data['name']);
        }

        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->throwValidationException(
                $data,
                $validator
            );
        }
        $user = User::where('card_id', '=', $data['card_id'])->where('password', '=', md5($data['password']))
            ->first();
        if ($user) {
            Auth::login($user);

            return back()->with('status', 'User is exist!');
        }

        return User::create(
            [
                'card_id'  => $data['card_id'],
                'password' => md5($data['password']),
                'avatar'   => isset($data['avatar']) ? $data['avatar'] : null,
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request $request
     *
     * @return User|boolean
     */
    public function login(Request $request)
    {
        if ($data = $request->all()) {

            $validator = $this->_validatorLogin($data);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request,
                    $validator
                );
            }
            $user = User::where('card_id', '=', $data['card_id'])->where('password', '=', md5($data['password']))
                ->first();
            if ($user) {
                Auth::login($user);

                return back()->with('status', 'You have logined!');
            } else {
                return back()->with('status', 'Check your credentials!');
            }
        }

        return true;
    }

    public function callbackEmailSave()
    {
        $user = new User();
        $user->card_id = Input::get('card_id');
        $user->avatar = Input::get('avatar');

        if ($user->save()) {
            Auth::login($user);
//            Mail::send('emails.confirm', array('email' => $user->email), function($message) {
//                $message->from('bond9555@gmail.com', 'Site Admin');
//                $message->to('bond_95@mail.ru.ru', 'user_name_bottom')->subject('Welcome to My Laravel app!');
//            });
            return redirect('/');
        } else {
            return redirect('/');
        }

    }
}