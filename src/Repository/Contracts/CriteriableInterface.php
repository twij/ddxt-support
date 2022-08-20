<?php

namespace Ddxt\Support\Repository\Contracts;

use Ddxt\Support\Repository\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface CriteriableInterface
{
    /**
     * Skip the criteria
     *
     * @param  bool  $skip  Skip status
     *
     * @return self  Self; chainable
     */
    public function skipCriteria($skip = true): self;

    /**
     * Return the criteria collection
     *
     * @return  Collection  Criteria collection
     */
    public function getCriteria(): Collection;

    /**
     * Reset the criteria stack
     *
     * @return void
     */
    public function resetCriteria(): void;

    /**
     * Get entries by criteria
     *
     * @param  Criteria  $criteria  Criteria to apply
     *
     * @return Builder   Builder collection with $criteria applied
     */
    public function getByCriteria(Criteria $criteria): Builder;

    /**
     * Add a criteria to the collection
     *
     * @param  Criteria  $criteria  Criteria to apply
     *
     * @return self      Self; chainable
     */
    public function pushCriteria(Criteria $criteria): self;

    /**
     * Apply the criteria to the repository's model
     *
     * @return  self  Self; chainable
     */
    public function applyCriteria(): self;
}