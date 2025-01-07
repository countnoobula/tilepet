<?php

namespace App\Projectors;

use App\Services\World\EntityGenerator;
use App\Services\World\TileGenerator;
use App\StorableEvents\WorldGenerate;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class WorldStateProjector extends Projector
{
    public function onWorldGenerate(WorldGenerate $event)
    {
        // Generate tiles
        $tile_generator = new TileGenerator($event->world);
        $tile_generator->generate();

        // Generate entities
        $entity_generator = new EntityGenerator($event->world);
        $entity_generator->generate();
    }
}
