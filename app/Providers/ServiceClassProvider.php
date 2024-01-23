<?php

namespace App\Providers;

use App\Factories\Contracts\StorageFactoryInterface;
use App\Factories\StorageFactory;
use App\Services\Contracts\DALLEServiceInterface;
use App\Services\Contracts\ImageServiceInterface;
use App\Services\Contracts\OpenAIServiceInterface;
use App\Services\DALLEService;
use App\Services\ImageService;
use App\Services\OpenAIService;
use Illuminate\Support\ServiceProvider;

class ServiceClassProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(OpenAIServiceInterface::class, OpenAIService::class);
        $this->app->bind(DALLEServiceInterface::class, DALLEService::class);
        $this->app->bind(StorageFactoryInterface::class, StorageFactory::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
