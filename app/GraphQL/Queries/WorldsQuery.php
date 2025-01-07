<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\World;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class WorldsQuery extends Query
{
    protected $attributes = [
        'name' => 'worlds',
        'description' => 'A query of all the worlds'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('World'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();       // Columns to select
        $with = $fields->getRelations();      // Relations to eager load

        // Initialize the query with selected fields and relations
        $query = World::select($select)->with($with);

        // Apply filters based on arguments
        if (isset($args['id'])) {
            $query->where('id', $args['id']);
        }

        // You can add more conditional filters here based on additional arguments

        // Execute the query and return the results
        return $query->get();
    }
}
