<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;


class StartProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:start {--refresh : Full project refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to start or refresh a Laravel project';

    public function handle():void
    {
        // If the --refresh option is provided, perform a full refresh
        if ($this->option('refresh')) {
            $this->info('Performing full project refresh...');
            $this->refreshProject();
        } else {
            $this->info('Starting the project...');
            $this->startProject();
        }
    }

    /**
     * Starting the project.
     */
    private function startProject():void
    {

        $this->info('Generating application key...');
        $this->call('key:generate');
        $this->info('Generating storage link...');
        $this->call('storage:link');

        $this->info('Running migrations...');
        $this->call('migrate');
        $this->info('Running seeders...');
        $this->call('db:seed');

        $this->info('Caching optimize clear...');
        $this->call('optimize:clear');
        $this->info('Caching optimize...');
        $this->call('optimize');

        $this->call('sitemap:generate');

        $this->info('Start queue work...');
        $this->call('queue:work');

        $this->info('Project started successfully!');
    }

    /**
     * Full project refresh.
     */
    private function refreshProject():void
    {

        $this->info('Running migrations refresh...');
        $this->call('migrate:fresh');
        $this->info('Running seeders refresh...');
        $this->call('db:seed');

        $this->info('Caching optimize clear...');
        $this->call('optimize:clear');
        $this->info('Caching optimize...');
        $this->call('optimize');

        $this->call('sitemap:generate');

        $this->info('Start queue work...');
        $this->call('queue:work');

        $this->info('Project refresh completed!');
    }
}
