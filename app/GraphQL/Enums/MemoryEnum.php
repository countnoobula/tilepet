<?php

declare(strict_types=1);

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class MemoryEnum extends EnumType
{
    protected $attributes = [
        'name' => 'MemoryEnum',
        'description' => 'The memory types as enums',
        'values' => [
            'CORNERSTONE' => [
                'value' => 'Cornerstone',
                'description' => 'The key memory that drives their decisions',
            ],
            'LIFE_EVENT' => [
                'value' => 'Life Event',
                'description' => 'A memory such as a birth, death, or marriage',
            ],
            'MOMENT' => [
                'value' => 'Moment',
                'description' => 'A moment such as a discovery, moment, ',
            ],
        ],
    ];
}
