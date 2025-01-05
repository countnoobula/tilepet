<?php

return [
    # OpenAI Compatible API
    'endpoint' => env('LLM_ENDPOINT'),
    'api_key' => env('LLM_API_KEY'),
    'model' => env('LLM_MODEL', 'gpt-4o-mini'),
    'batch_mode' => env('LLM_BATCH_MODE', false),
];
