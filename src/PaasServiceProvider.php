<?php

namespace GjrDiesel\LaravelPaas;

use Illuminate\Support\ServiceProvider;

class PaasServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path(),
        ],'paas');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupForPaas::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
