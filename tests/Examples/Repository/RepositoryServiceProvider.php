<?php

namespace Ddxt\Support\Tests\Examples\Repository;

use Illuminate\Support\ServiceProvider;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelConstrainableRepositoryInterface;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelCriteriableRepositoryInterface;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelRepositoryInterface;
use Ddxt\Support\Tests\Examples\Repository\Contracts\ModelScopableRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ModelRepositoryInterface::class, ModelRe::class);
        $this->app->bind(ModelCriteriableRepositoryInterface::class, ModelCriteriableRepository::class);
        $this->app->bind(ModelConstrainableRepositoryInterface::class, ModelConstrainableRepository::class);
        $this->app->bind(ModelScopableRepositoryInterface::class, ModelScopableRepositoryInterface::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
