<?php

namespace App\Actions;

use OpenAI\Laravel\Facades\OpenAI;

class CreateOpenAIPromptAction
{
    private string $imagePrompt = "Write a 50 word prompt that will be used to generate an AI image. The image is about: ";

    /**
     * @param  string  $keyword
     *
     * @return mixed
     */
    public function createPrompt(string $keyword): mixed
    {
        return OpenAI::completions()->create([
            'model'  => config('openai.model'),
            'prompt' => $this->imagePrompt . $keyword,
            'max_tokens' => 150,
            'temperature' => 0,
        ]);
    }
}
