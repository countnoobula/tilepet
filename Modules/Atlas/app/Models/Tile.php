<?php

namespace Modules\Atlas\Models;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    protected $fillable = [
        'world_id',
        'x',
        'y',
        'terrain_type',
        'object_type',
        'object_state',
    ];

    /**
     * Get the world that owns the tile.
     */
    public function world()
    {
        return $this->belongsTo(World::class);
    }
}
