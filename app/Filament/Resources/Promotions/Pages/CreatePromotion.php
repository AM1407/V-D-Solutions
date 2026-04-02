<?php

// ensures there is only one active promo at a time when creating or editing a promo in the admin panel

namespace App\Filament\Resources\Promotions\Pages;

use App\Filament\Resources\Promotions\PromotionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        PromotionResource::ensureSingleActivePromo($data);

        return $data;
    }
}
