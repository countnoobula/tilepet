<?php

namespace Modules\Adam\Actions;

/**
 * Interface ActionInterface
 *
 * Defines a contract for all action classes.
 * Each action must implement the execute method to perform its specific logic.
 */
interface ActionInterface
{
    /**
     * Execute the action with the given parameters.
     *
     * @param array $parameters An associative array of parameters required to perform the action.
     * @return void
     */
    public function execute(array $parameters): void;
}
