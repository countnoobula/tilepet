<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'world_tile_id',
        'type',
        'state',
        'inventory',
        'spawnable',
    ];

    protected $casts = [
        'inventory' => 'array',
    ];

    /**
     * Get the world tile that owns the entity.
     */
    public function worldTile()
    {
        return $this->belongsTo(WorldTile::class);
    }

    /**
     * Get the inventory if the entity is a chest.
     */
    public function inventory()
    {
        if ($this->inventory && $this->inventory['enabled']) {
            return $this->morphOne(Inventory::class, 'owner');
        }

        return null;
    }
}
