<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;
use App\Services\LLMService;
use App\Services\FunctionDispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorldTickJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Number of retry attempts

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Start a database transaction for consistency
        DB::transaction(function () {
            // Retrieve all noobs
            $noobs = Noob::with('inventory')->get();

            if ($noobs->isEmpty()) {
                Log::info('No noobs found to process in WorldTickJob.');
                return;
            }

            // Compile noob states
            $states = $noobs->map(function ($noob) {
                return [
                    'noob_id' => $noob->id,
                    'needs' => [
                        'hunger' => $noob->hunger,
                        'thirst' => $noob->thirst,
                        'social' => $noob->social,
                    ],
                    'skills' => [
                        'strength' => $noob->strength,
                        'perception' => $noob->perception,
                        'endurance' => $noob->endurance,
                        'charisma' => $noob->charisma,
                        'intelligence' => $noob->intelligence,
                        'agility' => $noob->agility,
                        'luck' => $noob->luck,
                    ],
                    'location' => [
                        'x' => $noob->position_x,
                        'y' => $noob->position_y,
                    ],
                    // Add more state details if necessary
                ];
            })->toArray();

            // Send batch prompt to LLM and get function calls
            $functionCall = LLMService::getActionsForNoobs($states);

            if ($functionCall) {
                // Dispatch the function call(s) using the dispatcher
                FunctionDispatcher::dispatchFunction($functionCall);
            }

            // Optionally, handle global world updates (e.g., seasons)
            $this->updateWorldSeason();
        });
    }

    /**
     * Update global world properties like seasons.
     *
     * @return void
     */
    private function updateWorldSeason()
    {
        // Example: Change season every 90 ticks (days)
        $world = \App\Models\World::first();

        if (!$world) {
            Log::error('World not found during season update.');
            return;
        }

        // Increment tick count
        $world->tick_count = $world->tick_count + 1;
        $world->save();

        // Change season every 90 ticks
        if ($world->tick_count % 90 === 0) {
            $seasons = ['spring', 'summer', 'autumn', 'winter'];
            $currentSeasonIndex = array_search($world->current_season, $seasons);
            $nextSeasonIndex = ($currentSeasonIndex + 1) % count($seasons);
            $world->current_season = $seasons[$nextSeasonIndex];
            $world->current_year += 1; // Increment year if needed
            $world->save();

            Log::info("Season changed to {$world->current_season}, Year {$world->current_year}.");

            // Optionally, trigger an event for season change
            // event(new \App\Events\SeasonChanged($world->current_season, $world->current_year));
        }
    }
}
