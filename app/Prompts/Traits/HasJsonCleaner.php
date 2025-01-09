<?php

namespace App\Prompts\Traits;

use Illuminate\Support\Str;

trait HasJsonCleaner
{
    public function cleanJson(string $json): array
    {
        $json_parts = explode("\n", $json);
        if (Str::contains($json_parts[0], 'json')) {
            $json_parts = array_slice($json_parts, 1, count($json_parts) - 2);
            $json = implode('', $json_parts);
        }

        return json_decode($json, JSON_PRETTY_PRINT);
    }
}
