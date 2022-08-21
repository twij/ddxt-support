<?php

namespace Ddxt\Support\Repository\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Ddxt\Support\Repository\Criteria\Criteria;

trait Criteriable
{
    /**
     * Collection of criteria that will be applied
     */
    protected Collection $criteria;

    /**
     * Skip criteria; set to true to ignore criteria
     */
    protected bool $skipCriteria = false;

    /**
     * Skip the criteria
     *
     * @param  bool  $skip  Skip status
     *
     * @return self  Self; chainable
     */
    public function skipCriteria($skip = true): self
    {
        $this->skipCriteria = $skip;
        return $this;
    }

    /**
     * Return the criteria collection
     *
     * @return  Collection  Criteria collection
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * Reset the criteria stack
     *
     * @return void
     */
    public function resetCriteria(): void
    {
        $this->criteria = new Collection();
        $this->skipCriteria(false);
    }

    /**
     * Get entries by criteria
     *
     * @param  Criteria  $criteria  Criteria to apply
     *
     * @return Builder   Builder collection with $criteria applied
     */
    public function getByCriteria(Criteria $criteria): Builder
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this->model->with($this->with);
    }

    /**
     * Add a criteria to the collection
     *
     * @param  Criteria  $criteria  Criteria to apply
     *
     * @return self      Self; chainable
     */
    public function pushCriteria(Criteria $criteria): self
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * Apply the criteria to the repository's model
     *
     * @return  self  Self; chainable
     */
    public function applyCriteria(): self
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                if (!isset($criteria->skip) || $criteria->skip === false) {
                    $this->model = $criteria->apply($this->model, $this);
                }
            }
        }

        return $this;
    }
}
