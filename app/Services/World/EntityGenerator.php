<?php

namespace App\Services\World;

use App\Models\Entity;
use App\Models\Inventory;
use App\Models\Tile;
use App\Models\World;

class EntityGenerator
{
    public function __construct(public World $world)
    {
        // Generate entities based on the world's seed
    }

    public function generate(): void
    {
        $entitiesConfig = config('tilepet.entities');

        foreach ($entitiesConfig as $entityKey => $entityData) {
            if (!($entityData['spawnable'] ?? false)) {
                continue;
            }

            // Define the number of entities to spawn; adjust as needed or make it configurable
            $spawnCount = $entityData['spawn_count'] ?? 5;

            for ($i = 0; $i < $spawnCount; $i++) {
                // Define suitable terrains for the entity
                $suitableTerrains = $entityData['suitable_terrain'] ?? ['grass'];

                // Find a random suitable tile without an existing entity
                $suitableTile = Tile::where('world_id', $this->world->id)
                    ->whereIn('terrain_type', $suitableTerrains)
                    ->whereDoesntHave('entity')
                    ->inRandomOrder()
                    ->first();

                if ($suitableTile) {
                    // Create the entity
                    $entity = Entity::create([
                        'world_tile_id' => $suitableTile->id,
                        'type'          => $entityKey,
                        'state'         => 0, // Initial state, e.g., growth stage
                        'inventory'     => $entityData['inventory'] ?? [],
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    // If the entity has an inventory, create it
                    if (($entityData['inventory']['enabled'] ?? false) === true) {
                        Inventory::create([
                            'owner_id'   => $entity->id,
                            'owner_type' => Entity::class,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // @TODO: Assign items to the inventory based on configuration or default
                    }

                    // Assign a random growth stage if applicable
                    if (isset($entityData['growth_stages'])) {
                        $entity->update([
                            'state' => rand(0, $entityData['growth_stages']),
                        ]);
                    }
                }
            }
        }
    }
}
