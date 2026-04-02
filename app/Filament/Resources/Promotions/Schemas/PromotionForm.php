<?php

namespace App\Filament\Resources\Promotions\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titel')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Bannertekst')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Actief')
                    ->default(false),
                ColorPicker::make('banner_color')
                    ->label('Bannerkleur')
                    ->required()
                    ->default('#4f46e5'),
            ]);
    }
}
