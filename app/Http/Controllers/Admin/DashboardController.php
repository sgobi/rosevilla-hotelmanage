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
            
            // Redirect to the specific reservation row
            return redirect($notification->data['action_url'] . '#reservation-' . $notification->data['reservation_id']);
        }
        
        return back();
    }

    public function fetchNotifications()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('partials.notifications', compact('notifications'));
    }
}
