<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.title')
                    ->label('Dienst')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('URL slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Locatie')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('service')
                    ->label('Dienst')
                    ->relationship('service', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('location')
                    ->label('Locatie')
                    ->options(fn (): array => Project::query()
                        ->whereNotNull('location')
                        ->distinct()
                        ->orderBy('location')
                        ->pluck('location', 'location')
                        ->all())
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('title');
    }
}
