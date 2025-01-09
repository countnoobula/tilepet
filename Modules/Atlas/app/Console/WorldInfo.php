<?php

namespace Modules\Atlas\Console;

use App\Traits\ConsoleComponents;
use Modules\Atlas\Models\World;
use Modules\Atlas\Events\WorldGenerate;
use Illuminate\Console\Command;
use function Laravel\Prompts\{ select, text, confirm };

class WorldInfo extends Command
{
    use ConsoleComponents;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'world:info';

    /**
     * The console command description.
     */
    protected $description = 'Create a world for Noobs to inhabit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->renderHeader();

        $world_count = World::count();
        if ($world_count == 0) {
            info('No worlds exist, please create one.');
        } elseif ($world_count == 1) {
            $world_id = World::first()->id;
        } else {
            $options = [];

            World::each(function ($world) use (&$options) {
                $options[$world->id] = $world->name;
            });

            $world_id = select(
                label: 'Which world do you want to view?',
                options: $options,
            );
        }

        $world = World::find($world_id);

        $this->info('Name: ' . $world->name);
        $this->info('Story: ' . $world->back_story);
    }
}
