<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class NoobMoved extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $noob;
    public $direction;
    public $llmResponse;

    /**
     * Create a new event instance.
     *
     * @param Noob $noob
     * @param string $direction
     * @param array $llmResponse
     * @return void
     */
    public function __construct(Noob $noob, string $direction, array $llmResponse)
    {
        $this->noob = $noob;
        $this->direction = $direction;
        $this->llmResponse = $llmResponse;
    }
}
