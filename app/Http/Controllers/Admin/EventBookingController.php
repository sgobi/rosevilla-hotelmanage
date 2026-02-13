<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Models\User;
use App\Notifications\NewEventBookingRequest;
use App\Notifications\BookingStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EventBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = EventBooking::latest()->get();
        return view('admin.events.index', compact('bookings'));
    }

    /**
     * Display the calendar view.
     */
    public function calendar()
    {
        return view('admin.events.calendar');
    }

    /**
     * Return events as JSON for FullCalendar.
     */
    public function apiEvents()
    {
        $events = EventBooking::where('status', '!=', 'cancelled')->get()->map(function ($booking) {
            return [
                'title' => $booking->event_type . ' - ' . $booking->customer_name,
                'start' => $booking->event_date->format('Y-m-d') . 'T' . $booking->start_time->format('H:i:s'),
                'end' => $booking->event_date->format('Y-m-d') . 'T' . $booking->end_time->format('H:i:s'),
                'backgroundColor' => $this->getStatusColor($booking->status),
                'url' => route('admin.events.edit', $booking->id), // Link to edit
            ];
        });

        return response()->json($events);
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'approved' => '#10b981', // green
            'pending' => '#f59e0b',  // amber
            'rejected' => '#ef4444', // red
            'cancelled' => '#6b7280', // gray
            default => '#3b82f6',    // blue
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'guests' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'total_price' => 'nullable|numeric|min:0',
            'force_conflict' => 'nullable|boolean'
        ]);

        // Check for conflicts
        $conflict = EventBooking::where('event_date', $validated['event_date'])
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
            })
            ->first();

        if ($conflict && !$request->has('force_conflict')) {
            return back()->withInput()->withErrors([
                'conflict' => 'This time slot overlaps with an existing booking (' . $conflict->event_type . ').',
                'conflict_details' => $conflict
            ]);
        }

        if ($request->has('force_conflict') && $conflict) {
            $validated['conflict_status'] = 'requested';
            $validated['status'] = 'pending';
        }

        unset($validated['force_conflict']);
        


        $booking = EventBooking::create($validated);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        
        if (isset($booking->conflict_status) && $booking->conflict_status === 'requested') {
            Notification::send($admins, new NewEventBookingRequest($booking, 'conflict_request'));
            $msg = 'Event booking request with CONFLICT created. Admin approval required.';
        } else {
            Notification::send($admins, new NewEventBookingRequest($booking));
            $msg = 'Event booking created successfully. Admin notified for approval.';
        }

        // Send WhatsApp to Customer
        /*
        try {
            $booking->notify(new \App\Notifications\WhatsAppBookingConfirmed($booking, 'event'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
        */

        return redirect()->route('admin.events.index')->with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventBooking $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventBooking $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventBooking $event)
    {
        // 1. Handle Status Update (Admin and Staff)
        if ($request->has('status')) {
            if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
                abort(403, 'Only administrators and staff can update booking status.');
            }
            $request->validate(['status' => 'required|in:pending,approved,rejected,cancelled']);
            
            $oldStatus = $event->status;
            $newStatus = $request->status;
            
            $event->update(['status' => $newStatus]);
            
            // Send WhatsApp notification to customer if status changed to approved, rejected, or cancelled
            /*
            if ($oldStatus !== $newStatus && in_array($newStatus, ['approved', 'rejected', 'cancelled'])) {
                try {
                    $event->notify(new \App\Notifications\WhatsAppEventStatusUpdate($event, $newStatus));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
                }
            }
            */
            
            return back()->with('success', 'Booking status updated to ' . $newStatus . '.');
        }

        // 2. Handle Discount Suggestion (Staff/Admin)
        if ($request->has('discount_percentage')) {
            $data = $request->validate([
                'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);

            if (auth()->user()->isAdmin()) {
                // Admin applies immediately
                $event->update([
                    'discount_percentage' => $data['discount_percentage'],
                    'discount_status' => 'approved',
                    'discount_approved_by' => auth()->id(),
                ]);
                return back()->with('success', 'Discount of ' . $data['discount_percentage'] . '% applied.');
            } else {
                // Staff suggests
                $event->update([
                    'discount_percentage' => $data['discount_percentage'],
                    'discount_status' => 'pending',
                ]);

                // Notify Admins
                $admins = User::where('role', 'admin')->get();
                // Using generic notification, ideally create specific classes
                Notification::send($admins, new NewEventBookingRequest($event, 'discount_suggestion')); 

                return back()->with('success', 'Discount suggestion of ' . $data['discount_percentage'] . '% sent for approval.');
            }
        }

        // 3. Handle Discount Approval (Admin Only)
        if ($request->has('discount_action') && auth()->user()->isAdmin()) {
            $action = $request->discount_action;
            $staff = User::whereIn('role', ['staff', 'accountant'])->get();

            if ($action === 'approve') {
                $event->update([
                    'discount_status' => 'approved',
                    'discount_approved_by' => auth()->id(),
                ]);
                Notification::send($staff, new BookingStatusUpdated($event, 'discount', 'approved'));
                return back()->with('success', 'Discount approved.');
            } elseif ($action === 'reject') {
                $event->update([
                    'discount_status' => 'rejected',
                ]);
                Notification::send($staff, new BookingStatusUpdated($event, 'discount', 'rejected'));
                return back()->with('success', 'Discount rejected.');
            }
        }

        // 4. Handle Reprint Request (Staff/Admin)
        if ($request->has('reprint_action')) {
            $action = $request->reprint_action;
            if ($action === 'request') {
                $event->update(['invoice_reprint_status' => 'requested']);
                
                // Notify Admins
                $admins = User::where('role', 'admin')->get();
                Notification::send($admins, new NewEventBookingRequest($event, 'reprint_request'));

                return back()->with('success', 'Reprint requested.');
            }
            if (auth()->user()->isAdmin()) {
                $staff = User::whereIn('role', ['staff', 'accountant'])->get();
                
                if ($action === 'approve') {
                    $event->update(['invoice_reprint_status' => 'approved']);
                    Notification::send($staff, new BookingStatusUpdated($event, 'reprint', 'approved'));
                    return back()->with('success', 'Reprint approved.');
                } elseif ($action === 'reject') {
                    $event->update(['invoice_reprint_status' => 'rejected']);
                    Notification::send($staff, new BookingStatusUpdated($event, 'reprint', 'rejected'));
                    return back()->with('success', 'Reprint rejected.');
                }
            }
        }

        // 5. Handle Conflict Approval (Admin Only)
        if ($request->has('conflict_action') && auth()->user()->isAdmin()) {
            $action = $request->conflict_action;
            $staff = User::whereIn('role', ['staff', 'accountant'])->get();

            if ($action === 'approve') {
                $event->update([
                    'conflict_status' => 'approved',
                    'status' => 'approved', // Auto-approve booking if conflict is approved? Or keep pending? Let's approve for now as it's an "Override"
                ]);
                Notification::send($staff, new BookingStatusUpdated($event, 'conflict', 'approved'));
                
                // Send WhatsApp notification to customer
                /*
                try {
                    $event->notify(new \App\Notifications\WhatsAppEventStatusUpdate($event, 'approved'));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
                }
                */
                
                return back()->with('success', 'Conflict override APPROVED. Booking is now active.');
            } elseif ($action === 'reject') {
                $event->update([
                    'conflict_status' => 'rejected',
                    'status' => 'rejected',
                ]);
                Notification::send($staff, new BookingStatusUpdated($event, 'conflict', 'rejected'));
                
                // Send WhatsApp notification to customer
                /*
                try {
                    $event->notify(new \App\Notifications\WhatsAppEventStatusUpdate($event, 'rejected'));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
                }
                */
                
                return back()->with('success', 'Conflict override REJECTED. Booking has been rejected.');
            }
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'event_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'guests' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        // Check for conflicts excluding this event
        $conflict = EventBooking::where('event_date', $validated['event_date'])
            ->where('id', '!=', $event->id)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($validated) {
                 $query->where('start_time', '<', $validated['end_time'])
                       ->where('end_time', '>', $validated['start_time']);
            })
            ->first();

        if ($conflict) {
             return back()->withInput()->withErrors([
                'conflict' => 'This time slot overlaps with an existing booking (' . $conflict->event_type . ').',
            ]);
        }



        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventBooking $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event booking deleted successfully.');
    }
}
