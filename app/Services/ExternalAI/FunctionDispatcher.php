<?php

namespace App\Services;

use App\Jobs\ProcessActionJob;
use Illuminate\Support\Facades\Log;

class FunctionDispatcher
{
    /**
     * Dispatch the appropriate jobs based on the function calls.
     *
     * @param array $functionCall
     * @return void
     */
    public static function dispatchFunction(array $functionCall)
    {
        $actionsConfig = config('tilepet.actions.actions');

        // Check if multiple function calls are present
        if (isset($functionCall['name']) && isset($functionCall['arguments'])) {
            // Single function call
            self::dispatchSingleAction($functionCall, $actionsConfig);
        } elseif (is_array($functionCall)) {
            // Multiple function calls
            foreach ($functionCall as $singleFunctionCall) {
                if (isset($singleFunctionCall['name']) && isset($singleFunctionCall['arguments'])) {
                    self::dispatchSingleAction($singleFunctionCall, $actionsConfig);
                } else {
                    Log::warning('Invalid function call format in batch: ' . json_encode($singleFunctionCall));
                }
            }
        } else {
            Log::warning('Invalid function call structure: ' . json_encode($functionCall));
        }
    }

    /**
     * Dispatch a single action based on the function call.
     *
     * @param array $functionCall
     * @param array $actionsConfig
     * @return void
     */
    protected static function dispatchSingleAction(array $functionCall, array $actionsConfig)
    {
        $actionName = $functionCall['name'];
        $arguments = $functionCall['arguments'];

        if (!isset($actionsConfig[$actionName])) {
            Log::warning("Action '{$actionName}' is not defined in configuration.");
            return;
        }

        $actionClass = $actionsConfig[$actionName]['class'];

        if (!class_exists($actionClass)) {
            Log::warning("Action class '{$actionClass}' does not exist for action '{$actionName}'.");
            return;
        }

        // Instantiate the action and execute it
        try {
            $actionInstance = app($actionClass);
            if ($actionInstance instanceof ActionInterface) {
                $actionInstance->execute($arguments);
            } else {
                Log::warning("Action class '{$actionClass}' does not implement ActionInterface.");
            }
        } catch (\Exception $e) {
            Log::error("Failed to execute action '{$actionName}': " . $e->getMessage());
        }
    }
}
