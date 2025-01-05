<?php

return [
    'grass' => [
        'name' => 'Grass',
        'description' => 'A common terrain type with lush grass.',
        'is_passable' => true,
    ],
    'water' => [
        'name' => 'Water',
        'description' => 'Bodies of water that can be interacted with.',
        'is_passable' => false,
    ],
    'mountain' => [
        'name' => 'Mountain',
        'description' => 'Impassable rocky terrain.',
        'is_passable' => false,
    ],
    // Add more terrains as needed
];
