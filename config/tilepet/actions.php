<?php

return [

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
            'class' => \App\Actions\MoveAction::class,
        ],

        'gather' => [
            'description' => 'Gather a specified resource from the current location.',
            'parameters' => [
                'noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob to gather resources.',
                ],
                'resource' => [
                    'type' => 'string',
                    'enum' => ['water', 'food', 'wood', 'stone'],
                    'description' => 'The resource to gather.',
                ],
            ],
            'class' => \App\Actions\GatherAction::class,
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
            'class' => \App\Actions\SocializeAction::class,
        ],

        'use_tool' => [
            'description' => 'Use a tool from the inventory on a target.',
            'parameters' => [
                'noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob using the tool.',
                ],
                'tool_name' => [
                    'type' => 'string',
                    'enum' => ['axe', 'hoe'],
                    'description' => 'The name of the tool to use.',
                ],
                'target' => [
                    'type' => 'string',
                    'description' => 'The target of the tool usage (e.g., "tree", "soil").',
                ],
            ],
            'class' => \App\Actions\UseToolAction::class,
        ],

        'harvest_plant' => [
            'description' => 'Harvest a plant that has reached full growth.',
            'parameters' => [
                'noob_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the noob harvesting the plant.',
                ],
                'plant_id' => [
                    'type' => 'integer',
                    'description' => 'The ID of the plant to harvest.',
                ],
            ],
            'class' => \App\Actions\HarvestPlantAction::class,
        ],

        // Add more actions as needed
    ],

];
