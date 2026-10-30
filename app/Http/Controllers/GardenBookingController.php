<?php

namespace App\Http\Controllers;

use App\Models\GardenBooking;
use App\Notifications\NewGardenBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class GardenBookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after_or_equal:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
            'special_requirements' => ['nullable', 'string'],
            'additional_notes' => ['nullable', 'string'],
        ]);

        $requestedCheckIn = $data['check_in'];
        $requestedCheckOut = $data['check_out'];

        // Check for overlapping bookings
        $overlappingBookings = GardenBooking::whereIn('status', ['approved', 'checked_in', 'checked_out'])
            ->where(function ($query) use ($requestedCheckIn, $requestedCheckOut) {
                $query->whereDate('check_in', '<=', $requestedCheckOut)
                      ->whereDate('check_out', '>=', $requestedCheckIn);
            })->exists();

        if ($overlappingBookings) {
            return back()
                ->withInput()
                ->with('error', 'Sorry, the garden is already booked for the chosen dates. Please adjust your check-in/check-out dates.');
        }

        $data['status'] = 'pending';
        
        $booking = GardenBooking::create($data);

        // Notify Admins, Staff, and Accountants
        $users = User::whereIn('role', ['admin', 'staff', 'accountant'])->get();
        Notification::send($users, new NewGardenBookingRequest($booking));

        return back()->with('success', 'Thank you. Your garden booking request has been received. Our team will contact you shortly.');
    }
}
