<?php

declare(strict_types=1);

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class SeasonEnum extends EnumType
{
    protected $attributes = [
        'name' => 'SeasonEnum',
        'description' => 'The seasons as enums',
        'values' => [
            'SPRING' => [
                'value' => 'Spring',
                'description' => 'The season of rebirth',
            ],
            'SUMMER' => [
                'value' => 'Summer',
                'description' => 'The hottest season of the year',
            ],
            'AUTUMN' => [
                'value' => 'Autumn',
                'description' => 'The season of harvest',
            ],
            'WINTER' => [
                'value' => 'Winter',
                'description' => 'The coldest season of the year',
            ],
        ],
    ];
}
