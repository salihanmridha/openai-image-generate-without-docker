<?php

namespace App\Factories;

use App\Factories\Contracts\StorageFactoryInterface;
use App\Factories\Contracts\StorageInterface;

class StorageFactory implements StorageFactoryInterface
{
    /**
     * @return StorageInterface
     */
    public function create(): StorageInterface
    {
        $storageType = config('filesystems.default');

        return match ($storageType) {
            'public' => new PublicStorage(),
            's3' => new S3Storage(),
            default => throw new \RuntimeException("Unsupported storage type: $storageType"),
        };
    }
}
