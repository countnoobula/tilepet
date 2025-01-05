<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;
use App\Models\Inventory;
use App\Models\World;
use App\Models\WorldTile;

class WorldTileSeeder extends Seeder
{
    public function run()
    {
        $world = World::first();
        if (!$world) {
            $this->command->error('No world found. Please run WorldSeeder first.');
            return;
        }

        $this->command->info('Creating world tiles...');
        $this->createBasicTerrain($world);

        $this->command->info('Creating entities...');
        $this->createEntities($world);

    }

    /**
     * Generate a simple Perlin-like noise value for given coordinates.
     * Note: This is a rudimentary implementation and can be replaced with a more robust solution.
     *
     * @param int $x
     * @param int $y
     * @return float
     */
    private function generateNoise($x, $y)
    {
        // Simple hashing based on coordinates
        $seed = 10000;
        $noise = sin($x / $seed) * sin($y / $seed);
        return ($noise + 1) / 2; // Normalize to [0,1]
    }

    /**
     * Create basic terrain for the world using Perlin noise to create semi-realistic terrain.
     * @param World $world
     */
    private function createBasicTerrain(World $world)
    {
        $terrainsConfig = config('tilepet.terrains');
        $terrainTypes = array_keys($terrainsConfig);
        $terrainWeights = [
            'grass' => 0.6,
            'water' => 0.2,
            'mountain' => 0.2,
            // @TODO - Adjust weights as needed
        ];

        $worldWidth = $world->width;
        $worldHeight = $world->height;

        $bar = $this->command->getOutput()->createProgressBar($worldWidth * $worldHeight);
        $bar->start();

        for ($x = 0; $x < $worldWidth; $x++) {
            for ($y = 0; $y < $worldHeight; $y++) {
                $noise = $this->generateNoise($x, $y);

                // Determine terrain based on noise thresholds
                if ($noise < $terrainWeights['water']) {
                    $terrain = 'water';
                } elseif ($noise < ($terrainWeights['water'] + $terrainWeights['mountain'])) {
                    $terrain = 'mountain';
                } else {
                    $terrain = 'grass';
                }

                WorldTile::create([
                    'world_id' => $world->id,
                    'x' => $x,
                    'y' => $y,
                    'terrain_type' => $terrain,
                    'object_type' => null, // objects will be placed in createEntities
                    'object_state' => null,
                ]);

                $bar->advance();
            }
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Basic terrain created.');
    }

    /**
     * Create the entities that have spawnable properties set to true. Place them in the best possible locations.
     * @param World $world
     */
    private function createEntities(World $world)
    {
        $entitiesConfig = config('tilepet.entities');
        $bar = $this->command->getOutput()->createProgressBar($world->width * $world->height);
        $bar->start();

        foreach ($entitiesConfig as $entityKey => $entityData) {
            if (isset($entityData['spawnable']) && $entityData['spawnable'] === true) {
                // @TODO _ Define the number of entities to spawn based on world size or other criteria
                $spawnCount = 5; // Adjust as needed

                for ($i = 0; $i < $spawnCount; $i++) {
                    // Find a suitable tile based on terrain
                    // Example: Plants should be on grass or soil
                    $suitableTerrains = $entityData['suitable_terrain']; // Define suitable terrains for the entity
                    $suitableTiles = WorldTile::where('world_id', $world->id)
                                              ->whereIn('terrain_type', $suitableTerrains)
                                              ->whereDoesntHave('entity') // Ensure no entity is already present
                                              ->inRandomOrder()
                                              ->first();

                    if ($suitableTiles) {
                        // Create the entity
                        $entity = Entity::create([
                            'world_tile_id' => $suitableTiles->id,
                            'type' => $entityKey,
                            'state' => 0, // Initial state, e.g., growth stage
                            'inventory' => $entityData['inventory'],
                        ]);

                        // If the entity has an inventory (e.g., chest), create it
                        if (isset($entityData['inventory']['enabled']) && $entityData['inventory']['enabled'] === true) {
                            $inventory = Inventory::create([
                                'owner_id' => $entity->id,
                                'owner_type' => Entity::class,
                            ]);

                            // @TODO - Assign items to the inventory based on configuration or default
                        }

                        // Randomly assign growth stage if applicable
                        if (isset($entityData['growth_stages'])) {
                            $entity->state = rand(0, $entityData['growth_stages']); // Random growth stage
                            $entity->save();
                        }
                    }

                    $bar->advance();
                }
            }
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Entities created.');
    }
}
