<?php

namespace Modules\Adam\Prompts;

use Modules\Adam\Enums\Memory;
use Modules\Adam\Models\Noob;
use App\Prompts\Prompt;
use App\Prompts\Traits\WithWorld;

class CreateNoob extends Prompt
{
    use WithWorld;

    public function getPromptTemplate(): string
    {
        return "
            *Generate a detailed NPC card for a 2D top-down survival game set on :world. The NPC should have unique attributes and a compelling backstory.  The response must be in JSON format with the following fields. All fields must be included as they are below.*

            - **Name:** Provide a full name appropriate to the NPC's country of origin.
            - **Age:** Specify the NPC's age.
            - **Country:** Indicate the country where the NPC is from.
            - **Occupation:** State the NPC's former occupation before arriving on the island.
            - **Skills**:
              - **Strength:** (1-10)
              - **Perception:** (1-10)
              - **Endurance:** (1-10)
              - **Charisma:** (1-10)
              - **Intelligence:** (1-10)
              - **Agility:** (1-10)
              - **Luck:** (1-10)
            - **Backstory:** A brief (3-5 sentences) backstory that explains the NPC's background, personality, and motivations for survival on the island.

            **Instructions:**

            - **Diversity:** Ensure a diverse range of names, ages, and backgrounds to create a varied group of NPCs.
            - **Balance Skills:** Distribute skill points (1-10) in a way that reflects the NPC's background and personality.
            - **Realism:** Incorporate realistic traits and light biases based on the NPC's country of origin and occupation.
            - **Engagement:** Craft cornerstone narratives that provide depth and potential for interactions within the game.
        ";
    }

    public function getSubstitutions(): array
    {
        return [
            'world' => $this->world->back_story,
        ];
    }

    public function respond(array $answer) {
        $noob = Noob::create([
            'name' => $answer['Name'],
            'age' => $answer['Age'],
            'country_of_origin' => $answer['Country'],
            'occupation' => $answer['Occupation'],
        ]);

        $noob->giveSkills([
            'strength' => $answer['Skills']['Strength'] ?? 1,
            'perception' => $answer['Skills']['Perception'] ?? 1,
            'endurance' => $answer['Skills']['Endurance'] ?? 1,
            'charisma' => $answer['Skills']['Charisma'] ?? 1,
            'intelligence' => $answer['Skills']['Intelligence'] ?? 1,
            'agility' => $answer['Skills']['Agility'] ?? 1,
            'luck' => $answer['Skills']['Luck'] ?? 1,
        ]);

        $noob->addMemory(Memory::CORNERSTONE, $answer['Backstory']);

        return $noob;
    }
}
