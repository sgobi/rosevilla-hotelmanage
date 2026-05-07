<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSetting;
use App\Models\Reservation;
use App\Models\EventBooking;
use App\Models\GardenBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

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
        
        // Calculate days logic (inclusive)
        $days = max(1, $reservation->check_in->diffInDays($reservation->check_out));

        return view('admin.invoices.show', compact('reservation', 'content', 'days'));
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

    public function showGarden(\App\Models\GardenBooking $gardenBooking)
    {
        // Enforce approved status for invoice access
        if ($gardenBooking->status !== 'approved') {
            abort(403, 'Invoices can only be viewed for approved garden bookings.');
        }

        $user = auth()->user();

        // Admin can always view
        if ($user->isAdmin() || $user->isAccountant()) {
            // Pass
        } elseif ($user->isStaff()) {
            // Staff restrictions
            if ($gardenBooking->invoice_print_count > 0 && $gardenBooking->invoice_reprint_status !== 'approved') {
                abort(403, 'Invoice already printed. Request Admin approval for reprint.');
            }

            // Increment count
            $gardenBooking->increment('invoice_print_count');

            // Consume approval if used
            if ($gardenBooking->invoice_reprint_status === 'approved') {
                $gardenBooking->update(['invoice_reprint_status' => 'none']);
            }
        }

        $content = ContentSetting::pluck('value', 'key');
        
        $days = max(1, $gardenBooking->check_in->diffInDays($gardenBooking->check_out));

        return view('admin.garden-bookings.invoice', compact('gardenBooking', 'content', 'days'));
    }

    public function showProforma(Reservation $reservation)
    {
        $content = ContentSetting::pluck('value', 'key');
        $days = max(1, $reservation->check_in->diffInDays($reservation->check_out));
        $isProforma = true;

        return view('admin.invoices.show', compact('reservation', 'content', 'days', 'isProforma'));
    }

    public function showEventProforma(EventBooking $event)
    {
        $content = ContentSetting::pluck('value', 'key');
        $isProforma = true;
        
        return view('admin.events.invoice', compact('event', 'content', 'isProforma'));
    }

    public function showGardenProforma(GardenBooking $gardenBooking)
    {
        $content = ContentSetting::pluck('value', 'key');
        $days = max(1, $gardenBooking->check_in->diffInDays($gardenBooking->check_out));
        $isProforma = true;

        return view('admin.garden-bookings.invoice', compact('gardenBooking', 'content', 'days', 'isProforma'));
    }

    public function sendEmail(Request $request, Reservation $reservation)
    {
        $recipientEmail = $request->input('email', $reservation->email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($reservation, 'reservation'));

        return back()->with('success', 'Invoice sent successfully to ' . $recipientEmail);
    }

    public function sendEventEmail(Request $request, EventBooking $event)
    {
        $recipientEmail = $request->input('email', $event->customer_email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($event, 'event'));

        return back()->with('success', 'Invoice sent successfully to ' . $recipientEmail);
    }

    public function sendGardenEmail(Request $request, GardenBooking $gardenBooking)
    {
        $recipientEmail = $request->input('email', $gardenBooking->email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($gardenBooking, 'garden'));

        return back()->with('success', 'Invoice sent successfully to ' . $recipientEmail);
    }

    public function sendProformaEmail(Request $request, Reservation $reservation)
    {
        $recipientEmail = $request->input('email', $reservation->email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($reservation, 'reservation', true));

        return back()->with('success', 'Proforma Invoice sent successfully to ' . $recipientEmail);
    }

    public function sendEventProformaEmail(Request $request, EventBooking $event)
    {
        $recipientEmail = $request->input('email', $event->customer_email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($event, 'event', true));

        return back()->with('success', 'Proforma Invoice sent successfully to ' . $recipientEmail);
    }

    public function sendGardenProformaEmail(Request $request, GardenBooking $gardenBooking)
    {
        $recipientEmail = $request->input('email', $gardenBooking->email);

        if (!$recipientEmail) {
            return back()->with('error', 'Please provide a recipient email address.');
        }

        Mail::to($recipientEmail)->send(new InvoiceMail($gardenBooking, 'garden', true));

        return back()->with('success', 'Proforma Invoice sent successfully to ' . $recipientEmail);
    }
}
