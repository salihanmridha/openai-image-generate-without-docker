<?php

namespace App\Filament\Resources\GeneratedImageResource\Pages;

use App\Filament\Resources\GeneratedImageResource;
use App\Jobs\GenerateImageJob;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListGeneratedImages extends ListRecords
{
    protected static string $resource = GeneratedImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->after(function (Model $record){
                GenerateImageJob::dispatch($record["keyword"], $record["id"]);
            }),
        ];
    }
}
