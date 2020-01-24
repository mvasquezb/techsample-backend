<?php

namespace App\Http\Controllers;

use App\Filters\UserFilters;
use App\Http\Requests\AvatarUploadRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\UserFilters $filters
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserFilters $filters)
    {
        return User::filter($filters)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Http\Requests\AvatarUploadRequest  $uploadRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, AvatarUploadRequest $uploadRequest)
    {
        $input = $request->validated();
        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }
        $user = Auth::user();
        $user->update($input);
        // $filename = $uploadRequest->file('avatar')->store('photos');
        // $user->avatar = $filename;
        // $user->save();
        return response()->json($user);
    }
}
