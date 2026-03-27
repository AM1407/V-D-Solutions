<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Naam van de dienst')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('URL slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                RichEditor::make('content')
                    ->label('Beschrijving van de dienst')
                    ->required()
                    ->columnSpanFull(),
                // Upload image to Spatie media collection; model handles WebP conversion.
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Afbeelding')
                    ->collection('images')
                    ->disk(env('MEDIA_DISK', 'public'))
                    ->image()
                    // Resize originals during upload so only optimized source files are stored.
                    ->automaticallyResizeImagesToWidth('1920')
                    ->automaticallyResizeImagesToHeight('1920')
                    // WebP re-encoding of originals is handled by the media added event listener.
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/heic', 'image/heif']),
                TextInput::make('icon')
                    ->label('Icoon'),
            ]);
    }
}
