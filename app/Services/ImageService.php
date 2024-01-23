<?php

namespace App\Services;

use App\Enums\ImageGenerateProgressEnum;
use App\Enums\ImageStatusEnum;
use App\Factories\Contracts\StorageFactoryInterface;
use App\Services\Contracts\DALLEServiceInterface;
use App\Services\Contracts\ImageServiceInterface;
use App\Services\Contracts\OpenAIServiceInterface;
use App\Traits\UpdatesImageTrait;

class ImageService implements ImageServiceInterface
{
    use UpdatesImageTrait;

    private OpenAIServiceInterface $openAIPrompt;
    private DALLEServiceInterface $openAIGenerateImg;
    private StorageFactoryInterface $storage;

    public function __construct(
        OpenAIServiceInterface $openAIPrompt,
        DALLEServiceInterface $openAIGenerateImg,
        StorageFactoryInterface $storage
    ) {
        $this->openAIPrompt      = $openAIPrompt;
        $this->openAIGenerateImg = $openAIGenerateImg;
        $this->storage           = $storage;
    }


    /**
     * @param  string  $keyword
     * @param  int  $id
     *
     * @return void
     */
    public function handleImageProcessing(string $keyword, int $id): void
    {
        $prompt = $this->openAIPrompt->generatePromptByKeywords($keyword, $id);

        if ($prompt) {
            //process image
            $image    = $this->openAIGenerateImg->generateImage($prompt, $id);
            $filename = $keyword.uniqid('_image_').'.png';

            //save image in storage
            $storage = $this->storage->create();
            $storage->store($filename, $image);

            //save image to database
            $path            = $storage->getPath($filename);
            $imageAttributes = $this->imageAttributes(ImageStatusEnum::COMPLETED, $prompt, $filename, $path,
                ImageGenerateProgressEnum::progressByStatus(ImageStatusEnum::COMPLETED),
                "Image successfully generated.");

            $this->updateImage($id, $imageAttributes);
        }

    }


    /**
     * @param  string  $status
     * @param  string  $prompt
     * @param  string  $filename
     * @param  string  $path
     * @param  int  $progress
     * @param  string  $result
     *
     * @return array
     */
    private function imageAttributes(
        string $status,
        string $prompt,
        string $filename,
        string $path,
        int $progress,
        string $result
    ): array {
        return [
            "status"    => $status,
            "prompt"    => $prompt,
            "file_name" => $filename,
            "file_path" => $path,
            "progress"  => $progress,
            "result"    => $result
        ];
    }

}
