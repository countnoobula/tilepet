<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing random thoughts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $entities = config('tilepet.entities');


    }
}
