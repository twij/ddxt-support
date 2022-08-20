<?php

namespace Ddxt\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Ddxt\Support\Contracts\RepositoryInterface;
use Ddxt\Support\Repository\Repository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
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
