<?php

return [
    'plant' => [
        'name' => 'Plant',
        'description' => 'A growing plant that can be harvested.',
        'growth_stages' => 5, // Number of growth stages
        'inventory' => [
            'enabled' => false,
            'size' => 0,
        ],
        'spawnable' => true,
        'suitable_terrain' => [
            'grass',
            'soil',
        ],
    ],
    'chest' => [
        'name' => 'Chest',
        'description' => 'A storage container for items.',
        'inventory' => [
            'enabled' => true,
            'size' => 9
        ],
        'spawnable' => false,
        'suitable_terrain' => [
            'grass',
        ]
    ],
    // Add more entities as needed
];
