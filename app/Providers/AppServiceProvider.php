<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $modules = config('module.modules');

        foreach ($modules as $module => $enabled) {
            if ($enabled) {
                $moduleProvider = "\\Modules\\$module\\Providers\\{$module}ServiceProvider";
                if (class_exists($moduleProvider)) {
                    $this->app->register($moduleProvider);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
