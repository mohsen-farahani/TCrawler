<?php

declare (strict_types = 1);


namespace Mfarahani\TCrawl;

use Illuminate\Support\ServiceProvider;

class TCrawlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include_once __DIR__ . "/TCrawler.php";
    }
}
