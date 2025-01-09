<?php

namespace Modules\Atlas\Models;

use Modules\Atlas\Enums\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    use HasFactory;

    protected $fillable = [
        # Age and temperment
        'season',
        'year',
        'temperature',
        'humidity',

        'tick_count',

        # Size
        'width',
        'height',
        'seed',

        # Story arch
        'name',
        'keywords',
        'back_story',
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

    public function nuke()
    {
        $this->tiles()->delete();
        // @todo - probably should nuke the lizards too
    }
}
