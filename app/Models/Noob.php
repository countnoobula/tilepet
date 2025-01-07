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

        # These are the needs
        'hunger',
        'thirst',
        'social',
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
        return $this->morphOne(Inventory::class, 'owner');
    }

    /**
     * Get the skills associated with the noob.
     */
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Retrieve a specific skill by name.
     *
     * @param string $skillName
     * @return Skill|null
     */
    public function getSkill(string $skillName): ?Skill
    {
        return $this->skills()->where('name', $skillName)->first();
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($noob) {
            $skills = array_keys(config('tilepet.skills.skills'));

            foreach ($skills as $skillName) {
                $noob->skills()->create([
                    'name' => $skillName,
                    'level' => 1,
                    'experience' => 0,
                ]);
            }
        });
    }
}
