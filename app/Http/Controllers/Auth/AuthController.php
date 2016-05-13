<?php

namespace App\Http\Controllers\Auth;

//use Illuminate\Http\Request;
use App\Http\Request;
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => md5($data['password']),
            'avatar' => $data['avatar'],
        ]);
    }

    public function callbackEmailSave()
    {
        $user = new User();
        $user->name = Input::get('name');
        $user->facebook_id = Input::get('facebook_id');
        $user->odno_id = Input::get('odno_id');
        $user->email = Input::get('email');
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

//------------------facebook-----------------------------
    public function facebookLogin()
    {

        return Socialite::with('facebook')->redirect();

    }

    public function facebookCallback()
    {

        try {
            $user = Socialite::with('facebook')->user();
        } catch (Exception $e) {

        }
        if (!$user->email) {

            $authUser = User::where('facebook_id', '=', $user->id)->first();
            if ($authUser) {
                Auth::login($authUser);
                return redirect('/');
            }

            return view('auth.check', ['user' => $user, 'social_name' => 'facebook_id']);
        }


        return redirect('/');
    }

//---------------------google-------------------------------
    public function googleLogin()
    {

        return Socialite::with('google')->redirect();
    }

    public function googleCallback()
    {

        try {

            $user = Socialite::with('google')->user();
        } catch (Exception $e) {

        }
        $authUser = $this->findOrCreateUserGoogle($user);
        Auth::login($authUser);

        return redirect('/');

    }

//--------------------yandex---------------------------------
    public function yandexLogin()
    {

        return Socialite::with('yandex')->redirect();
    }

    public function yandexCallback()
    {

        try {

            $user = Socialite::with('yandex')->user();
        } catch (Exception $e) {

        }

        $authUser = $this->findOrCreateUserYandex($user);
        Auth::login($authUser);

        return redirect('/');

    }

//---------------------------Mailru-----------------------------------------------------------------------------
    public function mailruLogin()
    {

        return Socialite::with('mailru')->redirect();
    }

    public function mailruCallback()
    {

        try {

            $user = Socialite::with('mailru')->user();
        } catch (Exception $e) {

        }

        $authUser = $this->findOrCreateUserMailru($user);
        Auth::login($authUser);

        return redirect('/');

    }

//------------------------------Odnoklasniki---------------------------------------------------------------------
    public function odnoLogin()
    {

        return Socialite::with('odnoklasniki')->redirect();
    }

    public function odnoCallback()
    {

        try {

            $user = Socialite::with('odnoklasniki')->user();
        } catch (Exception $e) {

        }

        if ($user->email) {
            $authUser = User::where('odno_id', '=', $user->id)->first();
            if ($authUser) {
                Auth::login($authUser);
                return redirect('/');
            }
            return view('auth.check', ['user' => $user, 'social_name' => 'odno_id']);
        }

        $authUser = $this->findOrCreateUserOdno($user);
        Auth::login($authUser);

        return redirect('/');
    }

//------------------------------------------------------------------------------------

    private function findOrCreateUserGoogle($googleUser)
    {

        $authUser = User::where('google_id', '=', $googleUser->user['id'])->first();

        if ($authUser) {
            return $authUser;
        }
        return $this->createUserGoogle($googleUser);

    }

    private function createUserGoogle($user)
    {

        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->user['id'],
            'avatar' => $user->avatar,
        ]);
        return $user;
    }

    private function findOrCreateUserYandex($yandexUser)
    {

        $authUser = User::where('yandex_id', '=', $yandexUser->user['id'])->first();

        if ($authUser) {
            return $authUser;
        }
        return $this->createUserYandex($yandexUser);

    }

    private function createUserYandex($user)
    {

        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'yandex_id' => $user->user['id'],
            'avatar' => $user->avatar,
        ]);

        return $user;
    }

    private function findOrCreateUserMailru($mailruUser)
    {

        $authUser = User::where('mail_id', '=', $mailruUser[0]['uid'])->first();
        if ($authUser) {
            return $authUser;
        }
        return $this->createUserMailru($mailruUser);

    }

    private function createUserMailru($user)
    {

        $user = User::create([
            'name' => $user[0]['nick'],
            'email' => $user[0]['email'],
            'mail_id' => $user[0]['uid'],
//            'avatar' => $user[0]['avatar'],
        ]);

        return $user;
    }

}