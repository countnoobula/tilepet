<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // Retrieve the items configuration
        $itemsConfig = config('tilepet.items');

        foreach ($itemsConfig as $category => $items) {
            foreach ($items as $key => $itemData) {
                // Check if the item already exists to prevent duplicates
                $existingItem = Item::where('name', $itemData['name'])->first();

                if (!$existingItem) {
                    $item = Item::create([
                        'name' => $itemData['name'],
                        'type' => $category, // Assuming category corresponds to 'type' in items table
                        'description' => $itemData['description'] ?? null,
                        'durability' => $itemData['durability'] ?? null,
                        'targets' => $itemData['targets'] ?? null,
                        'effects' => $itemData['effects'] ?? null,
                    ]);
                }
            }
        }
    }
}
