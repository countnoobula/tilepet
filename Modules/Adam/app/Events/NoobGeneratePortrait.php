<?php

namespace Modules\Adam\Events;

use Modules\Adam\Models\Noob;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class NoobGeneratePortrait # extends ShouldBeStored
{
    public function __construct(
        public Noob $noob
    ) {
        //
    }
}
