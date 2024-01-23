<?php

namespace App\Filament\Resources\GeneratedImageResource\Pages;

use App\Filament\Resources\GeneratedImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneratedImage extends EditRecord
{
    protected static string $resource = GeneratedImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
