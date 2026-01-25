<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('room')->latest()->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.reservations.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.reservations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // 1. Handle Status Update
        // 0. Handle Status Update Request (Staff Request)
        if ($request->has('request_status_change')) {
            $data = $request->validate([
                'request_status_change' => ['required', 'in:pending,approved,cancelled'],
            ]);
            $reservation->update(['status_update_requested' => $data['request_status_change']]);

            // Notify Admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\DiscountSuggested([
                'reservation_id' => $reservation->id,
                'discount_percentage' => 0, 
                'guest_name' => $reservation->guest_name,
                'message' => 'Status change requested for ' . $reservation->guest_name . ' to ' . ucfirst($data['request_status_change']),
                'type' => 'status_change_request',
                'subtype' => 'status'
            ]));
            
            return back()->with('success', 'Status change to ' . ucfirst($data['request_status_change']) . ' requested.');
        }

        // 0.1 Handle Status Update Approval/Rejection (Admin Response)
        if ($request->has('status_change_action') && auth()->user()->isAdmin()) {
            $action = $request->status_change_action;
            if ($action === 'approve') {
                $reservation->update([
                    'status' => $reservation->status_update_requested,
                    'status_update_requested' => null
                ]);
                return back()->with('success', 'Status change request approved.');
            } elseif ($action === 'reject') {
                $reservation->update(['status_update_requested' => null]);
                return back()->with('success', 'Status change request rejected.');
            }
        }

        // 1. Handle Status Update
        if ($request->has('status')) {
            // Prevent Staff from updating logic if already approved
            if (auth()->user()->isStaff() && $reservation->status === 'approved') {
                // If it is staff trying to update an approved reservation, we should direct them to request instead, or just fail validation.
                // However, the UI should prevent this. If they bypassed UI, return error.
                return back()->with('error', 'You cannot directly update an approved reservation. Please request a status change.');
            }

            $data = $request->validate([
                'status' => ['required', 'in:pending,approved,cancelled'],
            ]);
            $reservation->update($data);
        }

        // 2. Handle Discount Suggestion (Staff/Admin)
        if ($request->has('discount_percentage')) {
            $data = $request->validate([
                'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);
            
            // If it's a new suggestion or update, set status to pending approval
            $reservation->update([
                'discount_percentage' => $data['discount_percentage'],
                'discount_status' => 'pending', 
                'discount_approved_by' => null,
            ]);

            // Notify all Admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\DiscountSuggested([
                'reservation_id' => $reservation->id,
                'discount_percentage' => $data['discount_percentage'],
                'guest_name' => $reservation->guest_name,
            ]));
            
            return back()->with('success', 'Discount suggested. Waiting for Admin approval.');
        }

        // 3. Handle Discount Approval (Admin Only)
        if ($request->has('discount_action') && auth()->user()->isAdmin()) {
            if ($request->discount_action === 'approve') {
                $reservation->update([
                    'discount_status' => 'approved',
                    'discount_approved_by' => auth()->id(),
                ]);

                // Notify all Staff
                $staff = \App\Models\User::where('role', 'staff')->get();
                \Illuminate\Support\Facades\Notification::send($staff, new \App\Notifications\DiscountDecision([
                    'reservation_id' => $reservation->id,
                    'status' => 'approved',
                    'guest_name' => $reservation->guest_name,
                ]));

                return back()->with('success', 'Discount approved.');
            } elseif ($request->discount_action === 'reject') {
                $reservation->update([
                    'discount_status' => 'rejected',
                    'discount_approved_by' => auth()->id(),
                ]);

                // Notify all Staff
                $staff = \App\Models\User::where('role', 'staff')->get();
                \Illuminate\Support\Facades\Notification::send($staff, new \App\Notifications\DiscountDecision([
                    'reservation_id' => $reservation->id,
                    'status' => 'rejected',
                    'guest_name' => $reservation->guest_name,
                ]));

                return back()->with('success', 'Discount rejected.');
            }
        }

        // 4. Handle Invoice Reprint Request (Staff/Admin)
        if ($request->has('reprint_action')) {
            $action = $request->reprint_action;

            if ($action === 'request') {
                $reservation->update(['invoice_reprint_status' => 'requested']);
                
                // Notify Admins
                $admins = \App\Models\User::where('role', 'admin')->get();
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\DiscountSuggested([
                    'reservation_id' => $reservation->id,
                    'discount_percentage' => 0, // Reuse
                    'guest_name' => $reservation->guest_name,
                    'message' => 'Reprint requested for ' . $reservation->guest_name,
                    'type' => 'reprint_request'
                ])); // Using existing notification class for simplicity, ideally create new
                
                return back()->with('success', 'Reprint requested.');
            }

            if (auth()->user()->isAdmin()) {
                if ($action === 'approve') {
                    $reservation->update(['invoice_reprint_status' => 'approved']);
                    return back()->with('success', 'Reprint approved.');
                } elseif ($action === 'reject') {
                    $reservation->update(['invoice_reprint_status' => 'rejected']);
                    return back()->with('success', 'Reprint rejected.');
                }
            }
        }

        return back()->with('success', 'Reservation updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Reservation $reservation)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        $reservation->delete();

        return back()->with('success', 'Reservation deleted.');
    }
}
