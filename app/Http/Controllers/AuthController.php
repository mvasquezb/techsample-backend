<?php

namespace App\Http\Controllers;

use App\Gender;
use App\User;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'address1' => 'required',
                'gender' => 'required|in:' . implode(',', Gender::getValues()),
                'city' => 'required',
                'country' => 'required',
                'zipCode' => 'required',
                'userType' => 'required|in:' . implode(',', UserType::getValues()),
                'gameTitle' => 'required',
                'gamertag' => 'required|unique:users,gamertag',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('AppName')->accessToken;
        $success['user'] = $user;
        return response()->json([
            'success' => true,
            'data' => $success,
        ], $this->successStatus);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('AppName')->accessToken;
            $success['user'] = $user;
            return response()->json([
                'success' => true,
                'data' => $success,
            ], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function getUser()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        return response()->json(['data' => $user], $this->successStatus);
    }

    public function showLogin()
    {
        return response()->json([
            'errors' => 'Login only allowed through API',
        ], 400);
    }
}
