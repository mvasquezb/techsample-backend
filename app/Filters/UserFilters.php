<?php

namespace App\Filters;

use App\Gender;
use App\UserType;
use Illuminate\Http\Request;

class UserFilters extends BaseFilters
{
    public function gender($term)
    {
        return $this->builder->where('gender', '=', "$term");
    }

    public function type($term)
    {
        return $this->builder->where('userType', '=', "$term");
    }

    public function country($term)
    {
        return $this->builder->where('country', 'LIKE', "$term");
    }

    public function city($term)
    {
        return $this->builder->where('city', 'LIKE', "$term");
    }

    public function address($term)
    {
        return $this->builder->where('address1', 'LIKE', "$term");
    }

    public function gamertag($term)
    {
        return $this->builder->where('gamertag', 'LIKE', "$term");
    }

    public function byCountry()
    {
        return $this->groupBy('country');
    }

    public function byGender()
    {
        return $this->groupBy('gender');
    }

    public function byCity()
    {
        return $this->groupBy('city');
    }

    public function byType()
    {
        return $this->groupBy('userType');
    }

    public function gametitle($term)
    {
        return $this->builder
            ->where('userType', '=', strval(UserType::developer()))
            ->where('gameTitle', 'LIKE', "'$term'");
    }

    // public function count()
    // {
    //     return $this->builder->count();
    // }
}
