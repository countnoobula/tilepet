<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noob;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = array_keys(config('tilepet.skills.skills'));

        Noob::all()->each(function ($noob) use ($skills) {
            foreach ($skills as $skillName) {
                Skill::firstOrCreate([
                    'noob_id' => $noob->id,
                    'name' => $skillName,
                ]);
            }
        });
    }
}
