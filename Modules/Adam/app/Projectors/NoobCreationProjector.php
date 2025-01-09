<?php

namespace Modules\Adam\Projectors;

use Modules\Adam\Events\NoobGenerate;
use Modules\Adam\Events\NoobGeneratePortrait;
use Modules\Adam\Models\Noob;
use Modules\Adam\Prompts\CreateNoob;
use Modules\Adam\Prompts\CreateNoobPortrait;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class NoobCreationProjector extends Projector {

    public function onNoobGenerate(NoobGenerate $event)
    {
        /** @var Noob $noob */
        $noob = CreateNoob::prompt()
            ->world($event->world)
            ->resolve();

        event(new NoobGeneratePortrait($noob));
    }

    public function onNoobGeneratePortrait(NoobGeneratePortrait $event)
    {
        /** @var CreateNoobPortrait $prompt */
        CreateNoobPortrait::prompt()
            ->noob($event->noob)
            ->resolve();
    }
}
