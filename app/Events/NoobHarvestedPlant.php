<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;
use App\Models\Entity;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class NoobHarvestedPlant extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $noob;
    public $plant;
    public $llmResponse;

    /**
     * Create a new event instance.
     *
     * @param Noob $noob
     * @param Entity $plant
     * @param array $llmResponse
     * @return void
     */
    public function __construct(Noob $noob, Entity $plant, array $llmResponse)
    {
        $this->noob = $noob;
        $this->plant = $plant;
        $this->llmResponse = $llmResponse;
    }
}
