<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['title', 'slug', 'content', 'icon'])]
class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
