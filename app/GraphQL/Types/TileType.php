<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TileType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Tile',
        'description' => 'A tile representing a coordinate in the world',
        'model' => \App\Models\Tile::class,
    ];

    public function fields(): array
    {
        return [
            'world' => [
                'type' => GraphQL::type('World'),
                'description' => 'The world this tile belongs to',
            ],

            'x' => [
                'type' => Type::int(),
                'description' => 'The x coordinate of the tile',
            ],
            'y' => [
                'type' => Type::int(),
                'description' => 'The y coordinate of the tile',
            ],

            'coordinates' => [
                'type' => Type::string(),
                'description' => 'The coordinates of the tile',
                'resolve' => function ($root, array $args) {
                    return $root->x . ',' . $root->y;
                }
            ],

            'terrain_type' => [
                'type' => Type::string(),
                'description' => 'The type of terrain on the tile',
            ],

            // 'object_type',
            // 'object_state',
        ];
    }
}
