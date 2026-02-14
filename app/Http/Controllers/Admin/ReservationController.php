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
    public function index(Request $request)
    {
        $query = Reservation::with('room');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        // Ensure valid sort column
        $allowedSorts = ['guest_name', 'check_in', 'check_out', 'guests', 'final_price', 'status', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            // Special handling for calculated final_price if needed, but since it's a dynamic attribute 
            // we will sort by total_price as a proxy or stick to base columns.
            if ($sort === 'final_price') $sort = 'total_price'; 
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $reservations = $query->get();

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
                $newStatus = $reservation->status_update_requested;
                $reservation->update([
                    'status' => $newStatus,
                    'status_update_requested' => null
                ]);
                
                // Send WhatsApp notification to customer
                /*
                try {
                    $reservation->notify(new \App\Notifications\WhatsAppReservationStatusUpdate($reservation, $newStatus));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
                }
                */
                
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
                return back()->with('error', 'You cannot directly update an approved reservation. Please request a status change.');
            }

            $rules = [
                'status' => ['required', 'in:pending,approved,cancelled'],
            ];
            
            if ($request->status === 'cancelled') {
                $rules['cancellation_reason'] = ['nullable', 'string'];
            }

            $data = $request->validate($rules);
            
            $oldStatus = $reservation->status;
            $newStatus = $data['status'];
            
            $updateData = ['status' => $newStatus];
            if ($newStatus === 'cancelled' && isset($data['cancellation_reason'])) {
                $updateData['cancellation_reason'] = $data['cancellation_reason'];
            }
            
            $reservation->update($updateData);
            
            // Send WhatsApp notification to customer if status changed to approved or cancelled
            /*
            if ($oldStatus !== $newStatus && in_array($newStatus, ['approved', 'cancelled'])) {
                try {
                    $reservation->notify(new \App\Notifications\WhatsAppReservationStatusUpdate($reservation, $newStatus));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
                }
            }
            */
            
            return back()->with('success', 'Status updated to ' . ucfirst($newStatus) . '.');
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
        
        // 5. Handle Guest Notes Update
        if ($request->hasAny(['special_requirements', 'additional_notes'])) {
            $data = $request->validate([
                'special_requirements' => ['nullable', 'string'],
                'additional_notes' => ['nullable', 'string'],
            ]);

            $messageParts = [];
            if ($data['special_requirements']) $messageParts[] = "Special Requirements: " . $data['special_requirements'];
            if ($data['additional_notes']) $messageParts[] = "Additional Notes: " . $data['additional_notes'];
            $data['message'] = implode("\n\n", $messageParts);

            $reservation->update($data);
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
