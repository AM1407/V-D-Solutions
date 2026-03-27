<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['service_id', 'title', 'slug', 'location', 'description'])]
class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        // Keep project gallery images in one managed collection on cloud/local media disk.
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
            ->useDisk(env('MEDIA_DISK', 'public'));
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
