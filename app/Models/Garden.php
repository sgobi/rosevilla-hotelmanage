<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'max_guests',
        'features',
        'price_per_day',
    ];

    protected $casts = [
        'features' => 'array',
        'price_per_day' => 'decimal:2',
    ];
}
