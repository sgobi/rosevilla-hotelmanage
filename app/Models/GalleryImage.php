<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image_url',
        'description',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
