<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user in
     * 
     * @param Requestt $request
     */
    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        return bcrypt($password);

        $user = User::where([
            ['email', '=', $email],
            ['password', '=', Hash::make($password)],
        ])->get();
        
        if ($user->isEmpty()) {
            return response(
                [
                    "message" => "Invalid user credentials",
                ],
                404
            );
        }

        return $user;
    }
}
