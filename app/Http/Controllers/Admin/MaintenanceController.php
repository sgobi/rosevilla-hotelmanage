<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Wipe all transactional data from the system.
     * Restricted to Administrators only.
     */
    public function wipeAllData(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Authentication failed. Data wipe aborted.');
        }

        try {
            DB::transaction(function () {
                // Delete all reservations and event bookings
                Reservation::query()->delete();
                EventBooking::query()->delete();
                
                // Optional: Clear system notifications related to these bookings
                DB::table('notifications')->delete();
            });

            return back()->with('success', 'System Cleared: All reservation and event records have been permanently removed.');
        } catch (\Exception $e) {
            return back()->with('error', 'System Error: Failed to wipe data. ' . $e->getMessage());
        }
    }
}
