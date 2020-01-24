<?php

namespace App;

use App\Filters\Traits\FilterableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, FilterableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address1',
        'address2', 'gender', 'city', 'country',
        'zipCode', 'userType', 'gameTitle', 'gamertag',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'avatar'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Gets the user's avatar url
     * 
     * @return string
     */
    public function getAvatarUrlAttribute() {
        return filter_var($this->avatar, FILTER_VALIDATE_URL) === FALSE
                ? Storage::url($this->avatar)
                : $this->avatar;
    }
}
