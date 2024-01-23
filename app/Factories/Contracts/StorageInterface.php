<?php

namespace App\Factories\Contracts;

interface StorageInterface
{
    /**
     * @param  string  $filename
     * @param  string  $content
     *
     * @return bool
     */
    public function store(string $filename, string $content): bool;

    /**
     * @param  string  $filename
     *
     * @return string|null
     */
    public function getPath(string $filename): ?string;
}
