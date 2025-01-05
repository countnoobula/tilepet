<?php

return [
    'tools' => [
        'axe' => [
            'name' => 'Axe',
            'description' => 'Used to chop wood.',
            'targets' => [
                'tree',
                'wood',
            ],
            'durability' => 100,
        ],
        'hoe' =>[
            'name' => 'Hoe',
            'description' => 'Used to till soil.',
            'targets' => [
                'grass',
                'soil',
            ],
            'durability' => 100,
        ],
    ],

    'resources' => [
        'wood' => [
            'name' => 'Wood',
            'description' => 'Gathered from trees.',
        ],
        'stone' => [
            'name' => 'Stone',
            'description' => 'Collected from rocks.',
        ],
    ],

    'consumables' => [
        'water_bottle' => [
            'name' => 'Water Bottle',
            'description' => 'Used to quench thirst.',
            'effects' => [
                'thirst' => 20,
            ]
        ],
        'bread' => [
            'name' => 'Bread',
            'description' => 'Used to satisfy hunger.',
            'effects' => [
                'hunger' => 20,
            ]
        ],
    ],
];
