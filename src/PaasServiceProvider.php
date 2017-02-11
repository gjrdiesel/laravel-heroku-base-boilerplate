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
        $this->setupFromDatabaseUrl();

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

    private function setupFromDatabaseUrl()
    {
        $db_url = env('DATABASE_URL');

        if(!$db_url){
            return;
        }

        $db = parse_url($db_url);

        $rewrite_schemes = [
            'postgres' => 'pgsql'
        ];

        if(isset($rewrite_schemes[$db['scheme']])){
            $db['scheme'] = $rewrite_schemes[$db['scheme']];
        }

        $db_config = [
            'DB_CONNECTION' => $db['scheme'],
            'DB_HOST' => $db['host'],
            'DB_PORT' => $db['port'],
            'DB_USERNAME' => $db['user'],
            'DB_PASSWORD' => $db['pass'],
            'DB_DATABASE' => str_replace('/','',$db['path'])
        ];

        foreach($db_config as $key=>$value){
            putenv($key.'='.$value);
            $_SERVER[$key] = $value;
        }
    }
}
