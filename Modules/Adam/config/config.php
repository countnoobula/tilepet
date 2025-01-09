<?php

return [
    'name' => 'Adam',

    'skills' => [
        'strength' => [
            'experience_per_level' => 100,
        ],
        'perception' => [
            'experience_per_level' => 100,
        ],
        'endurance' => [
            'experience_per_level' => 100,
        ],
        'charisma' => [
            'experience_per_level' => 100,
        ],
        'intelligence' => [
            'experience_per_level' => 100,
        ],
        'agility' => [
            'experience_per_level' => 100,
        ],
        'luck' => [
            'experience_per_level' => 100,
        ],
    ],

    'actions' => [
        'move' => [
            'description' => 'Move a noob in a specified direction.',
            'parameters' => [
                'noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob to move.',
                ],
                'direction' => [
                    'type' => 'string',
                    'enum' => ['north', 'south', 'east', 'west'],
                    'description' => 'The direction to move the noob.',
                ],
            ],
            'class' => \Modules\Adam\Actions\MoveAction::class,
        ],

        'socialize' => [
            'description' => 'Interact with another noob.',
            'parameters' => [
                'noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob initiating the interaction.',
                ],
                'target_noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob to interact with.',
                ],
            ],
            'class' => \Modules\Adam\Actions\SocializeAction::class,
        ],
    ],
];
