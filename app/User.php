<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Enum\Laravel\HasEnums;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    use HasEnums;

    /**
     * The attributes that are enums
     * @var array 
     */
    protected $enums = [
        'gender' => Gender::class,
        'userType' => UserType::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address1',
        'address2', 'gender', 'city', 'country',
        'zipCode', 'userType', 'gameTitle', 'gamertag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getApiTokenAttribute()
    {
        return $this->attributes['api_token'];
    }
}
