<?php

namespace App\Traits;

use function Termwind\{ render };

trait ConsoleComponents
{
    public function renderHeader() {
        render(<<<HTML
            <div class="w-full bg-blue pt-2 flex justify-center">
                <h1 class="font-bold text-white">Tile Pet</h1>
            </div>
        HTML);

        $quote = \Illuminate\Foundation\Inspiring::quotes()->random();
        render('<div class="w-full bg-blue pt-1 pb-2 flex justify-center"><h2 class="font-bold text-green">' . $quote . '</h2></div>');
    }
}
