<?php

namespace App\Http\Controllers;

use App\Gender;
use App\User;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'name' => '',
                'email' => 'email|unique:users,email',
                'gender' => 'enum_name:' . Gender::class,
                'userType' => 'enum_name:' . UserType::class,
                'gamertag' => 'unique:users,gamertag',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }
        $user = Auth::user()->update($input);
        $success['user'] = $user;
        return response()->json([
            'success' => true,
            'data' => $success,
        ]);
    }
}
