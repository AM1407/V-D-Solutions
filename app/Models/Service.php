<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'content', 'icon'])]
class Service extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
