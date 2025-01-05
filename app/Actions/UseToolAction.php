<?php

namespace App\Actions;

use App\Models\Noob;
use App\Models\WorldTile;
use App\Models\Entity;
use App\Events\NoobUsedTool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UseToolAction implements ActionInterface
{
    /**
     * Execute the use_tool action.
     *
     * @param array $parameters
     * @return void
     */
    public function execute(array $parameters): void
    {
        $noobId = $parameters['noob_id'] ?? null;
        $toolName = $parameters['tool_name'] ?? null;
        $target = $parameters['target'] ?? null;

        if (!$noobId || !$toolName || !$target) {
            Log::warning("Invalid parameters for UseToolAction: " . json_encode($parameters));
            return;
        }

        DB::transaction(function () use ($noobId, $toolName, $target, $parameters) {
            $noob = Noob::find($noobId);
            if (!$noob) {
                Log::warning("Noob ID {$noobId} not found for UseToolAction.");
                return;
            }

            // Implement tool usage logic based on target
            switch (strtolower($toolName)) {
                case 'axe':
                    if ($target === 'tree') {
                        // Example: Chop a tree, gain wood
                        $noob->inventory->addItem('Wood', 1);
                        // Reduce tool durability or noob's strength if necessary
                        $noob->strength = max(1, $noob->strength - 1);
                        $noob->save();

                        event(new NoobUsedTool($noob, 'axe', 'tree', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to use axe on invalid target '{$target}'.");
                    }
                    break;
                case 'hoe':
                    if ($target === 'soil') {
                        // Example: Till the soil, prepare for planting
                        $tile = WorldTile::where('x', $noob->position_x)
                                         ->where('y', $noob->position_y)
                                         ->first();

                        if ($tile && (!$tile->entity || $tile->entity->type !== 'plant')) {
                            Entity::create([
                                'world_tile_id' => $tile->id,
                                'type' => 'plant',
                                'state' => 0, // Initial growth stage
                            ]);
                        } else {
                            Log::warning("Noob ID {$noobId} attempted to use hoe on soil that already has a plant.");
                        }

                        // Reduce tool durability or noob's perception if necessary
                        $noob->perception = max(1, $noob->perception - 1);
                        $noob->save();

                        event(new NoobUsedTool($noob, 'hoe', 'soil', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to use hoe on invalid target '{$target}'.");
                    }
                    break;
                default:
                    Log::warning("Invalid tool '{$toolName}' for UseToolAction.");
                    break;
            }
        });
    }
}
