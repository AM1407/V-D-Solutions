<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_id')
                    ->label('Dienst')
                    ->relationship('service', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->label('Titel')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('URL slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('location')
                    ->label('Locatie'),
                Textarea::make('description')
                    ->label('Beschrijving')
                    ->columnSpanFull(),
                // Upload image to Spatie media collection; model handles WebP conversion.
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Afbeeldingen')
                    ->collection('images')
                    ->disk(env('MEDIA_DISK', 'public'))
                    ->multiple()
                    // Enforce business rule: max 5 photos per project.
                    ->maxFiles(5)
                    ->image()
                    // Resize originals during upload so only optimized source files are stored.
                    ->automaticallyResizeImagesToWidth('1920')
                    ->automaticallyResizeImagesToHeight('1920')
                    // WebP re-encoding of originals is handled by the media added event listener.
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
            ]);
    }
}
