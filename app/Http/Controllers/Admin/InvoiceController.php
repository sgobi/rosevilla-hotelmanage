<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSetting;
use App\Models\Reservation;
use App\Models\EventBooking;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Reservation $reservation)
    {
        // Enforce approved status for invoice access
        if ($reservation->status !== 'approved') {
            abort(403, 'Invoices can only be viewed for approved reservations.');
        }

        $user = auth()->user();

        // Admin can always view
        if ($user->isAdmin() || $user->isAccountant()) { // Assuming accountant also has unrestricted access or read-only
            // Pass
        } elseif ($user->isStaff()) {
            // Staff restrictions
            if ($reservation->invoice_print_count > 0 && $reservation->invoice_reprint_status !== 'approved') {
                abort(403, 'Invoice already printed. Request Admin approval for reprint.');
            }

            // Increment count
            $reservation->increment('invoice_print_count');

            // Consume approval if used
            if ($reservation->invoice_reprint_status === 'approved') {
                $reservation->update(['invoice_reprint_status' => 'none']);
            }
        }

        $content = ContentSetting::pluck('value', 'key');
        
        // Calculate nights logic for display if needed
        $nights = $reservation->check_in->diffInDays($reservation->check_out);
        $nights = $nights > 0 ? $nights : 1;

        return view('admin.invoices.show', compact('reservation', 'content', 'nights'));
    }

    public function showEvent(EventBooking $event)
    {
        // Enforce approved status for invoice access
        if ($event->status !== 'approved') {
            abort(403, 'Invoices can only be viewed for approved event bookings.');
        }

        $user = auth()->user();

        // Admin can always view
        if ($user->isAdmin() || $user->isAccountant()) {
            // Pass
        } elseif ($user->isStaff()) {
            // Staff restrictions
            if ($event->invoice_print_count > 0 && $event->invoice_reprint_status !== 'approved') {
                abort(403, 'Invoice already printed. Request Admin approval for reprint.');
            }

            // Increment count
            $event->increment('invoice_print_count');

            // Consume approval if used
            if ($event->invoice_reprint_status === 'approved') {
                $event->update(['invoice_reprint_status' => 'none']);
            }
        }

        $content = ContentSetting::pluck('value', 'key');
        
        return view('admin.events.invoice', compact('event', 'content'));
    }
}
