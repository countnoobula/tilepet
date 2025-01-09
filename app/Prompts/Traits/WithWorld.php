<?php

namespace App\Prompts\Traits;

use Modules\Atlas\Models\World;

trait WithWorld
{
    public ?World $world = null;

    public function world($world = null): World|self|null
    {
        if ($this->world === null) {
            $this->world = $world;
            return $this;
        }

        return $this->world;
    }
}
