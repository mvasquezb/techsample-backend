<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        $success['token'] =  $user->createToken('AppName')->accessToken;
        $success['user'] = $user;
        return response()->json($success, $this->createSuccessStatus);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('AppName')->accessToken;
            $success['user'] = $user;
            return response()->json($success, $this->successStatus);
        } else {
            return response()->json(['errors' => 'Unauthorized'], 401);
        }
    }

    public function getUser()
    {
        if (!Auth::check()) {
            return response()->json(['errors' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        return response()->json($user, $this->successStatus);
    }

    public function showLogin()
    {
        return response()->json([
            'errors' => 'Login only allowed through API',
        ], 400);
    }
}
