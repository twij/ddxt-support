<?php

namespace Ddxt\Support\Tests\Examples\Repository\Contracts;

use Ddxt\Support\Repository\Contracts\ConstrainableInterface;
use Ddxt\Support\Repository\Contracts\CriteriableInterface;
use Ddxt\Support\Repository\Contracts\RepositoryInterface;

interface ModelScopableRepositoryInterface extends RepositoryInterface, CriteriableInterface, ConstrainableInterface
{
    
}
