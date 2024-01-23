<?php

namespace App\Actions;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadFileAction
{
    /**
     * @param  string|null  $filename
     *
     * @return BinaryFileResponse|Notification
     */
    public static function download(?string $filename): BinaryFileResponse|Notification
    {
        if ($filename && Storage::disk(config('filesystems.default'))->exists($filename)) {
            // File exists, proceed with the download
            return response()->download(storage_path("app/public/{$filename}"));
        }

        return Notification::make()
                           ->title('Download failed!')
                           ->body('Image download failed, file not found')
                           ->icon('heroicon-m-x-mark')
                           ->iconColor('danger')
                           ->danger()
                           ->send();
    }
}
