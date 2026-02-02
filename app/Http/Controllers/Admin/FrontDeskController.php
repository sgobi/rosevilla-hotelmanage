<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontDeskController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $query = Reservation::with('room')->where('status', 'approved')->whereNull('checked_out_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $activeReservations = $query->orderByRaw('CASE WHEN checked_in_at IS NOT NULL THEN 0 ELSE 1 END')
            ->latest('checked_in_at')
            ->latest()
            ->get();

        // Arriving Today
        $arrivingToday = Reservation::with('room')
            ->where('status', 'approved')
            ->whereDate('check_in', $today)
            ->whereNull('checked_in_at')
            ->get();

        // Departures Today
        $departingToday = Reservation::with('room')
            ->where('status', 'approved')
            ->whereDate('check_out', $today)
            ->whereNotNull('checked_in_at')
            ->whereNull('checked_out_at')
            ->get();

        return view('admin.front-desk.index', compact('activeReservations', 'arrivingToday', 'departingToday'));
    }

    public function checkIn(Reservation $reservation)
    {
        if (!$reservation->advance_paid_at) {
            return back()->with('error', "Cannot check in guest. Advance payment must be recorded first.");
        }

        $reservation->update(['checked_in_at' => now()]);
        return back()->with('success', "Guest {$reservation->guest_name} has been checked in.");
    }

    public function checkOut(Reservation $reservation)
    {
        if (!$reservation->final_payment_at) {
            return back()->with('error', "Cannot check out guest. Final payment must be recorded first.");
        }

        $reservation->update(['checked_out_at' => now()]);
        return back()->with('success', "Guest {$reservation->guest_name} has been checked out.");
    }

    public function recordAdvance(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'advance_amount' => 'required|numeric|min:0',
            'advance_payment_method' => 'required|in:bank,cash',
            'advance_guest_name' => 'required|string|max:255',
            'advance_nic_no' => 'required|string|max:20',
            'advance_bank_name' => 'nullable|string',
            'advance_bank_branch' => 'nullable|string',
        ]);

        $reservation->update(array_merge($validated, [
            'advance_paid_at' => now(),
        ]));

        return back()->with('success', "Advance payment recorded for {$reservation->guest_name}.");
    }

    public function recordFinalPayment(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'final_payment_amount' => 'required|numeric|min:0',
            'final_payment_method' => 'required|in:bank,cash',
            'final_guest_name' => 'required|string|max:255',
            'final_nic_no' => 'required|string|max:20',
            'final_bank_name' => 'nullable|string',
            'final_bank_branch' => 'nullable|string',
        ]);

        $reservation->update(array_merge($validated, [
            'final_payment_at' => now(),
        ]));

        return back()->with('success', "Final payment recorded for {$reservation->guest_name}. Check-out is now authorized.");
    }
}
