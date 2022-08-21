<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Ddxt\Support\Repository\Criteria\Constrainable;
use Ddxt\Support\Repository\Criteria\Criteriable;
use Ddxt\Support\Repository\Repository;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelScopableRepositoryInterface;

class ModelScopableRepository extends Repository implements ModelScopableRepositoryInterface
{
    use Criteriable, Constrainable;

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
