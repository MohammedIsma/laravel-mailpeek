<?php

namespace Misma\MailPeek;

use Illuminate\Support\ServiceProvider;

class MailPeekProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadViewsFrom( __DIR__ . "/Views", "laravel-mailpeek");
        $this->publishes([
            __DIR__ . "/mailpeek-config.php" => config_path("mailpeek"),
            __DIR__ . "/Assets" => public_path(),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $enabled_environs = is_array($this->app['config']['mailpeek.enabled_environments']) ? $this->app['config']['mailpeek.enabled_environments'] : ["local"];
        
        if(in_array( env("APP_ENV") , $enabled_environs)){
            include __DIR__ . "/routes.php";
            $this->app->make("Misma\MailPeek\Controllers\MailPeekController");
            $this->mergeConfigFrom( __DIR__ . "/mailpeek-config.php", "mailpeek");
        }

    }
}
