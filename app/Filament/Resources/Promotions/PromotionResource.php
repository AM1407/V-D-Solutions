<?php

namespace App\Filament\Resources\Promotions;

use App\Filament\Resources\Promotions\Pages\CreatePromotion;
use App\Filament\Resources\Promotions\Pages\EditPromotion;
use App\Filament\Resources\Promotions\Pages\ListPromotions;
use App\Filament\Resources\Promotions\Schemas\PromotionForm;
use App\Filament\Resources\Promotions\Tables\PromotionsTable;
use App\Models\Promo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use UnitEnum;

class PromotionResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static ?string $navigationLabel = 'Promoties';

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 30;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PromotionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromotionsTable::configure($table);
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
            'index' => ListPromotions::route('/'),
            'create' => CreatePromotion::route('/create'),
            'edit' => EditPromotion::route('/{record}/edit'),
        ];
    }

    public static function ensureSingleActivePromo(array $data, ?Promo $record = null): void
    {
        if (! ($data['is_active'] ?? false)) {
            return;
        }

        $activePromoExists = Promo::query()
            ->active()
            ->when($record !== null, fn (Builder $query) => $query->whereKeyNot($record->getKey()))
            ->exists();

        if ($activePromoExists) {
            throw ValidationException::withMessages([
                'is_active' => 'Er kan maar één promo actief zijn. Zet eerst de huidige actieve promo uit.',
            ]);
        }
    }
}
