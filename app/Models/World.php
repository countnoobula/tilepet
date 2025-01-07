<?php

namespace App\Models;

use App\Enums\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        'season',
        'year',
        'temperature',
        'humidity',

        'tick_count',

        'width',
        'height',
        'seed',
    ];

    protected function casts()
    {
        return [
            'season' => Season::class,
        ];
    }

    /**
     * Get all tiles for the world.
     */
    public function tiles()
    {
        return $this->hasMany(Tile::class);
    }
}
