<?php

namespace App\Filters\Traits;

use App\Filters\BaseFilters;
use Mykeels\Filters\Traits\FilterableTrait as BaseFilterableTrait;

trait FilterableTrait {
    use BaseFilterableTrait;

    /**
     * Applies filters to the scoped query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\BaseFilters $filters
     * @param array $extraFilters
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection
     */
    public function scopeFilterGet($query, BaseFilters $filters, array $extraFilters = null)
    {
        return $filters->applyAndGet($query, $extraFilters);
    }
}