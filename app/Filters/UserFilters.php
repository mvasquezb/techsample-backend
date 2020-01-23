<?php

namespace App\Filters;

use App\Gender;
use App\UserType;
use Illuminate\Http\Request;
use Mykeels\Filters\BaseFilters;

class UserFilters extends BaseFilters
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function gender($term)
    {
        return $this->builder->whereEnum('gender', [Gender::make(strval($term))]);
    }

    public function type($term)
    {
        return $this->builder->whereEnum('userType', [UserType::make(strval($term))]);
    }

    public function country($term)
    {
        return $this->builder->where('country', 'LIKE', "'$term'");
    }

    public function city($term)
    {
        return $this->builder->where('city', 'LIKE', "'$term'");
    }

    public function address($term)
    {
        return $this->builder->where('address1', 'LIKE', "'$term'");
    }

    public function gamertag($term)
    {
        return $this->builder->where('gamertag', 'LIKE', "'$term'");
    }

    public function byCountry()
    {
        return $this->builder->groupBy('country');
    }

    public function byGender()
    {
        return $this->builder->groupBy('gender');
    }

    public function byCity()
    {
        return $this->builder->groupBy('city');
    }

    public function byType()
    {
        return $this->builder->groupBy('userType');
    }

    public function gametitle($term)
    {
        return $this->builder
            ->whereEnum('userType', [UserType::developer()])
            ->where('gameTitle', 'LIKE', "'$term'");
    }

    public function count()
    {
        return $this->builder->count();
    }
}
