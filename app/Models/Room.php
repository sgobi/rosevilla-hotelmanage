<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'amenities',
        'price_per_night',
        'capacity',
        'bed_type',
        'featured_image',
        'gallery_urls',
        'is_active',
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery_urls' => 'array',
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
