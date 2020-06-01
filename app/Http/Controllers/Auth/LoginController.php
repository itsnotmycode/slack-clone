<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\JwtDecode;
use App\Http\Controllers\Controller;
use App\Notifications\OauthPasswordNotification;
use App\Services\Oauth\FacebookService;
use App\Services\Oauth\GoogleService;
use App\Services\Oauth\WpService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function oauth($service)
    {
        switch ($service) {
            case 'google': $url = GoogleService::generateOauthUri(); break;
            case 'facebook': $url = FacebookService::generateOauthUri(); break;
            case 'wordpress': $url = WpService::generateOauthUri(); break;
            default:
                return redirect('/')->with('error', 'This service is not exists.');
        }

        return redirect($url);
    }

    public function callback(Request $request, $service)
    {
        if($request->get('error')){
            return redirect('/')->with('error', 'Error: ' . $request->get('error'));
        }

        switch($service){
            case 'google':
                $token = GoogleService::authorizeClient($request->get('code'));
                $service_user = GoogleService::getUser($token);
                $user = User::where('email', $service_user->email)->first();
                break;
            case 'wp':
                $token = WpService::authorizeClient($request->get('code'));
                $service_user = WpService::getUser($token);
                $user = User::where('email', $service_user->email)->first();
                break;
            case 'facebook':
                $token = FacebookService::authorizeClient($request->get('code'));
                $service_user = FacebookService::getUser($token);
                $user = User::where('email', $service_user->email)->first();
                break;
            default:
                return redirect('/')->with('error', 'This service is not exists.');
        }
        if(!empty($user)){
            auth()->login($user);
            return redirect()->to($this->redirectTo);
        } else {
            $userPassword = Str::random(8);
            $user = User::create([
                'name' => isset($service_user->name) ? $service_user->name : $service_user->display_name,
                'email' => $service_user->email,
                'password' => Hash::make($userPassword)
            ]);
            $user->markEmailAsVerified();
//            event(new Verified($user));
            auth()->login($user);
            $user->notify(new OauthPasswordNotification($userPassword));
            return redirect()->to($this->redirectTo);
        }

    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }
}
