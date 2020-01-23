<?php

namespace App\Filters;

use App\Gender;
use Mykeels\Filters\BaseFilters;

class UserFilters extends BaseFilters
{
    public function gender($term) {
        return $this->builder->whereEnum('gender', [Gender::make($term)]);
    }
}
