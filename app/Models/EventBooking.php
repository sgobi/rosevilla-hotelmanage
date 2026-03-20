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
        'address',
        'event_type',
        'event_date',
        'check_out',
        'arrival_time',
        'start_time',
        'end_time',
        'guests',
        'room_ids',
        'garden_selection',
        'additional_services',
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
        'check_out' => 'date',
        'arrival_time' => 'datetime:H:i',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'guests' => 'integer',
        'room_ids' => 'array',
        'garden_selection' => 'boolean',
        'additional_services' => 'array',
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
            // Apply current tax rate on the net price (Total - Approved Discount)
            $taxRate = \App\Models\ContentSetting::getValue('tax_percentage', 0);
            $booking->tax_percentage = $taxRate;
            
            $taxableAmount = $booking->total_price + $booking->venue_total_price + $booking->getAdditionalServicesTotalPriceAttribute();
            if ($booking->discount_status === 'approved' && $booking->discount_percentage > 0) {
                // Discount applies to the total (Base + Venue + Services)
                $discountAmount = ($taxableAmount * $booking->discount_percentage) / 100;
                $taxableAmount = $taxableAmount - $discountAmount;
            }

            if ($taxableAmount > 0) {
                $booking->tax_amount = ($taxableAmount * $taxRate) / 100;
            } else {
                $booking->tax_amount = 0;
            }
        });
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'discount_approved_by');
    }

    public function getDurationAttribute()
    {
        if (!$this->event_date || !$this->check_out) return 1;
        $start = \Carbon\Carbon::parse($this->event_date);
        $end = \Carbon\Carbon::parse($this->check_out);
        $diff = $start->diffInDays($end);
        return $diff > 0 ? (int)$diff : 1;
    }

    public function getVenueTotalPriceAttribute()
    {
        $duration = $this->duration;
        $total = 0;

        // Garden Price
        if ($this->garden_selection) {
            $total += $this->garden_price_per_day * $duration;
        }

        // Rooms Price
        if ($this->room_ids && is_array($this->room_ids)) {
            $roomsPrice = $this->rooms_list->sum('price_per_night');
            $total += (float)$roomsPrice * $duration;
        }

        return $total;
    }

    public function getGardenPricePerDayAttribute()
    {
        return (float) \App\Models\ContentSetting::getValue('garden_price_per_day', 0);
    }

    public function getRoomsListAttribute()
    {
        if (!$this->room_ids || !is_array($this->room_ids)) return collect();
        return \App\Models\Room::whereIn('id', $this->room_ids)->get();
    }

    public function getDiscountAmountAttribute()
    {
        $taxableBase = $this->total_price + $this->venue_total_price + $this->additional_services_total_price;
        if ($this->discount_status === 'approved' && $this->discount_percentage > 0 && $taxableBase > 0) {
            return ($taxableBase * $this->discount_percentage) / 100;
        }
        return 0;
    }

    public function getAdditionalServicesTotalPriceAttribute()
    {
        if (!is_array($this->additional_services)) return 0;
        return array_reduce($this->additional_services, function($carry, $item) {
            return $carry + (float)($item['price'] ?? 0);
        }, 0);
    }

    public function getFinalPriceAttribute()
    {
        return ($this->total_price + $this->venue_total_price + $this->additional_services_total_price - $this->discount_amount) + $this->tax_amount;
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
