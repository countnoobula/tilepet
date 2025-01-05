<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Noob;

class NoobUsedTool
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $noob;
    public $toolName;
    public $target;
    public $llmResponse;

    /**
     * Create a new event instance.
     *
     * @param Noob $noob
     * @param string $toolName
     * @param string $target
     * @param array $llmResponse
     * @return void
     */
    public function __construct(Noob $noob, string $toolName, string $target, array $llmResponse)
    {
        $this->noob = $noob;
        $this->toolName = $toolName;
        $this->target = $target;
        $this->llmResponse = $llmResponse;
    }
}
