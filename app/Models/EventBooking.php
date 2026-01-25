<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'guests',
        'message',
        'status',
        'total_price',
        'tax_percentage',
        'tax_amount',
        'invoice_print_count',
        'invoice_reprint_status',
        'discount_percentage',
        'discount_status',
        'discount_approved_by',
        'conflict_status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'guests' => 'integer',
        'total_price' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            // Apply current tax rate
            $taxRate = \App\Models\ContentSetting::getValue('tax_percentage', 0);
            $booking->tax_percentage = $taxRate;
            // Note: total_price for events is usually set manually in admin or during booking logic.
            // If total_price is already set, calculate tax.
            if ($booking->total_price > 0) {
                $booking->tax_amount = ($booking->total_price * $taxRate) / 100;
            }
        });
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'discount_approved_by');
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->discount_percentage > 0 && $this->total_price > 0) {
            return ($this->total_price * $this->discount_percentage) / 100;
        }
        return 0;
    }


    public function getFinalPriceAttribute()
    {
        return ($this->total_price - $this->discount_amount) + $this->tax_amount;
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
