<?php

namespace Modules\Adam\Prompts;

use App\Prompts\MediaPrompt;
use App\Prompts\Traits\WithNoob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateNoobPortrait extends MediaPrompt
{
    use WithNoob;

    public function getPromptTemplate(): string
    {
        return "
            Please generate a portrait photo in pixel art of this character:

            **Name:** :name

            **Age:** :age

            **Country of Origin:** :country

            **Occupation:** :occupation

            **Skills:**
            - **Strength:** :skill_strength
            - **Perception:** :skill_perception
            - **Endurance:** :skill_endurance
            - **Charisma:** :skill_charisma
            - **Intelligence:** :skill_intelligence
            - **Agility:** :skill_agility
            - **Luck:** :skill_luck

            **Cornerstone Narrative:**
            :cornerstone_narrative
        ";
    }

    public function getSubstitutions(): array
    {
        return [
            'name' => $this->noob->name,
            'age' => $this->noob->age,
            'country' => $this->noob->country_of_origin,
            'occupation' => $this->noob->occupation,
            'skill_strength' => $this->noob->getSkill('strength')->level,
            'skill_perception' => $this->noob->getSkill('perception')->level,
            'skill_endurance' => $this->noob->getSkill('endurance')->level,
            'skill_charisma' => $this->noob->getSkill('charisma')->level,
            'skill_intelligence' => $this->noob->getSkill('intelligence')->level,
            'skill_agility' => $this->noob->getSkill('agility')->level,
            'skill_luck' => $this->noob->getSkill('luck')->level,
            'cornerstone_narrative' => $this->noob->getCornerstoneMemory()->text,
        ];
    }

    public function respond(array $answer) {
        $portrait = Http::get($answer['url']);
        Storage::put('portraits/' . $this->noob->id . '.png', $portrait->body());
    }
}
