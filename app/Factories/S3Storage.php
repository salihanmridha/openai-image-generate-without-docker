<?php

namespace App\Factories;

use App\Factories\Contracts\StorageInterface;

class S3Storage implements StorageInterface
{
    public function store(string $filename, string $content): bool
    {
        return true;
    }

    public function getPath(string $filename): ?string
    {
        return "";
    }
}
