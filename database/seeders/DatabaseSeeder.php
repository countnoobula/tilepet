<?php

namespace Database\Seeders;

use App\models\World;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a single world instance
        $world = World::factory()
                ->size(100)
                ->generated()
                ->create();

        $this->call([
            // WorldTileSeeder::class,
            // ItemSeeder::class,
            // NoobSeeder::class,
            // SkillSeeder::class,
            // Keep the order, Shaun
        ]);
    }
}
