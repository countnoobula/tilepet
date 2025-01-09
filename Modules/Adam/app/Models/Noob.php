<?php

namespace Modules\Adam\Models;

use Modules\Adam\Enums\Memory as MemoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noob extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'country_of_origin',
        'occupation',

        # Position in world
        'position_x',
        'position_y',
    ];

    # Needs are relationship
    # Skills are relationship
    # Memories are relationship

    /**
     * Get the skills associated with the noob.
     */
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function memories()
    {
        return $this->hasMany(Memory::class);
    }

    public function getSkill(string $name)
    {
        return $this->skills->where('name', $name)->first();
    }

    public function giveSkills(array $skills)
    {
        foreach ($skills as $name => $level) {
            $this->skills()->firstOrCreate([
                'name' => $name,
                'level' => $level,
            ]);
        }
    }

    public function addMemory(MemoryEnum $type, $text)
    {
        $this->memories()->create([
            'type' => $type->value,
            'text' => $text,
        ]);
    }

    public function getCornerstoneMemory()
    {
        return $this->memories->where('type', MemoryEnum::CORNERSTONE->value)->first();
    }
}
