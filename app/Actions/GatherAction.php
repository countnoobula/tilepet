<?php

namespace App\Actions;

use App\Models\Noob;
use App\Models\WorldTile;
use App\Events\NoobGathered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GatherAction implements ActionInterface
{
    /**
     * Execute the gather action.
     *
     * @param array $parameters
     * @return void
     */
    public function execute(array $parameters): void
    {
        $noobId = $parameters['noob_id'] ?? null;
        $resource = $parameters['resource'] ?? null;

        if (!$noobId || !$resource) {
            Log::warning("Invalid parameters for GatherAction: " . json_encode($parameters));
            return;
        }

        DB::transaction(function () use ($noobId, $resource, $parameters) {
            $noob = Noob::find($noobId);
            if (!$noob) {
                Log::warning("Noob ID {$noobId} not found for GatherAction.");
                return;
            }

            // Implement resource gathering logic based on current tile
            $tile = WorldTile::where('x', $noob->position_x)
                             ->where('y', $noob->position_y)
                             ->first();

            if (!$tile) {
                Log::error("WorldTile not found for Noob ID {$noobId} at position ({$noob->position_x}, {$noob->position_y}).");
                return;
            }

            switch (strtolower($resource)) {
                case 'water':
                    if ($tile->terrain_type === 'water') {
                        $noob->inventory->addItem('Water Bottle', 1);
                        $noob->thirst = min(100, $noob->thirst + 20);
                        $noob->save();

                        // Grant experience to Strength
                        $strengthSkill = $noob->getSkill('strength');
                        if ($strengthSkill) {
                            $strengthSkill->addExperience(10); // Example: 10 XP per gather
                        }

                        event(new NoobGathered($noob, 'water', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to gather water on non-water terrain.");
                    }
                    break;
                case 'food':
                    if (in_array($tile->terrain_type, ['grass', 'forest'])) {
                        $noob->inventory->addItem('Bread', 1);
                        $noob->hunger = min(100, $noob->hunger + 20);
                        $noob->save();

                        // Grant experience to Strength
                        $strengthSkill = $noob->getSkill('strength');
                        if ($strengthSkill) {
                            $strengthSkill->addExperience(10);
                        }

                        event(new NoobGathered($noob, 'food', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to gather food on unsuitable terrain.");
                    }
                    break;
                case 'wood':
                    if ($tile->terrain_type === 'forest') {
                        $noob->inventory->addItem('Wood', 1);
                        $noob->save();

                        // Grant experience to Strength
                        $strengthSkill = $noob->getSkill('strength');
                        if ($strengthSkill) {
                            $strengthSkill->addExperience(15); // More XP for harder resources
                        }

                        event(new NoobGathered($noob, 'wood', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to gather wood on non-forest terrain.");
                    }
                    break;
                case 'stone':
                    if ($tile->terrain_type === 'mountain') {
                        $noob->inventory->addItem('Stone', 1);
                        $noob->save();

                        // Grant experience to Strength
                        $strengthSkill = $noob->getSkill('strength');
                        if ($strengthSkill) {
                            $strengthSkill->addExperience(20); // Even more XP for harder resources
                        }

                        event(new NoobGathered($noob, 'stone', $parameters));
                    } else {
                        Log::warning("Noob ID {$noobId} attempted to gather stone on non-mountain terrain.");
                    }
                    break;
                default:
                    Log::warning("Invalid resource '{$resource}' for GatherAction.");
                    break;
            }
        });
    }
}
