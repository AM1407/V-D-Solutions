<?php

namespace App\Providers;

use App\Listeners\OptimizeMediaOriginalToWebp;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Re-encode newly added media originals to optimized WebP (single stored file strategy).
        Event::listen(MediaHasBeenAddedEvent::class, OptimizeMediaOriginalToWebp::class);
    }
}
