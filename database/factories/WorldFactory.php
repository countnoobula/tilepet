<?php

namespace Database\Factories;

use App\StorableEvents\WorldGenerate;
use App\Models\World;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\World>
 */
class WorldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            # Age Data
            'season' => 'spring',
            'year' => 1,
            'temperature' => 30,
            'humidity' => 50,

            'tick_count' => 0,

            # World Data
            'width' => 100,
            'height' => 100,

            'seed' => rand(),
        ];
    }

    public function size($size = 100): Factory
    {
        return $this->state(function (array $attributes) use ($size) {
            return [
                'seed' => rand(10000,99999),
                'width' => $size,
                'height' => $size,
            ];
        });
    }

    public function generated(): Factory
    {
        return $this->afterCreating(function (World $world) {
            event(new WorldGenerate($world));
        });
    }
}
