<?php

return [
    'name' => 'Atlas',

    /**
     * These are the generators available to use when generating a new world
     */
    'generators' => [
        \Modules\Atlas\Generators\TileGenerator::class,
        // \App\Services\World\Generators\EntityGenerator::class,
    ],

    /**
     * These are the terrains availalbe to use when generating a new world
     */
    'terrains' => [
        'grass' => [
            'name' => 'Grass',
            'description' => 'A common terrain type with lush grass.',
            'is_passable' => true,
            'weight' => 0.2, // Selection weight for terrain generation
        ],
        'water' => [
            'name' => 'Water',
            'description' => 'Bodies of water that can be interacted with.',
            'is_passable' => false,
            'weight' => 0.1,
        ],
        'mountain' => [
            'name' => 'Mountain',
            'description' => 'Impassable rocky terrain.',
            'is_passable' => false,
            'weight' => 0.4,
        ],
    ],
];
