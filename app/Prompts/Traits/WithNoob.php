<?php

namespace App\Prompts\Traits;

use Modules\Adam\Models\Noob;

trait WithNoob
{
    public ?Noob $noob = null;

    public function noob($noob = null): Noob|self|null
    {
        if ($this->noob === null) {
            $this->noob = $noob;
            return $this;
        }

        return $this->noob;
    }
}
