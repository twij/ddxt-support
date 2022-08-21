<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Ddxt\Support\Repository\Criteria\Criteriable;
use Ddxt\Support\Repository\Repository;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelCriteriableRepositoryInterface;

class ModelCriteriableRepository extends Repository implements ModelCriteriableRepositoryInterface
{
    use Criteriable;

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
