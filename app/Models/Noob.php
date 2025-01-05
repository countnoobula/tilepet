<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noob extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position_x',
        'position_y',
        'hunger',
        'thirst',
        'social',
        'strength',
        'perception',
        'endurance',
        'charisma',
        'intelligence',
        'agility',
        'luck',
    ];

    /**
     * Get the LLM responses associated with the noob.
     */
    public function llm_responses()
    {
        return $this->hasMany(LLMResponse::class);
    }

    /**
     * Get the inventory associated with the noob.
     */
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
