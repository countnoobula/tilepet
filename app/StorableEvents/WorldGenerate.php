<?php

namespace App\StorableEvents;

use App\Models\World;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WorldGenerate extends ShouldBeStored
{
    public function __construct(
        public World $world
    )
    {}
}
