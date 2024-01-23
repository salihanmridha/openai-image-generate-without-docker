<?php

namespace App\Traits;

use App\Enums\ImageGenerateProgressEnum;
use App\Enums\ImageStatusEnum;
use App\Models\GeneratedImage;

trait UpdatesImageTrait
{
    /**
     * @param  int  $id
     * @param  array  $arr
     *
     * @return void
     */
    public function updateImage(int $id, array $arr): void
    {
        GeneratedImage::find($id)->update($arr);
    }

    public function updateFailedImage(int $id, ?string $msg = null): void
    {
        $this->updateImage($id, [
            "progress" => ImageGenerateProgressEnum::progressByStatus(ImageStatusEnum::FAILED),
            "status" => ImageStatusEnum::FAILED,
            "result" => $msg,
        ]);
    }
}
