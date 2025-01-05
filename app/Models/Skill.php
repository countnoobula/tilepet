<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'noob_id',
        'name',
        'level',
        'experience',
    ];

    /**
     * Get the noob that owns the skill.
     */
    public function noob()
    {
        return $this->belongsTo(Noob::class);
    }

    /**
     * Increment experience and handle level-up if necessary.
     *
     * @param int $amount
     * @return void
     */
    public function addExperience(int $amount): void
    {
        $this->experience += $amount;
        $skillConfig = config("tilepet.skills.skills.{$this->name}");

        if (!$skillConfig) {
            // Default experience per level if not defined
            $expPerLevel = 100;
        } else {
            $expPerLevel = $skillConfig['experience_per_level'];
        }

        while ($this->experience >= $expPerLevel) {
            $this->experience -= $expPerLevel;
            $this->level += 1;
            // Optionally, you can increase expPerLevel for next level
        }

        $this->save();
    }
}
