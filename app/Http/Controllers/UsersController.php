<?php

namespace App\Http\Controllers;

use App\Filters\UserFilters;
use App\Http\Requests\AvatarUploadRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $input = $request->validated();
        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }
        $user = Auth::user();
        $user->update($input);
        return response()->json($user);
    }

    /**
     * Update user's avatar picture
     * 
     * @param  \App\Http\Requests\AvatarUploadRequest  $uploadRequest
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar(AvatarUploadRequest $uploadRequest)
    {
        $user = Auth::user();
        $filename = Storage::disk('public')->put('photos', $uploadRequest->avatar);
        $user->update(['avatar' => $filename]);
        return $user;
    }
}
