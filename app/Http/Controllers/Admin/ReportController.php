<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Only count 'approved' reservations and event bookings as actual sales
        $resQuery = Reservation::where('status', 'approved');
        $eventQuery = EventBooking::where('status', 'approved');

        $today = $resQuery->clone()->whereDate('created_at', Carbon::today())->sum('total_price') +
                 $eventQuery->clone()->whereDate('created_at', Carbon::today())->get()->sum('final_price');
        
        $week = ($resQuery->clone()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_price')) +
                ($eventQuery->clone()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->sum('final_price'));

        $month = ($resQuery->clone()->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('total_price')) +
                 ($eventQuery->clone()->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get()->sum('final_price'));

        $year = ($resQuery->clone()->whereYear('created_at', Carbon::now()->year)->sum('total_price')) +
                ($eventQuery->clone()->whereYear('created_at', Carbon::now()->year)->get()->sum('final_price'));

        // Recent sales list (merged and sorted)
        $recentReservations = $resQuery->clone()->latest()->take(10)->get()->map(function($item) {
            $item->type = 'Room';
            $item->display_name = $item->guest_name;
            return $item;
        });
        $recentEvents = $eventQuery->clone()->latest()->take(10)->get()->map(function($item) {
            $item->type = 'Event';
            $item->display_name = $item->customer_name;
            $item->room = (object)['title' => $item->event_type]; // Mock for UI consistency
            $item->total_price = $item->final_price;
            return $item;
        });

        $recentSales = $recentReservations->concat($recentEvents)->sortByDesc('created_at')->take(10);

        return view('admin.reports.index', compact('today', 'week', 'month', 'year', 'recentSales'));
    }

    public function print(Request $request)
    {
        $resQuery = Reservation::where('status', 'approved');
        $eventQuery = EventBooking::where('status', 'approved');
        $title = 'Sales Report';
        $period = $request->input('period');

        if ($request->has(['start_date', 'end_date'])) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $resQuery->whereBetween('created_at', [$start, $end]);
            $eventQuery->whereBetween('created_at', [$start, $end]);
            $title .= ': ' . $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
        } elseif ($period === 'today') {
            $resQuery->whereDate('created_at', Carbon::today());
            $eventQuery->whereDate('created_at', Carbon::today());
            $title .= ': Today (' . now()->format('M d, Y') . ')';
        } elseif ($period === 'week') {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $resQuery->whereBetween('created_at', [$start, $end]);
            $eventQuery->whereBetween('created_at', [$start, $end]);
            $title .= ': This Week (' . $start->format('M d') . ' - ' . $end->format('M d, Y') . ')';
        } elseif ($period === 'month') {
            $resQuery->whereMonth('created_at', Carbon::now()->month)
                     ->whereYear('created_at', Carbon::now()->year);
            $eventQuery->whereMonth('created_at', Carbon::now()->month)
                       ->whereYear('created_at', Carbon::now()->year);
            $title .= ': ' . now()->format('F Y');
        } elseif ($period === 'year') {
            $resQuery->whereYear('created_at', Carbon::now()->year);
            $eventQuery->whereYear('created_at', Carbon::now()->year);
            $title .= ': ' . now()->format('Y');
        }

        $resSales = $resQuery->oldest()->get()->map(function($item) {
            $item->report_type = 'Room';
            $item->report_name = $item->guest_name;
            $item->report_desc = $item->room->title ?? 'Accommodation';
            return $item;
        });
        $eventSales = $eventQuery->oldest()->get()->map(function($item) {
            $item->report_type = 'Event';
            $item->report_name = $item->customer_name;
            $item->report_desc = $item->event_type;
            // Ensure revenue column uses final_price
            $item->total_price = $item->final_price;
            return $item;
        });

        $sales = $resSales->concat($eventSales)->sortBy('created_at');
        $total = $sales->sum('total_price');

        return view('admin.reports.print', compact('sales', 'total', 'title'));
    }
}
