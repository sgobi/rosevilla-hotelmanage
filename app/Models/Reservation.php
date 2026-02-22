<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $fillable = [
        'room_id',
        'guest_name',
        'email',
        'address',
        'phone',
        'check_in',
        'check_out',
        'guests',
        'arrival_time',
        'message',
        'special_requirements',
        'additional_notes',
        'checked_in_at',
        'checked_out_at',
        'status',
        'cancellation_reason',
        'total_price',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_status',
        'discount_approved_by',
        'invoice_print_count',
        'invoice_reprint_status',
        'status_update_requested',
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
        'check_in' => 'date',
        'check_out' => 'date',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'guests' => 'integer',
        'total_price' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'advance_paid_at' => 'datetime',
        'final_payment_amount' => 'decimal:2',
        'final_payment_at' => 'datetime',
    ];

    public function getFinalPriceAttribute()
    {
        $subtotal = $this->total_price;
        if ($this->discount_status === 'approved' && $this->discount_percentage > 0) {
            $subtotal = $this->total_price * (1 - ($this->discount_percentage / 100));
        }
        return $subtotal + $this->tax_amount;
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->discount_status === 'approved' && $this->discount_percentage > 0) {
            return ($this->total_price * $this->discount_percentage) / 100;
        }
        return 0;
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'discount_approved_by');
    }

    protected static function booted()
    {
        static::creating(function ($reservation) {
            if ($reservation->room_id && $reservation->check_in && $reservation->check_out) {
                // Calculation: inclusive of both check-in and check-out dates
                $days = $reservation->check_in->diffInDays($reservation->check_out) + 1;
                
                $room = Room::find($reservation->room_id);
                if ($room) {
                    $reservation->total_price = $room->price_per_night * $days;
                    
                    // Apply current tax rate
                    $taxRate = \App\Models\ContentSetting::getValue('tax_percentage', 0);
                    $reservation->tax_percentage = $taxRate;
                    $reservation->tax_amount = ($reservation->total_price * $taxRate) / 100;
                }
            }
        });
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Route notifications for WhatsApp channel.
     */
    public function routeNotificationForWhatsApp()
    {
        return $this->phone;
    }
}
