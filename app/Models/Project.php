<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category_id', 'title', 'slug', 'location', 'description'])]
class Project extends Model
{
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
