<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Tilepet for simulation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');

        $this->info('Database initialized.');

        Artisan::call('world:create', [
            '--size' => 100,
            '--keywords' => 'sunny,island,tropical',
        ]);
        $this->info('World generated.');
    }
}
