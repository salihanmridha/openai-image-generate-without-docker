<?php

namespace App\Services\Contracts;

interface OpenAIServiceInterface
{

    /**
     * @param  string  $keyword
     * @param  int  $id
     *
     * @return mixed
     */
    public function generatePromptByKeywords(string $keyword, int $id): mixed;
}
