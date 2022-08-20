<?php

namespace Ddxt\Support\Repository\Contracts;

interface CriteriaInterface
{
    /**
     * Apply the criteria
     *
     * @param  Model    $model  Model instance
     *
     * @return Builder  Query builder
     */
    public function apply($model): \Illuminate\Database\Eloquent\Builder;

    /**
     * Check if criteria is supported
     *
     * @param  Model    $model  Model instance
     *
     * @return boolean  True if no requirements or table is in $supported array
     */
    public function supported($model): bool;
}
