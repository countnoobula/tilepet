<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;

class NoobGathered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $noob;
    public $resource;
    public $llmResponse;

    /**
     * Create a new event instance.
     *
     * @param Noob $noob
     * @param string $resource
     * @param array $llmResponse
     * @return void
     */
    public function __construct(Noob $noob, string $resource, array $llmResponse)
    {
        $this->noob = $noob;
        $this->resource = $resource;
        $this->llmResponse = $llmResponse;
    }
}
