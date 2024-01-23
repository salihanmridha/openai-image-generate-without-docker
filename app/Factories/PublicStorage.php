<?php

namespace App\Factories;

use App\Factories\Contracts\StorageInterface;
use Illuminate\Support\Facades\Storage;

class PublicStorage implements StorageInterface
{

    /**
     * @param  string  $filename
     * @param  string  $content
     *
     * @return bool
     */
    public function store(string $filename, string $content): bool
    {
        return Storage::disk(config('filesystems.default'))->put($filename, $content);
    }

    public function getPath(string $filename): ?string
    {
        if ($filename){
            return "/storage/" . $filename;
        }

        return null;
    }
}
