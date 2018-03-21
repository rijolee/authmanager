<?php

namespace rijolee\AuthManager;

use Illuminate\Support\ServiceProvider;

class AuthManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        include __DIR__.'/routes.php';

        $this->app->make('rijolee\AuthManager\Controller\AuthManagerController');
        $this->app->make('rijolee\AuthManager\Controller\MenusController');
        $this->app->make('rijolee\AuthManager\Controller\EventsController');
        $this->app->make('rijolee\AuthManager\Controller\MenusController');
        $this->app->make('rijolee\AuthManager\Controller\EventMenusController');
        $this->app->make('rijolee\AuthManager\Controller\UserGroupController');
        
        
        
        $this->loadViewsFrom(__DIR__.'/views','authmanager');
        $this->publishes([
        __DIR__.'/views' => resource_path('views/vendor/authmanager'),
        ]);

        $this->publishes([
        __DIR__.'/views/asset' => public_path('vendor/authmanager'),
        ], 'public');


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';

        $this->app->make('rijolee\AuthManager\Controller\AuthManagerController');
        $this->app->make('rijolee\AuthManager\Controller\MenusController');
        $this->app->make('rijolee\AuthManager\Controller\EventsController');
        $this->app->make('rijolee\AuthManager\Controller\MenusController');
        $this->app->make('rijolee\AuthManager\Controller\EventMenusController');
        $this->app->make('rijolee\AuthManager\Controller\UserGroupController');
        
        
        
        
        $this->loadViewsFrom(__DIR__.'/views','authmanager');



    }
}
