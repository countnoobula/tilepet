<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\WorldTickJob;

class WorldTick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'world:tick';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes a world tick representing one day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Processing a world tick (one day)...');

        WorldTickJob::dispatch();

        $this->info('World tick dispatched successfully.');

        return 0;
    }
}
