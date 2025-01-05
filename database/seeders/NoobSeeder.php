<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noob;
use App\Models\Inventory;
use App\Models\Item;
use Faker\Factory as Faker;

class NoobSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $items = Item::all();

        foreach (range(1, 2) as $index) {
            // Create the noob
            $noob = Noob::create([
                'name' => $faker->name,
                'position_x' => $faker->numberBetween(0, 99),
                'position_y' => $faker->numberBetween(0, 99),
                'hunger' => 100,
                'thirst' => 100,
                'social' => 50,
                'strength' => 1,
                'perception' => 1,
                'endurance' => 1,
                'charisma' => 1,
                'intelligence' => 1,
                'agility' => 1,
                'luck' => 1,
            ]);

            // Create inventory for the noob
            $inventory = $noob->inventory()->create();
        }
    }
}
