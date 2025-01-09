<?php

namespace Modules\Atlas\Projectors;

use Modules\Atlas\Events\WorldGenerate;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Modules\Atlas\Prompts\CreateWorldStory;

class WorldStoryProjector extends Projector
{
    public function onWorldGenerate(WorldGenerate $event)
    {
        /** @var CreateWorldStory $prompt */
        $prompt = CreateWorldStory::prompt()
            ->world($event->world)
            ->resolve();
    }
}
