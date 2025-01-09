<?php

namespace Modules\Atlas\Console;

use App\Traits\ConsoleComponents;
use Modules\Atlas\Models\World;
use Modules\Atlas\Events\WorldGenerate;
use Illuminate\Console\Command;
use function Laravel\Prompts\{ select, text, confirm };

class WorldCreate extends Command
{
    use ConsoleComponents;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'world:create {--size=} {--keywords=}';

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

        $size = $this->option('size');
        $keywords = $this->option('keywords') ?? '';
        $confirm = $size && $keywords;

        while (!$confirm) {
            $size = select(
                label: 'How big would you like the world to be?',
                options: [
                    '50' => 'Small',
                    '100' => 'Medium',
                    '200' => 'Large',
                ],
                default: $size,
            );

            $keywords = text(
                label: 'What keywords describe the world?',
                placeholder: 'e.g. sunny, island, tropical',
                required: true,
                default: $keywords,
            );

            $confirm = confirm(
                label: 'Are you sure you want to create a $size world that is $keywords?',
                default: true,
                yes: 'Yes',
                no: 'I want to make changes',
            );
        }

        $world = World::create([
            'width' => $size,
            'height' => $size,
            'keywords' => $keywords,
            'seed' => mt_rand(1, 9),
        ]);

        event(new WorldGenerate($world, [
            'generators' => config('atlas.generators'),
        ]));
        info('Your world is being created!');
    }
}
