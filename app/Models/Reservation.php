<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'room_id',
        'guest_name',
        'email',
        'phone',
        'check_in',
        'check_out',
        'guests',
        'arrival_time',
        'message',
        'status',
        'total_price',
        'discount_percentage',
        'discount_status',
        'discount_approved_by',
        'invoice_print_count',
        'invoice_reprint_status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'guests' => 'integer',
        'total_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    public function getFinalPriceAttribute()
    {
        if ($this->discount_status === 'approved' && $this->discount_percentage > 0) {
            return $this->total_price * (1 - ($this->discount_percentage / 100));
        }
        return $this->total_price;
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'discount_approved_by');
    }

    protected static function booted()
    {
        static::creating(function ($reservation) {
            if ($reservation->room_id && $reservation->check_in && $reservation->check_out) {
                $days = $reservation->check_in->diffInDays($reservation->check_out);
                // Ensure at least 1 night
                $days = $days > 0 ? $days : 1;
                
                $room = Room::find($reservation->room_id);
                if ($room) {
                    $reservation->total_price = $room->price_per_night * $days;
                }
            }
        });
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
