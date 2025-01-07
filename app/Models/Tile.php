<?php

namespace App\Models;

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

    /**
     * Get the entity (e.g., plant) on the tile.
     */
    public function entity()
    {
        return $this->hasOne(Entity::class);
    }
}
