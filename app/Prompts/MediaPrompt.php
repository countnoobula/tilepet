<?php

namespace App\Prompts;

abstract class MediaPrompt extends Prompt
{
    public function answer()
    {
        $response = $this->getOpenAIClient()->images()->create([
            'model' => 'dall-e-3',
            'prompt' => $this->getFullPrompt(),
            'n' => 1,
            'size' => '1024x1024',
            'response_format' => 'url',
        ]);

        return $response->data[0]->toArray();
    }
}