<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GardenBooking;
use Illuminate\Http\Request;

class GardenBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = GardenBooking::query();

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
        
        $query->orderBy($sort, $direction);

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.garden-bookings.index', compact('bookings'));
    }

    public function show(GardenBooking $gardenBooking)
    {
        return view('admin.garden-bookings.show', compact('gardenBooking'));
    }

    public function edit(GardenBooking $gardenBooking)
    {
        return view('admin.garden-bookings.edit', compact('gardenBooking'));
    }

    public function update(Request $request, GardenBooking $gardenBooking)
    {
        // Handle Status Update (Admin and Staff)
        if ($request->has('status')) {
            if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
                abort(403, 'Only administrators and staff can update booking status.');
            }
            $request->validate(['status' => 'required|in:pending,approved,checked_in,checked_out,rejected,cancelled']);
            
            $oldStatus = $gardenBooking->status;
            $newStatus = $request->status;
            
            $updateData = ['status' => $newStatus];
            
            if ($newStatus === 'cancelled' && $request->has('cancellation_reason')) {
                $updateData['cancellation_reason'] = $request->input('cancellation_reason');
            }
            if ($newStatus === 'checked_in') {
                $updateData['checked_in_at'] = now();
            }
            if ($newStatus === 'checked_out') {
                $updateData['checked_out_at'] = now();
            }
            if ($request->has('advance_amount')) {
                $updateData['advance_amount'] = $request->input('advance_amount');
                $updateData['advance_paid_at'] = $updateData['advance_paid_at'] ?? now();
            }
            
            $gardenBooking->update($updateData);
            
            return back()->with('success', 'Booking status updated to ' . $newStatus . '.');
        }

        // Handle Discount (Staff suggests, Admin approves)
        if ($request->has('discount_percentage')) {
            $data = $request->validate([
                'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            ]);

            if (auth()->user()->isAdmin()) {
                $gardenBooking->update([
                    'discount_percentage' => $data['discount_percentage'],
                    'discount_status' => 'approved',
                    'discount_approved_by' => auth()->id(),
                ]);
                return back()->with('success', 'Discount of ' . $data['discount_percentage'] . '% applied.');
            } else {
                $gardenBooking->update([
                    'discount_percentage' => $data['discount_percentage'],
                    'discount_status' => 'pending',
                ]);
                return back()->with('success', 'Discount suggestion of ' . $data['discount_percentage'] . '% sent for approval.');
            }
        }

        if ($request->has('discount_action') && auth()->user()->isAdmin()) {
            $action = $request->discount_action;
            if ($action === 'approve') {
                $gardenBooking->update([
                    'discount_status' => 'approved',
                    'discount_approved_by' => auth()->id(),
                ]);
                return back()->with('success', 'Discount approved.');
            } elseif ($action === 'reject') {
                $gardenBooking->update([
                    'discount_status' => 'rejected',
                ]);
                return back()->with('success', 'Discount rejected.');
            }
        }

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requirements' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $conflict = GardenBooking::whereNotIn('status', ['cancelled', 'rejected', 'completed'])
            ->where('id', '!=', $gardenBooking->id)
            ->where(function ($query) use ($validated) {
                 $query->whereDate('check_in', '<', $validated['check_out'])
                       ->whereDate('check_out', '>', $validated['check_in']);
            })
            ->first();

        if ($conflict) {
             return back()->withInput()->withErrors([
                 'conflict' => 'This date overlaps with an existing garden booking.',
            ]);
        }

        $gardenBooking->update($validated);

        return redirect()->route('admin.garden-bookings.index')->with('success', 'Garden booking updated successfully.');
    }

    public function destroy(Request $request, GardenBooking $gardenBooking)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Deletion failed.']);
        }

        $gardenBooking->delete();
        return redirect()->route('admin.garden-bookings.index')->with('success', 'Garden booking deleted successfully.');
    }
}
