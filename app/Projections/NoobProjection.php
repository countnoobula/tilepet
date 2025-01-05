<?php

namespace App\Projections;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use App\Events\NoobMoved;
use App\Events\NoobGathered;
use App\Events\NoobSocialized;
use App\Events\NoobUsedTool;
use App\Events\NoobHarvestedPlant;
use App\Models\Noob;
use Illuminate\Support\Facades\Log;

class NoobProjection extends Projector
{
    /**
     * Handle the NoobMoved event.
     *
     * @param NoobMoved $event
     * @return void
     */
    public function onNoobMoved(NoobMoved $event)
    {
        $noob = Noob::find($event->noob->id);
        if ($noob) {
            // Update position based on direction
            switch (strtolower($event->direction)) {
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
                    Log::warning("Invalid direction '{$event->direction}' for Noob ID {$noob->id}");
                    return;
            }

            // Ensure position stays within world bounds (e.g., 0-99)
            $noob->position_x = max(0, min(99, $noob->position_x));
            $noob->position_y = max(0, min(99, $noob->position_y));

            // Save the updated noob
            $noob->save();

            // Record the LLM response
            $this->recordLLMResponse($noob, 'NoobMoved', [
                'direction' => $event->direction,
                'llm_response' => $event->llmResponse,
            ]);
        } else {
            Log::warning("Noob ID {$event->noob->id} not found for NoobMoved event.");
        }
    }

    /**
     * Handle the NoobGathered event.
     *
     * @param NoobGathered $event
     * @return void
     */
    public function onNoobGathered(NoobGathered $event)
    {
        $noob = Noob::find($event->noob->id);
        if ($noob) {
            // Assuming the inventory has a method to add items
            $resource = ucfirst($event->resource);
            $noob->inventory->addItem($resource, 1);

            // Update related needs (e.g., hunger, thirst)
            switch (strtolower($event->resource)) {
                case 'water':
                    $noob->thirst = min(100, $noob->thirst + 20);
                    break;
                case 'food':
                    $noob->hunger = min(100, $noob->hunger + 20);
                    break;
                // Add more resources as needed
            }

            // Save the updated noob
            $noob->save();

            // Record the LLM response
            $this->recordLLMResponse($noob, 'NoobGathered', [
                'resource' => $event->resource,
                'llm_response' => $event->llmResponse,
            ]);
        } else {
            Log::warning("Noob ID {$event->noob->id} not found for NoobGathered event.");
        }
    }

    /**
     * Handle the NoobSocialized event.
     *
     * @param NoobSocialized $event
     * @return void
     */
    public function onNoobSocialized(NoobSocialized $event)
    {
        $noob = Noob::find($event->noob->id);
        $targetNoob = Noob::find($event->targetNoob->id);

        if ($noob && $targetNoob) {
            // Update social attributes
            $noob->social = min(100, $noob->social + 10);
            $targetNoob->social = min(100, $targetNoob->social + 10);

            // Save the updated noobs
            $noob->save();
            $targetNoob->save();

            // Record the LLM response for both noobs
            $this->recordLLMResponse($noob, 'NoobSocialized', [
                'target_noob_id' => $targetNoob->id,
                'llm_response' => $event->llmResponse,
            ]);

            $this->recordLLMResponse($targetNoob, 'NoobSocialized', [
                'target_noob_id' => $noob->id,
                'llm_response' => $event->llmResponse,
            ]);
        } else {
            Log::warning("Noob(s) not found for NoobSocialized event. Noob ID: {$event->noob->id}, Target Noob ID: {$event->targetNoob->id}");
        }
    }

    /**
     * Handle the NoobUsedTool event.
     *
     * @param NoobUsedTool $event
     * @return void
     */
    public function onNoobUsedTool(NoobUsedTool $event)
    {
        $noob = Noob::find($event->noob->id);
        if ($noob) {
            // Example: Tool usage already handled in the job, so here we just log the event
            // You can add additional logic if needed

            // Record the LLM response
            $this->recordLLMResponse($noob, 'NoobUsedTool', [
                'tool_name' => $event->toolName,
                'target' => $event->target,
                'llm_response' => $event->llmResponse,
            ]);
        } else {
            Log::warning("Noob ID {$event->noob->id} not found for NoobUsedTool event.");
        }
    }

    /**
     * Handle the NoobHarvestedPlant event.
     *
     * @param NoobHarvestedPlant $event
     * @return void
     */
    public function onNoobHarvestedPlant(NoobHarvestedPlant $event)
    {
        $noob = Noob::find($event->noob->id);
        $plant = $event->plant;

        if ($noob && $plant) {
            // Assuming harvesting is already handled in the job, so here we just log the event
            // You can add additional logic if needed

            // Record the LLM response
            $this->recordLLMResponse($noob, 'NoobHarvestedPlant', [
                'plant_id' => $plant->id,
                'llm_response' => $event->llmResponse,
            ]);
        } else {
            Log::warning("Noob or Plant not found for NoobHarvestedPlant event. Noob ID: {$event->noob->id}, Plant ID: {$event->plant->id}");
        }
    }

    /**
     * Helper method to record LLM responses.
     *
     * @param Noob $noob
     * @param string $eventType
     * @param array $details
     * @return void
     */
    protected function recordLLMResponse(Noob $noob, string $eventType, array $details)
    {
        try {
            $noob->llm_responses()->create([
                'event_type' => $eventType,
                'event_details' => json_encode($details),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to record LLM response for Noob ID {$noob->id}: " . $e->getMessage());
        }
    }
}
