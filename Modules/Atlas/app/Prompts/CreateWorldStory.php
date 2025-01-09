<?php

namespace Modules\Atlas\Prompts;

use App\Prompts\Prompt;
use App\Prompts\Traits\WithWorld;

class CreateWorldStory extends Prompt
{
    use WithWorld;

    public function getPromptTemplate(): string
    {
        return "
            You are a world-building assistant. Given the following keywords, generate a detailed description of a fictional world. The response must be in JSON format with the following fields:

            - **Name**: The name of the world.
            - **CurrentSeason**: One of \"Spring\", \"Summer\", \"Autumn\", or \"Winter\".
            - **CurrentYear**: An integer representing the current year in the world's timeline.
            - **CurrentHumidity**: The current humidity percentage (0-100).
            - **CurrentTemperature**: The current temperature in Celsius.
            - **Backstory**: A two-paragraph description of what the planet looks like or what it is like, before explaining any significant events that have occurred.
            - **SeasonLengthDays**: The length of each season in days (between 30 and 90).
            - **MaxSummerTemperature**: The maximum temperature during Summer in Celsius.
            - **MinWinterTemperature**: The lowest temperature during Winter in Celsius.

            **Keywords:** :keywords

            **The JSON object:**
        ";
    }

    public function getSubstitutions(): array
    {
        return [
            'keywords' => $this->world->keywords,
        ];
    }

    public function respond(array $answer)
    {
        $this->world->update([
            "name" => $answer['Name'],
            "season" => $answer['CurrentSeason'],
            "year" => $answer['CurrentYear'],
            "humidity" => $answer['CurrentHumidity'],
            "temperature" => $answer['CurrentTemperature'],
            "back_story" => $answer['Backstory'],
            //   "SeasonLengthDays" => 60
            //   "MaxSummerTemperature" => 35
            //   "MinWinterTemperature" => 20
        ]);

        return $this->world;
    }
}
