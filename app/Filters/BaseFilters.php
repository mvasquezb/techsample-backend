<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mykeels\Filters\BaseFilters as LibBaseFilters;

class BaseFilters extends LibBaseFilters
{
    protected $count = false;
    protected $groupBy = false;
    protected $groupingFields = [];

    public function groupBy(string $field)
    {
        $this->groupBy = true;
        $this->groupingFields[] = $field;
        return $this->builder->groupBy($field);
    }

    /**
     * Applies respective filter methods declared in the subclass
     * that correspond to fields in request query parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $extraFilters
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection
     */
    public function applyAndGet(Builder $builder, array $extraFilters = null)
    {
        $this->builder = $this->apply($builder, $extraFilters);

        $collection = $this->builder->get();
        if ($this->groupBy) {
            $collection = $collection->groupBy(...$this->groupingFields);
        }
        if ($this->count) {
            return $collection->count();
        }
        return $collection;
    }

    public function count()
    {
        $this->count = true;
    }
}
