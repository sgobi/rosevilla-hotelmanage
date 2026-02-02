<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventFrontDeskController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $query = EventBooking::where('status', 'approved')->whereNull('checked_out_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        $activeBookings = $query->orderByRaw('CASE WHEN checked_in_at IS NOT NULL THEN 0 ELSE 1 END')
            ->latest('checked_in_at')
            ->latest()
            ->get();

        // Events Starting Today
        $startingToday = EventBooking::where('status', 'approved')
            ->whereDate('event_date', $today)
            ->whereNull('checked_in_at')
            ->get();

        return view('admin.event-front-desk.index', compact('activeBookings', 'startingToday'));
    }

    public function checkIn(EventBooking $eventBooking)
    {
        if (!$eventBooking->advance_paid_at) {
            return back()->with('error', "Cannot start event. Advance payment must be recorded first.");
        }

        $eventBooking->update(['checked_in_at' => now()]);
        return back()->with('success', "Event for {$eventBooking->customer_name} has officially started.");
    }

    public function checkOut(EventBooking $eventBooking)
    {
        if (!$eventBooking->final_payment_at) {
            return back()->with('error', "Cannot complete event. Final payment must be recorded first.");
        }

        $eventBooking->update(['checked_out_at' => now()]);
        return back()->with('success', "Event for {$eventBooking->customer_name} has been marked as completed.");
    }

    public function recordAdvance(Request $request, EventBooking $eventBooking)
    {
        $validated = $request->validate([
            'advance_amount' => 'required|numeric|min:0',
            'advance_payment_method' => 'required|in:bank,cash',
            'advance_guest_name' => 'required|string|max:255',
            'advance_nic_no' => 'required|string|max:20',
            'advance_bank_name' => 'nullable|string',
            'advance_bank_branch' => 'nullable|string',
        ]);

        $eventBooking->update(array_merge($validated, [
            'advance_paid_at' => now(),
        ]));

        return back()->with('success', "Advance payment recorded for event: {$eventBooking->customer_name}.");
    }

    public function recordFinalPayment(Request $request, EventBooking $eventBooking)
    {
        $validated = $request->validate([
            'final_payment_amount' => 'required|numeric|min:0',
            'final_payment_method' => 'required|in:bank,cash',
            'final_guest_name' => 'required|string|max:255',
            'final_nic_no' => 'required|string|max:20',
            'final_bank_name' => 'nullable|string',
            'final_bank_branch' => 'nullable|string',
        ]);

        $eventBooking->update(array_merge($validated, [
            'final_payment_at' => now(),
        ]));

        return back()->with('success', "Final payment recorded. Event departure for {$eventBooking->customer_name} is now authorized.");
    }
}
