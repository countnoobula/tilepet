<?php

namespace App\Services\Prompts;

use Illuminate\Support\Str;

class CreateNoob
{

    public function getPrompt(array $params)
    {
        return Str::replaceArray(":", "
            *Generate a detailed NPC card for a 2D top-down survival game set on :world_environment. The NPC should have unique attributes and a compelling backstory. Ensure realism.*

            **Requirements:**

            1. **Name:** Provide a full name appropriate to the NPC's country of origin.
            2. **Age:** Specify the NPC's age.
            3. **Country of Origin:** Indicate the country where the NPC is from.
            4. **Occupation:** State the NPC's former occupation before arriving on the island.
            5. Skills:
            - **Strength:** (1-10)
            - **Perception:** (1-10)
            - **Endurance:** (1-10)
            - **Charisma:** (1-10)
            - **Intelligence:** (1-10)
            - **Agility:** (1-10)
            - **Luck:** (1-10)
            6. **Cornerstone Narrative:** A brief (3-5 sentences) backstory that explains the NPC's background, personality, and motivations for survival on the island.

            **Formatting Example:**

            ```markdown
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
            ```

            **Instructions:**

            - **Diversity:** Ensure a diverse range of names, ages, and backgrounds to create a varied group of NPCs.
            - **Balance Skills:** Distribute skill points (1-10) in a way that reflects the NPC's background and personality.
            - **Realism:** Incorporate realistic traits and light biases based on the NPC's country of origin and occupation.
            - **Engagement:** Craft cornerstone narratives that provide depth and potential for interactions within the game.
            ", $params);
    }

    public function processResults()
    {
        // @todo - create noob
    }
}
