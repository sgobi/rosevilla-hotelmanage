<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'rooms' => Room::count(),
            'reservations_pending' => Reservation::where('status', 'pending')->count(),
            'reservations_total' => Reservation::count(),
            'reviews' => Review::count(),
            'gallery' => GalleryImage::count(),
        ];

        $recentReservations = Reservation::with('room')
            ->latest()
            ->take(5)
            ->get();

        $notifications = auth()->user()->unreadNotifications;

        return view('dashboard', compact('stats', 'recentReservations', 'notifications'));
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            $url = $notification->data['action_url'] ?? route('dashboard');
            
            // Try to append hash for specific row highlighting if ID exists
            if (isset($notification->data['reservation_id'])) {
                $url .= '#reservation-' . $notification->data['reservation_id'];
            } elseif (isset($notification->data['booking_id'])) {
                $url .= '#event-' . $notification->data['booking_id'];
            }
            
            return redirect($url);
        }
        
        return back();
    }

    public function fetchNotifications(\Illuminate\Http\Request $request)
    {
        $notifications = auth()->user()->unreadNotifications;
        
        if ($request->ajax()) {
            return view('partials.notifications', compact('notifications'));
        }

        $stats = [
            'rooms' => Room::count(),
            'reservations_pending' => Reservation::where('status', 'pending')->count(),
            'reservations_total' => Reservation::count(),
            'reviews' => Review::count(),
            'gallery' => GalleryImage::count(),
        ];

        $recentReservations = Reservation::with('room')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentReservations', 'notifications'));
    }
}
