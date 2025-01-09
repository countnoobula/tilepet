<?php

namespace Modules\Adam\Console;

use Modules\Atlas\Models\World;
use Modules\Adam\Events\NoobGenerate;
use Illuminate\Console\Command;
use App\Traits\ConsoleComponents;

class NoobCreate extends Command
{
    use ConsoleComponents;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noob:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Noob';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->renderHeader();

        $world = World::first();

        $this->line('Creating Noob in `' . $world->name . '`');
        event(new NoobGenerate($world));
    }
}
