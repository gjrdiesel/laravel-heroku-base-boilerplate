<?php

namespace GjrDiesel\LaravelPaas;

use Illuminate\Console\Command;

class SetupForPaas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paas:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Basic boilerplate stuff to get laravel running on heroku';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn('1) Exposing files');
        $this->call('vendor:publish',['--tag'=>'paas']);
        $this->warn('2) Modifying composer.json');
        $this->modifyComposerFile();
        $this->warn('3) Setting up database parser');
        $this->setupDatabaseParser();
        $this->info("\nSetup complete!");
    }

    public function modifyComposerFile()
    {
        $composer = file_get_contents(base_path('composer.json'));
        $settings = json_decode($composer,true);

        $newCommands = [
            "php -r \"file_exists('.env') || copy('.env.example', '.env');\"",
            "php artisan key:generate",
            "php artisan migrate"
        ];

        $added = 0;

        foreach($newCommands as $command){
            if(!in_array($command,$settings['scripts']['post-install-cmd'])){
                $settings['scripts']['post-install-cmd'][] = $command;
                $added++;
            }
        }

        file_put_contents(base_path('composer.json'),json_encode($settings,JSON_PRETTY_PRINT));

        $this->info(sprintf('Added %s commands to composer.json',$added));

    }

    public function setupDatabaseParser()
    {
        $this->error('This has not been implemented yet -- please see github issue:');
        $this->warn('https://github.com/gjrdiesel/laravel-heroku-base-boilerplate/issues/1');
    }
}
