<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            WorldSeeder::class,
            WorldTileSeeder::class,
            ItemSeeder::class,
            NoobSeeder::class,
            SkillSeeder::class,
            // Keep the order, Shaun
        ]);
    }
}
