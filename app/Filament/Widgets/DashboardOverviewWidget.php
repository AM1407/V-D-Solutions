<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Services\ServiceResource;
use App\Models\Category;
use App\Models\Project;
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
        return [
            'userName' => Filament::auth()->user()?->name,
            'projectCount' => Project::query()->count(),
            'categoryCount' => Category::query()->count(),
            'serviceCount' => Service::query()->count(),
            'quickActions' => [
                [
                    'label' => 'Nieuw project',
                    'url' => ProjectResource::getUrl('create'),
                    'color' => 'primary',
                    'newTab' => false,
                ],
                [
                    'label' => 'Nieuwe categorie',
                    'url' => CategoryResource::getUrl('create'),
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
                    'label' => 'Bekijk live website',
                    'url' => url('/'),
                    'color' => 'gray',
                    'newTab' => true,
                ],
            ],
        ];
    }
}
