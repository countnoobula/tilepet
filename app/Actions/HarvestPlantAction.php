<?php

namespace App\Actions;

use App\Models\Noob;
use App\Models\Entity;
use App\Events\NoobHarvestedPlant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HarvestPlantAction implements ActionInterface
{
    /**
     * Execute the harvest_plant action.
     *
     * @param array $parameters
     * @return void
     */
    public function execute(array $parameters): void
    {
        $noobId = $parameters['noob_id'] ?? null;
        $plantId = $parameters['plant_id'] ?? null;

        if (!$noobId || !$plantId) {
            Log::warning("Invalid parameters for HarvestPlantAction: " . json_encode($parameters));
            return;
        }

        DB::transaction(function () use ($noobId, $plantId, $parameters) {
            $noob = Noob::find($noobId);
            $plant = Entity::find($plantId);

            if (!$noob || !$plant || strtolower($plant->type) !== 'plant') {
                Log::warning("Noob or Plant not found for HarvestPlantAction. Noob ID: {$noobId}, Plant ID: {$plantId}");
                return;
            }

            // Check if plant is fully grown
            $plantConfig = config('tilepet.entities.plant');
            if ($plant->state >= $plantConfig['growth_stages']) {
                // Harvest the plant
                $noob->inventory->addItem('Wood', 1); // Example: Harvested wood
                $plant->delete(); // Remove the plant from the world

                // Trigger event with LLM response included
                event(new NoobHarvestedPlant($noob, $plant, $parameters));
            } else {
                Log::warning("Plant ID {$plantId} is not yet fully grown for HarvestPlantAction.");
            }
        });
    }
}
