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

    public function calendar()
    {
        return view('admin.front-desk.calendar');
    }

    public function apiEvents()
    {
        $reservations = Reservation::with('room')
            ->where('status', '!=', 'cancelled')
            ->get()
            ->map(function ($reservation) {
                $statusColor = '#3b82f6'; // Default blue
                
                if ($reservation->checked_out_at) {
                    $statusColor = '#6b7280'; // gray (spent)
                } elseif ($reservation->checked_in_at) {
                    $statusColor = '#10b981'; // green (in-house)
                } elseif ($reservation->status === 'approved') {
                    $statusColor = '#f59e0b'; // amber (confirmed)
                } elseif ($reservation->status === 'pending') {
                    $statusColor = '#ef4444'; // red (needs attention)
                }

                $rooms = $reservation->rooms();
                $roomText = $rooms->pluck('title')->implode(', ') ?: 'Room';
                $nights = $reservation->check_in->diffInDays($reservation->check_out);
                
                return [
                    'id' => $reservation->id,
                    'title' => "({$nights}N) {$roomText} - {$reservation->guest_name}",
                    'start' => $reservation->check_in->format('Y-m-d'),
                    'end' => $reservation->check_out->addDay()->format('Y-m-d'), 
                    'backgroundColor' => $statusColor,
                    'borderColor' => $statusColor,
                    'textColor' => '#ffffff',
                    'url' => route('admin.front-desk.index', ['search' => $reservation->guest_name]),
                    'allDay' => true,
                    'extendedProps' => [
                        'guest' => $reservation->guest_name,
                        'rooms' => $roomText,
                        'nights' => $nights,
                        'status' => $reservation->status,
                    ]
                ];
            });

        return response()->json($reservations);
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

    public function resetData(Request $request, Reservation $reservation)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isAccountant()) {
            abort(403);
        }

        $request->validate([
            'password' => 'required',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Operational reset failed.']);
        }

        $reservation->update([
            'checked_in_at' => null,
            'checked_out_at' => null,
            'advance_amount' => 0,
            'advance_payment_method' => null,
            'advance_guest_name' => null,
            'advance_nic_no' => null,
            'advance_bank_name' => null,
            'advance_bank_branch' => null,
            'advance_paid_at' => null,
            'final_payment_amount' => 0,
            'final_payment_method' => null,
            'final_guest_name' => null,
            'final_nic_no' => null,
            'final_bank_name' => null,
            'final_bank_branch' => null,
            'final_payment_at' => null,
            'invoice_print_count' => 0,
            'invoice_reprint_status' => null,
        ]);

        return back()->with('success', "Operational data reset for {$reservation->guest_name}.");
    }
}
