<?php

return [
    'tree' => [
        'spawnable'       => true,
        'spawn_count'     => 10, // Number of trees to spawn
        'suitable_terrain'=> ['grass'],
        'inventory'       => [
            'enabled' => false,
            // Other inventory settings
        ],
        'growth_stages'   => 3,
    ],
    'chest' => [
        'spawnable'       => true,
        'spawn_count'     => 5,
        'suitable_terrain'=> ['grass', 'mountain'],
        'inventory'       => [
            'enabled' => true,
            // Other inventory settings
        ],
        // No growth stages
    ],
    // Add more entities as needed
];
