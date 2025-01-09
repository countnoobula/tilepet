<?php

namespace Modules\Atlas\Projectors;

use Modules\Atlas\Events\WorldGenerate;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class WorldTerrainProjector extends Projector
{
    public function onWorldGenerate(WorldGenerate $event)
    {
        $event->world->nuke();

        foreach ($event->meta['generators'] as $generator) {
            (new ($generator)($event->world))->generate();
        }
    }
}
