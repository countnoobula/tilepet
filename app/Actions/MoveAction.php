<?php

namespace App\Actions;

use App\Models\Noob;
use App\Events\NoobMoved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoveAction implements ActionInterface
{
    /**
     * Execute the move action.
     *
     * @param array $parameters
     * @return void
     */
    public function execute(array $parameters): void
    {
        $noobId = $parameters['noob_id'] ?? null;
        $direction = $parameters['direction'] ?? null;

        if (!$noobId || !$direction) {
            Log::warning("Invalid parameters for MoveAction: " . json_encode($parameters));
            return;
        }

        DB::transaction(function () use ($noobId, $direction, $parameters) {
            $noob = Noob::find($noobId);
            if (!$noob) {
                Log::warning("Noob ID {$noobId} not found for MoveAction.");
                return;
            }

            // Update position based on direction
            switch (strtolower($direction)) {
                case 'north':
                    $noob->position_y += 1;
                    break;
                case 'south':
                    $noob->position_y -= 1;
                    break;
                case 'east':
                    $noob->position_x += 1;
                    break;
                case 'west':
                    $noob->position_x -= 1;
                    break;
                default:
                    Log::warning("Invalid direction '{$direction}' for Noob ID {$noobId}.");
                    return;
            }

            // Ensure position stays within bounds (e.g., 0-99)
            $noob->position_x = max(0, min(99, $noob->position_x));
            $noob->position_y = max(0, min(99, $noob->position_y));

            $noob->save();

            // Trigger event with LLM response included
            event(new NoobMoved($noob, $direction, $parameters));
        });
    }
}
