<?php

return [
    'grass' => [
        'name' => 'Grass',
        'description' => 'A common terrain type with lush grass.',
        'is_passable' => true,
        'weight' => 0.6, // Selection weight for terrain generation
    ],
    'water' => [
        'name' => 'Water',
        'description' => 'Bodies of water that can be interacted with.',
        'is_passable' => false,
        'weight' => 0.2,
    ],
    'mountain' => [
        'name' => 'Mountain',
        'description' => 'Impassable rocky terrain.',
        'is_passable' => false,
        'weight' => 0.2,
    ],
    // Add more terrains as needed with their respective weights
];
