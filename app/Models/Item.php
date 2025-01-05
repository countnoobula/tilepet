<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'targets',
        'effects',
    ];

    protected $casts = [
        'targets' => 'array',
        'effects' => 'array',
    ];

    /**
     * The inventories that contain the item.
     */
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'inventory_items')->withPivot('quantity')->withTimestamps();
    }
}
