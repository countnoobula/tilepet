<?php

namespace App\Services\Functions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LLMService
{
    protected static $apiEndpoint;
    protected static $apiKey;
    protected static $batchMode;
    protected static $model;
    protected static $actionsConfig;

    /**
     * Initialize the service with API credentials and actions.
     *
     * @return void
     */
    public static function initialize()
    {
        self::$apiKey = config('tilepet.llm.api_key');
        self::$apiEndpoint = config('tilepet.llm.endpoint');
        self::$batchMode = config('tilepet.llm.batch_mode', false);
        self::$model = config('tilepet.llm.model', 'gpt-4');
        self::$actionsConfig = config('tilepet.actions.actions');
    }

    /**
     * Get the next actions for noobs based on their states.
     *
     * @param array $states
     * @return array|null
     */
    public static function getActionsForNoobs(array $states)
    {
        self::initialize();

        if (self::$batchMode) {
            return self::getBatchActions($states);
        } else {
            return self::getIndividualActions($states);
        }
    }

    /**
     * Get actions for noobs in batch mode using OpenAI's API.
     *
     * @param array $states
     * @return array|null
     */
    protected static function getBatchActions(array $states)
    {
        $prompt = self::buildBatchPrompt($states);
        $functions = self::getFunctionDefinitions();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . self::$apiKey,
                'Content-Type' => 'application/json',
            ])->post(self::$apiEndpoint, [
                'model' => self::$model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an autonomous agent controlling multiple noobs in a sandbox world. Provide a JSON array of actions corresponding to each noob based on their current state.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'functions' => $functions,
                'function_call' => ['name' => null],
                'temperature' => 0.7, // Adjust as needed
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['choices'][0]['message']['function_call'])) {
                    $functionCall = $data['choices'][0]['message']['function_call'];
                    return $functionCall;
                } else {
                    Log::error('LLM API did not return function_call in batch mode.');
                }
            } else {
                Log::error('LLM API Error (Batch Mode): ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('LLMService Exception (Batch Mode): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get actions for noobs individually using OpenAI's API.
     *
     * @param array $states
     * @return array|null
     */
    protected static function getIndividualActions(array $states)
    {
        $actions = [];

        foreach ($states as $state) {
            $prompt = self::buildIndividualPrompt($state);
            $functions = self::getFunctionDefinitions();

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . self::$apiKey,
                    'Content-Type' => 'application/json',
                ])->post(self::$apiEndpoint, [
                    'model' => self::$model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are an autonomous agent controlling a noob in a sandbox world. Provide an action based on the current state.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'functions' => $functions,
                    'function_call' => ['name' => null],
                    'temperature' => 0.7, // Adjust as needed
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['choices'][0]['message']['function_call'])) {
                        $functionCall = $data['choices'][0]['message']['function_call'];
                        $actions[] = $functionCall;
                    } else {
                        Log::error('LLM API did not return function_call in individual mode.');
                    }
                } else {
                    Log::error('LLM API Error (Individual Mode): ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('LLMService Exception (Individual Mode): ' . $e->getMessage());
            }
        }

        return $actions;
    }

    /**
     * Build the batch prompt to send to the LLM.
     *
     * @param array $states
     * @return string
     */
    protected static function buildBatchPrompt(array $states)
    {
        $prompt = "You are controlling multiple noobs in a sandbox world. Here are their current statuses:\n\n";

        foreach ($states as $state) {
            $prompt .= "Noob ID: {$state['noob_id']}\n";
            $prompt .= "- **Needs:**\n";
            foreach ($state['needs'] as $need => $value) {
                $prompt .= "  - " . ucfirst($need) . ": {$value}\n";
            }
            $prompt .= "- **Skills:**\n";
            foreach ($state['skills'] as $skill => $level) {
                $prompt .= "  - " . ucfirst($skill) . ": {$level}\n";
            }
            $prompt .= "- **Location:**\n";
            $prompt .= "  - Coordinates: ({$state['location']['x']}, {$state['location']['y']})\n\n";
        }

        $prompt .= "Available actions for each noob:\n";
        $prompt .= "1. Move North\n2. Move South\n3. Move East\n4. Move West\n";
        $prompt .= "5. Gather Water\n6. Gather Food\n7. Socialize with another noob\n";
        $prompt .= "8. Use Tool\n";
        $prompt .= "9. Harvest Plant\n";
        // Add more actions as needed

        $prompt .= "Provide a JSON array of function calls, each representing an action for a noob. Each function call should include the 'noob_id' and the corresponding action parameters. Example:\n\n";
        $prompt .= "[\n";
        $prompt .= "  {\n";
        $prompt .= "    \"name\": \"move\",\n";
        $prompt .= "    \"arguments\": { \"noob_id\": 1, \"direction\": \"north\" }\n";
        $prompt .= "  },\n";
        $prompt .= "  {\n";
        $prompt .= "    \"name\": \"gather\",\n";
        $prompt .= "    \"arguments\": { \"noob_id\": 2, \"resource\": \"wood\" }\n";
        $prompt .= "  }\n";
        $prompt .= "]\n\n";

        $prompt .= "Ensure that each function call is valid and corresponds to the defined functions.";

        return $prompt;
    }

    /**
     * Build the individual prompt for a single noob.
     *
     * @param array $state
     * @return string
     */
    protected static function buildIndividualPrompt(array $state)
    {
        $prompt = "You are controlling a noob in a sandbox world. Here is the noob's current status:\n\n";
        $prompt .= "Noob ID: {$state['noob_id']}\n";
        $prompt .= "- **Needs:**\n";
        foreach ($state['needs'] as $need => $value) {
            $prompt .= "  - " . ucfirst($need) . ": {$value}\n";
        }
        $prompt .= "- **Skills:**\n";
        foreach ($state['skills'] as $skill => $level) {
            $prompt .= "  - " . ucfirst($skill) . ": {$level}\n";
        }
        $prompt .= "- **Location:**\n";
        $prompt .= "  - Coordinates: ({$state['location']['x']}, {$state['location']['y']})\n\n";

        $prompt .= "Available actions:\n";
        $prompt .= "1. Move North\n2. Move South\n3. Move East\n4. Move West\n";
        $prompt .= "5. Gather Water\n6. Gather Food\n7. Socialize with another noob\n";
        $prompt .= "8. Use Tool\n";
        $prompt .= "9. Harvest Plant\n";
        // Add more actions as needed

        $prompt .= "Choose the next action by invoking one of the available functions. Provide the function call in JSON format. Example:\n\n";
        $prompt .= "{\n";
        $prompt .= "  \"name\": \"move\",\n";
        $prompt .= "  \"arguments\": { \"noob_id\": 1, \"direction\": \"north\" }\n";
        $prompt .= "}\n\n";

        $prompt .= "Ensure that the function call is valid and corresponds to the defined functions.";

        return $prompt;
    }

    /**
     * Retrieve function definitions from the actions configuration.
     *
     * @return array
     */
    protected static function getFunctionDefinitions(): array
    {
        return array_values(self::$actionsConfig);
    }
}
