<?php

namespace Modules\Atlas\Events;

use Modules\Atlas\Models\World;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WorldGenerate extends ShouldBeStored
{
    public function __construct(
        public World $world,
        public array $meta = [],
    )
    {
        //
    }
}
