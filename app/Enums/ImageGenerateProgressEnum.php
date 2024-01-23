<?php

namespace App\Enums;
enum ImageGenerateProgressEnum
{
    const DISPATCH = 20;
    const PROMPT = 50;
    const IMAGE = 90;

    /**
     * @param  string  $status
     *
     * @return int
     */
    static function progressByStatus(string $status): int
    {
        return match($status) {
            "PROCESSING" => 10,
            "COMPLETED", "FAILED" => 100,
        };
    }
}
