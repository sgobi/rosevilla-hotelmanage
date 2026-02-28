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

        $activeReservations = Reservation::whereNotIn('status', ['cancelled', 'rejected', 'completed'])
            ->whereDate('check_out', '>=', now()->toDateString())
            ->get(['room_ids', 'room_id', 'check_in', 'check_out']);

        $bookedDatesByRoom = [];
        foreach ($activeReservations as $res) {
            $rIds = !empty($res->room_ids) ? $res->room_ids : ($res->room_id ? [$res->room_id] : []);
            foreach ($rIds as $rId) {
                if (!isset($bookedDatesByRoom[$rId])) {
                    $bookedDatesByRoom[$rId] = [];
                }
                $bookedDatesByRoom[$rId][] = [
                    'check_in' => $res->check_in->format('Y-m-d'),
                    'check_out' => $res->check_out->format('Y-m-d')
                ];
            }
        }

        return view('home', [
            'content' => $content,
            'rooms' => $rooms,
            'gallery' => $gallery,
            'reviews' => $reviews,
            'landmarks' => $landmarks,
            'homeEvents' => $homeEvents,
            'bookedDatesByRoom' => json_encode($bookedDatesByRoom),
        ]);
    }

    public function storeReservation(Request $request)
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'room_ids' => ['nullable', 'array'],
            'room_ids.*' => ['exists:rooms,id'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:10'],
            'special_requirements' => ['nullable', 'string'],
            'additional_notes' => ['nullable', 'string'],
        ]);

        $requestedCheckIn = $data['check_in'];
        $requestedCheckOut = $data['check_out'];
        $roomIdsToCheck = isset($data['room_ids']) ? $data['room_ids'] : (isset($data['room_id']) ? [$data['room_id']] : []);

        if (!empty($roomIdsToCheck)) {
            $overlappingReservations = \App\Models\Reservation::whereNotIn('status', ['cancelled', 'rejected', 'completed'])
                ->where(function ($query) use ($requestedCheckIn, $requestedCheckOut) {
                    $query->whereDate('check_in', '<', $requestedCheckOut)
                          ->whereDate('check_out', '>', $requestedCheckIn);
                })->get();

            $isAvailable = true;
            foreach ($overlappingReservations as $res) {
                $resRoomIds = !empty($res->room_ids) ? $res->room_ids : ($res->room_id ? [$res->room_id] : []);
                foreach ($roomIdsToCheck as $rId) {
                    if (in_array((string)$rId, array_map('strval', $resRoomIds))) {
                        $isAvailable = false;
                        break 2;
                    }
                }
            }

            if (!$isAvailable) {
                return back()
                    ->withInput()
                    ->with('error', 'Sorry, one or more selected rooms are already booked for the chosen dates. Please adjust your check-in/check-out dates or select different rooms.');
            }
        }

        if (isset($data['room_id']) && !isset($data['room_ids'])) {
            $data['room_ids'] = [$data['room_id']];
        }

        $messageParts = [];
        if ($request->special_requirements) $messageParts[] = "Special Requirements: " . $request->special_requirements;
        if ($request->additional_notes) $messageParts[] = "Additional Notes: " . $request->additional_notes;
        
        $data['message'] = implode("\n\n", $messageParts);
        $data['special_requirements'] = $request->special_requirements;
        $data['additional_notes'] = $request->additional_notes;
        $data['status'] = 'pending';

        $reservation = Reservation::create($data);

        // Notify Admins, Staff, and Accountants
        $users = \App\Models\User::whereIn('role', ['admin', 'staff', 'accountant'])->get();
        \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\NewReservationRequest($reservation));

        // Send WhatsApp to Customer
        /*
        try {
            $reservation->notify(new \App\Notifications\WhatsAppBookingConfirmed($reservation, 'room'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
        */

        return back()->with('success', 'Thank you. Your reservation request has been received. Our team will confirm shortly.');
    }
}
