<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Promotions\PromotionResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Models\Project;
use App\Models\Promo;
use App\Models\Service;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class DashboardOverviewWidget extends Widget
{
    protected static ?int $sort = -4;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    /**
     * @var view-string
     */
    protected string $view = 'filament.widgets.dashboard-overview-widget';

    protected function getViewData(): array
    {
        $activePromoCount = Promo::query()->active()->count();
        $activePromo = Promo::query()->active()->latest()->first();
        $activePromoBannerColor = $activePromo?->banner_color ?? '#4f46e5';

        return [
            'userName' => Filament::auth()->user()?->name,
            'projectCount' => Project::query()->count(),
            'serviceCount' => Service::query()->count(),
            'promoCount' => Promo::query()->count(),
            'activePromoCount' => $activePromoCount,
            'activePromo' => $activePromo,
            'activePromoBannerColor' => $activePromoBannerColor,
            'activePromoTextColor' => $this->getContrastColor($activePromoBannerColor),
            'activePromoError' => $activePromoCount > 1
                ? 'Er zijn meerdere actieve promoties. Zet er eerst maar één actief.'
                : null,
            'promoResourceUrl' => PromotionResource::getUrl('index'),
            'quickActions' => [
                [
                    'label' => 'Nieuw project',
                    'url' => ProjectResource::getUrl('create'),
                    'color' => 'primary',
                    'newTab' => false,
                ],
                [
                    'label' => 'Nieuwe dienst',
                    'url' => ServiceResource::getUrl('create'),
                    'color' => 'primary',
                    'newTab' => false,
                ],
                [
                    'label' => 'Promoties beheren',
                    'url' => PromotionResource::getUrl('index'),
                    'color' => 'primary',
                    'newTab' => false,
                ],
                [
                    'label' => 'Bekijk live website',
                    'url' => url('/'),
                    'color' => 'gray',
                    'newTab' => true,
                ],
            ],
        ];
    }

    private function getContrastColor(string $hexColor): string
    {
        $hexColor = ltrim($hexColor, '#');

        if (strlen($hexColor) !== 6) {
            return '#ffffff';
        }

        $red = hexdec(substr($hexColor, 0, 2));
        $green = hexdec(substr($hexColor, 2, 2));
        $blue = hexdec(substr($hexColor, 4, 2));

        $luminance = (0.299 * $red) + (0.587 * $green) + (0.114 * $blue);

        return $luminance > 186 ? '#111827' : '#ffffff';
    }
}
