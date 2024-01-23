<?php

namespace App\Jobs;

use App\Enums\ImageGenerateProgressEnum;
use App\Services\Contracts\ImageServiceInterface;
use App\Traits\UpdatesImageTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GenerateImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, UpdatesImageTrait;

    protected string $keyword;
    protected int $id;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $keyword,
        int $id
    )
    {
        $this->keyword = $keyword;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(ImageServiceInterface $imgService): void
    {
        $this->updateImage($this->id, ["progress" => ImageGenerateProgressEnum::DISPATCH]);
        $imgService->handleImageProcessing($this->keyword, $this->id);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        $this->updateFailedImage($this->id, $exception->getMessage());
    }
}
