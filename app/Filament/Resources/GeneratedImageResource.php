<?php

namespace App\Filament\Resources;

use App\Actions\DownloadFileAction;
use App\Filament\Resources\GeneratedImageResource\Pages;
use App\Filament\Resources\GeneratedImageResource\RelationManagers;
use App\Models\GeneratedImage;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use RyanChandler\FilamentProgressColumn\ProgressColumn;
use Filament\Infolists;

class GeneratedImageResource extends Resource
{
    protected static ?string $model = GeneratedImage::class;

    protected static ?string $modelLabel = "Image";

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make("keyword")
                             ->required()
                             ->maxLength(255)
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("keyword")
                          ->searchable(),
                ImageColumn::make("file_name")->disk(config('filesystems.default'))->width(150)->height(100)->label("Image"),
                TextColumn::make("status")
                          ->badge()
                          ->color(fn(string $state): string => match ($state) {
                              $state => $state,
                          }),
                ProgressColumn::make("progress")->poll("5s"),
                TextColumn::make("result")->wrap()->label("Log")->limit(100),
            ])->defaultSort("created_at", "desc")
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                                           ->options([
                                               'PROCESSING' => 'PROCESSING',
                                               'COMPLETED'  => 'COMPLETED',
                                               'FAILED'     => 'FAILED',
                                           ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('Download')
                                     ->action(fn(GeneratedImage $record
                                     ) => DownloadFileAction::download($record["file_name"]))->icon("heroicon-o-cloud-arrow-down")
                                                                                             ->color("success"),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()->schema([
                    Infolists\Components\Grid::make(2)->schema([
                        Infolists\Components\TextEntry::make('keyword'),
                        Infolists\Components\TextEntry::make('status')
                                                      ->badge()
                                                      ->color(fn(string $state): string => match ($state) {
                                                          $state => $state,
                                                      }),
                    ]),

                    Infolists\Components\Grid::make(1)->schema([
                        Infolists\Components\TextEntry::make('prompt'),
                    ]),

                    Infolists\Components\Grid::make(1)->schema([
                        Infolists\Components\TextEntry::make('result')->label("Log"),
                    ]),

                    Infolists\Components\Grid::make(1)->schema([
                        Infolists\Components\ImageEntry::make('file_name')->label("Image")->width(350)->height(250),
                    ])
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeneratedImages::route('/'),
            //'create' => Pages\CreateGeneratedImage::route('/create'),
            //'edit' => Pages\EditGeneratedImage::route('/{record}/edit'),
        ];
    }
}
