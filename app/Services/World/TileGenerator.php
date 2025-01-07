<?php

namespace App\Services\World;

use App\Models\Tile;
use App\Models\World;

class TileGenerator
{
    public function __construct(public World $world)
    {
        // Generate tiles based on the world's seed
    }

    public function generate(): void
    {
        $terrainsConfig = config('tilepet.terrains');

        // Extract terrain types and their weights
        $terrainTypes = array_keys($terrainsConfig);
        $terrainWeights = array_map(fn($terrain) => $terrain['weight'], $terrainsConfig);

        // Normalize weights to ensure they sum to 1
        $totalWeight = array_sum($terrainWeights);
        $normalizedWeights = array_map(fn($weight) => $weight / $totalWeight, $terrainWeights);

        // Create cumulative distribution for terrain selection
        $cumulativeWeights = [];
        $cumulative = 0;
        foreach ($normalizedWeights as $weight) {
            $cumulative += $weight;
            $cumulativeWeights[] = $cumulative;
        }

        $worldWidth = $this->world->width;
        $worldHeight = $this->world->height;
        $seed = $this->world->seed; // Assuming 'seed' is an integer stored in the World model

        // Prepare bulk insertion for performance
        $tiles = [];

        for ($x = 0; $x < $worldWidth; $x++) {
            for ($y = 0; $y < $worldHeight; $y++) {
                $noise = $this->generateNoise($x, $y, $seed);

                // Select terrain based on noise and cumulative weights
                $terrain = $this->selectTerrain($noise, $cumulativeWeights, $terrainTypes);

                $tiles[] = [
                    'world_id'     => $this->world->id,
                    'x'            => $x,
                    'y'            => $y,
                    'terrain_type' => $terrain,
                    'object_type'  => null,
                    'object_state' => null,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];

                // Optionally, insert in batches to manage memory for very large worlds
                if (count($tiles) >= 1000) {
                    Tile::insert($tiles);
                    $tiles = [];
                }
            }
        }

        // Insert any remaining tiles
        if (!empty($tiles)) {
            Tile::insert($tiles);
        }
    }

    /**
     * Generate a noise value using Perlin-like noise based on the world's seed.
     *
     * @param int $x
     * @param int $y
     * @param int $seed
     * @return float
     */
    private function generateNoise(int $x, int $y, int $seed): float
    {
        // Simple hashing based on coordinates and seed
        $noise = sin(($x + $seed) / 10000) * sin(($y + $seed) / 10000);
        return ($noise + 1) / 2; // Normalize to [0,1]
    }

    /**
     * Select a terrain type based on the noise value and cumulative weights.
     *
     * @param float $noise
     * @param array $cumulativeWeights
     * @param array $terrainTypes
     * @return string
     */
    private function selectTerrain(float $noise, array $cumulativeWeights, array $terrainTypes): string
    {
        foreach ($cumulativeWeights as $index => $cumulativeWeight) {
            if ($noise < $cumulativeWeight) {
                return $terrainTypes[$index];
            }
        }

        // Fallback to the last terrain type
        return end($terrainTypes);
    }
}
