<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class WorldType extends GraphQLType
{
    protected $attributes = [
        'name' => 'World',
        'description' => 'The world object containing basic meta information',
        'model' => \App\Models\World::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the world',
            ],

            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the world',
            ],

            'story' => [
                'type' => Type::string(),
                'description' => 'The story of the world',
            ],

            'season' => [
                'type' => GraphQL::type('SeasonEnum'),
                'description' => 'The current season of the world',
            ],
            'year' => [
                'type' => Type::int(),
                'description' => 'The current year of the world',
            ],

            'temperature' => [
                'type' => Type::int(),
                'description' => 'The current temperature of the world',
            ],
            'humidity' => [
                'type' => Type::int(),
                'description' => 'The current humidity of the world',
            ],

            'width' => [
                'type' => Type::int(),
                'description' => 'The width of the world',
            ],
            'height' => [
                'type' => Type::int(),
                'description' => 'The height of the world',
            ],
            'seed' => [
                'type' => Type::string(),
                'description' => 'The seed of the world',
            ],

            'tick_count' => [
                'type' => Type::int(),
                'description' => 'The number of ticks that have passed in the world (days)',
            ],

            'created_at' => [
                'type' => Type::string(),
                'description' => 'The date and time the world was created',
            ],

            'tiles' => [
                'type' => Type::listOf(GraphQL::type('Tile')),
                'description' => 'The tiles that make up the world',
            ],
        ];
    }
}
