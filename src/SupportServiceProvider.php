<?php

namespace Ddxt\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{

    /**
     * Publishes config file
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
            __DIR__.'/../config/support.php'
                => config_path('support.php'),
            ],
            'support'
        );
    }
    
    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/support.php',
            'support'
        );
    }
}