<?php

namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use App\Events\NoobMoved;
use App\Events\NoobGathered;
use App\Events\NoobSocialized;

class NoobAggregate extends AggregateRoot
{
    protected $noobId;

    public function __construct($noobId)
    {
        $this->noobId = $noobId;
    }

    /**
     * Move the noob in a specified direction.
     *
     * @param string $direction
     * @return $this
     */
    public function move(string $direction)
    {
        $this->recordThat(new NoobMoved($this->noobId, $direction));

        return $this;
    }

    /**
     * Gather a specified resource.
     *
     * @param string $resource
     * @return $this
     */
    public function gather(string $resource)
    {
        $this->recordThat(new NoobGathered($this->noobId, $resource));

        return $this;
    }

    /**
     * Socialize with another noob.
     *
     * @param int $targetNoobId
     * @return $this
     */
    public function socialize(int $targetNoobId)
    {
        $this->recordThat(new NoobSocialized($this->noobId, $targetNoobId));

        return $this;
    }

    /**
     * Apply the NoobMoved event.
     *
     * @param NoobMoved $event
     */
    public function applyNoobMoved(NoobMoved $event)
    {
        // Implement logic to update the noob's state based on movement
        // For example, updating position in a projection
    }

    /**
     * Apply the NoobGathered event.
     *
     * @param NoobGathered $event
     */
    public function applyNoobGathered(NoobGathered $event)
    {
        // Implement logic to update the noob's inventory or state based on gathering
    }

    /**
     * Apply the NoobSocialized event.
     *
     * @param NoobSocialized $event
     */
    public function applyNoobSocialized(NoobSocialized $event)
    {
        // Implement logic to update the noob's social stats
    }
}
