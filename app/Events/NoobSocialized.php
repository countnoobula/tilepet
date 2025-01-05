<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class NoobSocialized extends ShouldBeStored
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $noob;
    public $targetNoob;
    public $llmResponse;

    /**
     * Create a new event instance.
     *
     * @param Noob $noob
     * @param Noob $targetNoob
     * @param array $llmResponse
     * @return void
     */
    public function __construct(Noob $noob, Noob $targetNoob, array $llmResponse)
    {
        $this->noob = $noob;
        $this->targetNoob = $targetNoob;
        $this->llmResponse = $llmResponse;
    }
}
