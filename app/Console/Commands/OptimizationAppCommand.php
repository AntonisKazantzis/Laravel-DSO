<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizationAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs various Artisan commands to clear, cache and optimize files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commands = [
            'view:clear',
            'view:cache',
            'route:clear',
            'route:cache',
            'icons:clear',
            'icons:cache',
            'event:clear',
            'event:cache',
            'config:clear',
            'config:cache',
        ];

        foreach ($commands as $command) {
            $this->info("Running: php artisan {$command}");
            $this->call($command);
        }

        $this->info('All specified commands have been executed.');
    }
}
