<?php

namespace Ddxt\Support\Repository\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ddxt\Support\Repository\Contracts\CriteriaInterface;

class Criteria implements CriteriaInterface
{
    /**
     * Will be skipped if true
     */
    public bool $skip = false;

    /**
     * Array of support tables
     */
    protected ?array $supported = null;

    /**
     * Apply the criteria
     *
     * @param  Model    $model  Model instance
     *
     * @return Builder  Query builder
     */
    public function apply($model): Builder
    {
        return $model->get();
    }

    /**
     * Check if criteria is supported
     *
     * @param  Model    $model  Model instance
     *
     * @return boolean  True if no requirements or table is in $supported array
     */
    public function supported($model): bool
    {
        if (! isset($this->supported)) {
            return true;
        }

        if (in_array($model->make()->getTable(), $this->supported)) {
            return true;
        }

        return false;
    }
}
