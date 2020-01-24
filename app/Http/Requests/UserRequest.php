<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UserRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed',
                    'address1' => 'required',
                    'gender' => [
                        'required',
                        Rule::in(config('business.genders')),
                    ],
                    'city' => 'required',
                    'country' => 'required',
                    'zipCode' => 'required',
                    'userType' => [
                        'required',
                        Rule::in(config('business.userTypes')),
                    ],
                    'gameTitle' => 'required',
                    'gamertag' => 'required|unique:users,gamertag',
                ];
            case 'PUT':
                return [
                    'name' => 'filled',
                    'email' => 'filled|email|unique:users,email',
                    'password' => 'filled|confirmed',
                    'address1' => 'filled',
                    'gender' => Rule::in(config('business.genders')),
                    'city' => 'filled',
                    'country' => 'filled',
                    'zipCode' => 'filled',
                    'userType' => Rule::in(config('business.userTypes')),
                    'gameTitle' => 'filled',
                    'gamertag' => 'filled|unique:users,gamertag',
                ];
            default:
                break;
        }
        return [];
    }
}
