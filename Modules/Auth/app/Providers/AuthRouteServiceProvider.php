<?php

namespace Modules\Auth;

use Illuminate\Support\ServiceProvider;

class AuthRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'auth');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    public function register()
    {
        // Register any bindings or singletons here
    }
}



?>