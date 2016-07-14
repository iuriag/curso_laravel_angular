<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;

class ClientProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\CodeProject\Repositories\ClientRepository::class,
                         \CodeProject\Repositories\ClientRepositoryEloquent::class);

        $this->app->bind(\CodeProject\Repositories\ProjectRepository::class,
            \CodeProject\Repositories\ProjectRepositoryEloquent::class);

    }

    /**
    * Get the services provided by the provider.
    *
    * @return array
    */
    public function provides()
    {
        return ['\CodeProject\Repositories\ClientRepository'];
    }

}
