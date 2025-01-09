<?php

namespace Modules\Adam\Events;

use Modules\Atlas\Models\World;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class NoobGenerate extends ShouldBeStored
{
    public function __construct(
        public World $world
    ) {
        //
    }
}
