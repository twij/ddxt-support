<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Ddxt\Support\Repository\Constraint\Constrainable;
use Ddxt\Support\Repository\Repository;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelConstrainableRepositoryInterface;

class ModelConstrainableRepository extends Repository implements ModelConstrainableRepositoryInterface
{
    use Constrainable;

    /**
     * Define model class
     *
     * @return string  Model qualified class
     */
    public function model(): string
    {
        return Model::class;
    }
}
