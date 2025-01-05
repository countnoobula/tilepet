<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_season',
        'current_year',

        'width',
        'height',
        'tick_count',
    ];

    /**
     * Get all tiles for the world.
     */
    public function worldTiles()
    {
        return $this->hasMany(WorldTile::class);
    }
}
