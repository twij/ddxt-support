<?php

namespace Ddxt\Support\Tests\Examples\Repository\Criteria;

use Ddxt\Support\Repository\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;

class IdMoreThanCriteria extends Criteria
{
    /**
     * Number that the entry's id should be higher than
     */
    protected int $number;

    /**
     * Limits results to ids greater than a number
     *
     * @param  null|int  $number  Number that the entry's id should be higher than 
     */
    public function __construct(?int $number = null)
    {
        $this->number = $number;

        if (! isset($this->number)) {
            $this->skip = true;
        }
    }

    /**
     * Apply the criteria
     *
     * @param  Model    $model  Model instance
     *
     * @return Builder  Query builder
     */
    public function apply($model): Builder
    {
        return $model->where('id', '>', $this->number);
    }
}
