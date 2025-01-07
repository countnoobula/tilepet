<?php

namespace App\Services\Prompts;

use Illuminate\Support\Str;

class CreateNoobPortrait
{

    public function getPrompt(array $params)
    {
        return Str::replaceArray(":", "
            Please generate a portrait photo in pixel art of this character:

            **Name:** Alex Martinez

            **Age:** 34

            **Country of Origin:** Spain

            **Occupation:** Marine Biologist

            **Skills:**
            - **Strength:** 6
            - **Perception:** 8
            - **Endurance:** 7
            - **Charisma:** 5
            - **Intelligence:** 9
            - **Agility:** 6
            - **Luck:** 4

            **Cornerstone Narrative:**
            Alex grew up along the coastal regions of Spain, fostering a deep love for the ocean. As a marine biologist, Alex was passionate about studying marine ecosystems. Stranded on the island, Alex uses scientific knowledge to find fresh water and identify edible plants, striving to maintain morale among the group with a calm and analytical approach.


            ", $params);
    }

    public function processResults()
    {
        // @todo - create noob
    }
}
