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

    public function isHeritageRoom(): bool
    {
        return $this->slug === 'heritage-room'
            || $this->slug === 'heritage-suite'
            || strcasecmp((string)$this->title, 'Heritage Room') === 0
            || strcasecmp((string)$this->title, 'Heritage Suite') === 0;
    }

    public function getBedTypeAttribute($value)
    {
        if ($this->isHeritageRoom()) {
            return config('heritage_room.bed_type')
                ?? config('rosevilla.heritage_room.bed_type')
                ?? ($value ?: 'Queen bed + daybed');
        }
        return $value;
    }

    public function getCapacityAttribute($value)
    {
        if ($this->isHeritageRoom()) {
            $configured = config('heritage_room.capacity')
                ?? config('rosevilla.heritage_room.capacity');
            return $configured !== null ? (int)$configured : ($value ?: 3);
        }
        return $value;
    }

    public function getDescriptionAttribute($value)
    {
        if ($this->isHeritageRoom()) {
            $configured = config('heritage_room.description')
                ?? config('rosevilla.heritage_room.description');
            if (!empty($configured)) {
                return $configured;
            }
        }
        return $value ? str_replace('opensdirectly', 'opens directly', $value) : $value;
    }

    public function getAmenitiesAttribute($value)
    {
        $amenities = is_string($value) ? json_decode($value, true) : $value;
        if (!is_array($amenities)) {
            $amenities = [];
        }

        if ($this->isHeritageRoom()) {
            $configured = config('heritage_room.amenities')
                ?? config('rosevilla.heritage_room.amenities');
            if (is_array($configured) && !empty($configured)) {
                return $configured;
            }
            // Remove conflicting King canopy bed or double bed entries if present
            $amenities = array_values(array_filter($amenities, function ($item) {
                return !stripos($item, 'king canopy') && !stripos($item, 'double bed');
            }));
        }

        return $amenities;
    }

    public function getPriceUsdAttribute(): float
    {
        $rate = (float) config('rosevilla.usd_rate', 310.0);
        if ($rate <= 0) {
            $rate = 310.0;
        }
        return round((float)$this->price_per_night / $rate, 2);
    }
}
