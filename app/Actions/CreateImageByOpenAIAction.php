<?php

namespace App\Actions;

use OpenAI\Laravel\Facades\OpenAI;

class CreateImageByOpenAIAction
{
    private int $numberOfImg = 1;
    private string $imgSize = '1024x1024';

    /**
     * @param  string  $prompt
     *
     * @return mixed
     */
    public function createImage(string $prompt): mixed
    {
        return OpenAI::images()->create([
            'prompt' => $prompt,
            'n' => $this->numberOfImg,
            'size' => $this->imgSize,
            'response_format' => 'b64_json',
        ]);
    }
}
