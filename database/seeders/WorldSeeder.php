<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\World;

class WorldSeeder extends Seeder
{
    public function run()
    {
        // Create a single world instance
        World::create([
            'current_season' => 'spring',
            'current_year' => 1,
        ]);
    }
}
