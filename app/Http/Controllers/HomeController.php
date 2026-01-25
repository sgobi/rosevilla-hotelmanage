<?php

namespace App\Http\Controllers;

use App\Models\ContentSetting;
use App\Models\GalleryImage;
use App\Models\Landmark;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;

use App\Models\HomeEvent;

class HomeController extends Controller
{
    public function index()
    {
        $content = ContentSetting::query()->pluck('value', 'key');

        $rooms = Room::query()
            ->where('is_active', true)
            ->orderBy('price_per_night')
            ->get();

        $gallery = GalleryImage::query()
            ->orderByDesc('is_featured')
            ->latest()
            ->take(9)
            ->get();

        $reviews = Review::query()
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        $landmarks = Landmark::query()->orderBy('title')->get();

        $homeEvents = HomeEvent::query()->orderBy('sort_order')->get();

        return view('home', [
            'content' => $content,
            'rooms' => $rooms,
            'gallery' => $gallery,
            'reviews' => $reviews,
            'landmarks' => $landmarks,
            'homeEvents' => $homeEvents,
        ]);
    }

    public function storeReservation(Request $request)
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:8'],
            'arrival_time' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string'],
        ]);

        $data['status'] = 'pending';

        $reservation = Reservation::create($data);

        // Notify Admins, Staff, and Accountants
        $users = \App\Models\User::whereIn('role', ['admin', 'staff', 'accountant'])->get();
        \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\NewReservationRequest($reservation));

        // Send WhatsApp to Customer
        try {
            $reservation->notify(new \App\Notifications\WhatsAppBookingConfirmed($reservation, 'room'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you. Your reservation request has been received. Our team will confirm shortly.');
    }
}
