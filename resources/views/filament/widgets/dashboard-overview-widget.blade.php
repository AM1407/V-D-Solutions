<x-filament-widgets::widget class="fi-dashboard-overview-widget">
    <x-filament::section>
        <div class="vd-dashboard-welcome">
            <p class="vd-dashboard-welcome-kicker">Welkom terug</p>
            <h2 class="vd-dashboard-welcome-name">{{ $userName }}</h2>
            <p class="vd-dashboard-welcome-text">Hier heb je snel overzicht en directe acties voor je content.</p>
        </div>

        <div class="vd-dashboard-stats">
            <div class="vd-dashboard-stat-card">
                <p class="vd-dashboard-stat-label">Totaal projecten</p>
                <p class="vd-dashboard-stat-value">{{ $projectCount }}</p>
            </div>

            <div class="vd-dashboard-stat-card">
                <p class="vd-dashboard-stat-label">Totaal diensten</p>
                <p class="vd-dashboard-stat-value">{{ $serviceCount }}</p>
            </div>

            <div class="vd-dashboard-stat-card">
                <p class="vd-dashboard-stat-label">Actieve promo's</p>
                <p class="vd-dashboard-stat-value">{{ $activePromoCount }}</p>
            </div>
        </div>

        <div class="vd-dashboard-actions">
            <h3 class="vd-dashboard-actions-title">Actieve promo</h3>

            @if ($activePromoError)
                <x-filament::section class="mb-4 border-danger-500/20 bg-danger-50">
                    <p class="text-sm font-medium text-danger-700">{{ $activePromoError }}</p>
                </x-filament::section>
            @endif

            @if ($activePromo)
                <x-filament::section
                    style="background-color: {{ $activePromoBannerColor }}; color: {{ $activePromoTextColor }};"
                >
                    <div class="space-y-2">
                        <div class="flex items-center justify-between gap-4">
                            <h4 class="text-lg font-semibold" style="color: {{ $activePromoTextColor }};">
                                {{ $activePromo->title }}
                            </h4>

                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium"
                                style="background-color: rgba(255, 255, 255, 0.18); color: {{ $activePromoTextColor }};"
                            >
                                Actief
                            </span>
                        </div>

                        <div class="text-sm leading-6" style="color: {{ $activePromoTextColor }};">
                            {!! nl2br(e($activePromo->content)) !!}
                        </div>
                    </div>
                </x-filament::section>
            @else
                <x-filament::section class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Er is momenteel geen actieve promo ingesteld.
                    </p>
                </x-filament::section>
            @endif
        </div>

        <div class="vd-dashboard-actions">
            <h3 class="vd-dashboard-actions-title">Quick actions</h3>

            <div class="vd-dashboard-actions-grid">
                @foreach ($quickActions as $action)
                    <x-filament::button
                        :color="$action['color']"
                        :href="$action['url']"
                        :tag="$action['url'] ? 'a' : 'button'"
                        :target="$action['newTab'] ? '_blank' : null"
                        :rel="$action['newTab'] ? 'noopener noreferrer' : null"
                        class="vd-dashboard-action-btn"
                    >
                        {{ $action['label'] }}
                    </x-filament::button>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
