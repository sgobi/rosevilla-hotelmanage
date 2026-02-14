<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EventBooking extends Model
{
    use Notifiable;

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
        'cancellation_reason',
        'total_price',
        'tax_percentage',
        'tax_amount',
        'invoice_print_count',
        'invoice_reprint_status',
        'discount_percentage',
        'discount_status',
        'discount_approved_by',
        'conflict_status',
        'conflict_note',
        'checked_in_at',
        'checked_out_at',
        'advance_amount',
        'advance_payment_method',
        'advance_paid_at',
        'advance_guest_name',
        'advance_nic_no',
        'advance_bank_name',
        'advance_bank_branch',
        'final_payment_amount',
        'final_payment_method',
        'final_payment_at',
        'final_guest_name',
        'final_nic_no',
        'final_bank_name',
        'final_bank_branch',
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
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'advance_amount' => 'decimal:2',
        'advance_paid_at' => 'datetime',
        'final_payment_amount' => 'decimal:2',
        'final_payment_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($booking) {
            // Apply current tax rate
            // Note: We use the current system tax rate whenever the booking is saved.
            // If total_price is set, calculate tax.
            $taxRate = \App\Models\ContentSetting::getValue('tax_percentage', 0);
            $booking->tax_percentage = $taxRate;
            
            if ($booking->total_price > 0) {
                $booking->tax_amount = ($booking->total_price * $taxRate) / 100;
            } else {
                $booking->tax_amount = 0;
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

    /**
     * Route notifications for WhatsApp channel.
     */
    public function routeNotificationForWhatsApp()
    {
        return $this->customer_phone;
    }
}
