<?php

namespace App\Services\Contracts;

interface DALLEServiceInterface
{

    /**
     * @param  string  $prompt
     * @param  int  $id
     *
     * @return mixed
     */
    public function generateImage(string $prompt, int $id): mixed;
}
