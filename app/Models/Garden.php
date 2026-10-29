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

    public function getPriceUsdAttribute(): float
    {
        $rate = (float) config('rosevilla.usd_rate', 310.0);
        if ($rate <= 0) {
            $rate = 310.0;
        }
        return round((float)($this->price_per_day ?? 30000.0) / $rate, 2);
    }
}
