<?php

namespace Ddxt\Support\Repository\Constraint;

use Illuminate\Support\Collection;

trait Constrainable
{
    /**
     * Collection of constraints
     *
     * @var Collection
     */
    protected Collection $constraints;

    /**
     * Constraints will be skipped if true
     *
     * @var bool
     */
    protected bool $skipConstraints = false;

    /**
     * Add a constraint to the repository
     * $this->model will be passed in and must be returned
     *
     * @param  Callable  $constraint  Constraint function
     *
     * @return self      Self; chainable
     */
    public function pushConstraint(Callable $constraint): self
    {
        $this->constraints->push($constraint);
        return $this;
    }

    /**
     * Return collection of constraints active on the repository
     *
     * @return Collection  The constraints collection
     */
    public function getConstraints(): Collection
    {
        return $this->constraints;
    }

    /**
     * Reset constraint stack
     *
     * @return void
     */
    public function resetConstraints(): void
    {
        $this->constraints = new Collection();
        $this->skipConstraints(false);
    }

    /**
     * Skip the constraints
     *
     * @param  bool             $skip  True to skip, false to apply
     *
     * @return self  Self; chainable
     */
    public function skipConstraints($skip = true): self
    {
        $this->skipConstraints = $skip;
        return $this;
    }

    /**
     * Apply the constraints to the model
     *
     * @return self  Self; chainable
     */
    public function applyConstraints(): self
    {
        if ($this->skipConstraints === true) {
            return $this;
        }

        foreach ($this->getConstraints() as $constraint) {
            if (is_callable($constraint)) {
                $this->model = $constraint($this->model);
            }
        }

        return $this;
    }
}
