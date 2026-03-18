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
        $now = \Carbon\Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $daysInMonth = $now->daysInMonth;

        // Stats
        $roomsCount = \App\Models\Room::count();
        $reservations_pending = \App\Models\Reservation::where('status', 'pending')->count();
        $garden_pending = \App\Models\GardenBooking::where('status', 'pending')->count();
        $events_pending = \App\Models\EventBooking::where('status', 'pending')->count();
        
        $stats = [
            'rooms' => $roomsCount,
            'reservations_pending' => $reservations_pending,
            'garden_pending' => $garden_pending,
            'events_pending' => $events_pending,
            'pending_requests' => $reservations_pending + $garden_pending + $events_pending,
            'guests_in_house' => \App\Models\Reservation::where('status', 'approved')
                ->where(function($q) {
                    $q->whereNotNull('checked_in_at')->whereNull('checked_out_at')
                      ->orWhere(function($sub) {
                          $sub->whereDate('check_in', '<=', now())->whereDate('check_out', '>=', now());
                      });
                })->count(),
            'reviews' => \App\Models\Review::count(),
        ];

        // Revenue Calculation (Borrowing from ReportController logic)
        $resQuery = \App\Models\Reservation::where('status', 'approved')->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $eventQuery = \App\Models\EventBooking::where('status', 'approved')->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $gardenQuery = \App\Models\GardenBooking::where('status', 'approved')->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

        $sumFinal = function($query) {
            return $query->get()->sum('final_price');
        };

        $stats['monthly_revenue'] = $sumFinal($resQuery) + $sumFinal($eventQuery) + $sumFinal($gardenQuery);

        // Occupancy Rate (Simplified: Approved room nights this month / Total possible room nights)
        $approvedNights = \App\Models\Reservation::where('status', 'approved')
            ->where(function($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('check_in', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('check_out', [$startOfMonth, $endOfMonth]);
            })
            ->get()
            ->sum(function($r) {
                return $r->check_in->diffInDays($r->check_out);
            });
        
        $totalPossibleNights = $roomsCount * $daysInMonth;
        $stats['occupancy_rate'] = $totalPossibleNights > 0 ? round(($approvedNights / $totalPossibleNights) * 100, 1) : 0;

        $recentReservations = \App\Models\Reservation::with('room')
            ->latest()
            ->take(8)
            ->get();

        $recentGardenBookings = \App\Models\GardenBooking::latest()
            ->take(8)
            ->get();

        $notifications = auth()->user()->unreadNotifications;

        return view('dashboard', compact('stats', 'recentReservations', 'recentGardenBookings', 'notifications'));
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
            
            // SECURITY: Ensure URL is relative to prevent redirects to 127.0.0.1 or external sites
            // if it was saved during local development or has incorrect APP_URL config.
            if (str_starts_with($url, 'http')) {
                $parsed = parse_url($url);
                $url = ($parsed['path'] ?? '/') . 
                       (isset($parsed['query']) ? '?' . $parsed['query'] : '') . 
                       (isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '');
            }
            
            // Try to append hash for specific row highlighting if ID exists
            if (isset($notification->data['reservation_id'])) {
                // Ensure we don't duplicate the hash if it already exists
                if (strpos($url, '#') === false) {
                    $url .= '#reservation-' . $notification->data['reservation_id'];
                }
            } elseif (isset($notification->data['booking_id'])) {
                if (strpos($url, '#') === false) {
                    $url .= '#event-' . $notification->data['booking_id'];
                }
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

        return $this->index();
    }
}
