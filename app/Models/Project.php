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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
