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
