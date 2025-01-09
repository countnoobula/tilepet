<?php

namespace App\Prompts;

use App\Prompts\Traits\HasJsonCleaner;
use OpenAI\Client;

abstract class Prompt
{
    use HasJsonCleaner;

    private ?Client $client = null;

    public static function prompt()
    {
        return new (get_called_class());
    }

    abstract public function getPromptTemplate(): string;

    abstract public function getSubstitutions(): array;

    abstract public function respond(array $answer);

    public function answer()
    {
        $response = $this->getOpenAIClient()->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->getFullPrompt(),
                ],
            ],
        ]);

        return $this->cleanJson($response['choices'][0]['message']['content']);
    }

    public function getFullPrompt(): string
    {
        return $this->replacePlaceholders($this->getPromptTemplate(), $this->getSubstitutions());
    }

    private function replacePlaceholders(string $template, array $values): string
    {
        foreach ($values as $key => $value) {
            $template = str_replace(':' . $key, $value, $template);
        }

        return $template;
    }

    protected function getOpenAIClient()
    {
        if ($this->client === null) {
            $this->client = \OpenAI::factory()
                ->withBaseUri(config('services.openai.base_url'))
                ->withHttpHeader('api-key', config('services.openai.api_key'))
                ->make();
        }

        return $this->client;
    }

    public function resolve()
    {
        return $this->respond($this->answer());
    }
}
