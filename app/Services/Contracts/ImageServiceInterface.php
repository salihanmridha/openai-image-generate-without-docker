<?php

namespace App\Services\Contracts;

interface ImageServiceInterface
{
    /**
     * @param  string  $keyword
     * @param  int  $id
     *
     * @return void
     */
    public function handleImageProcessing(string $keyword, int $id): void;
}
