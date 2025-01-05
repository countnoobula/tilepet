<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'owner_type',
    ];

    /**
     * Get the owning model (Noob or Entity).
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * The items that belong to the inventory.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'inventory_items')->withPivot('quantity')->withTimestamps();
    }

    /**
     * Add an item to the inventory.
     *
     * @param string $itemName
     * @param int $quantity
     * @return void
     */
    public function addItem(string $itemName, int $quantity = 1)
    {
        $item = Item::where('name', $itemName)->first();
        if ($item) {
            $this->items()->syncWithoutDetaching([
                $item->id => ['quantity' => DB::raw("quantity + {$quantity}")],
            ]);
        }
    }
}
