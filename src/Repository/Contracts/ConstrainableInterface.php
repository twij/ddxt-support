<?php

namespace Ddxt\Support\Repository\Contracts;

use Illuminate\Support\Collection;

interface ConstrainableInterface
{
    /**
     * Add a constraint to the repository
     * $this->model will be passed in and must be returned
     *
     * @param  Callable  $constraint  Constraint function
     *
     * @return self      Self; chainable
     */
    public function pushConstraint(Callable $constraint): self;

    /**
     * Return collection of constraints active on the repository
     *
     * @return Collection  The constraints collection
     */
    public function getConstraints(): Collection;

    /**
     * Reset constraint stack
     *
     * @return void
     */
    public function resetConstraints(): void;

    /**
     * Skip the constraints
     *
     * @param  bool             $skip  True to skip, false to apply
     *
     * @return self  Self; chainable
     */
    public function skipConstraints($skip = true): self;

    /**
     * Apply the constraints to the model
     *
     * @return self  Self; chainable
     */
    public function applyConstraints(): self;
}