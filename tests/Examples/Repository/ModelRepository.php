<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Ddxt\Support\Repository\Repository;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelRepositoryInterface;

class ModelRepository extends Repository implements ModelRepositoryInterface
{
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
