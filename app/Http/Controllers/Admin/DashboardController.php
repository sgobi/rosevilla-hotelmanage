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

        return view('dashboard', compact('stats', 'recentReservations'));
    }
}
