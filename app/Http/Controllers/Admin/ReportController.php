<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ReportController extends Controller
{
    public function index(Request $request)
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
        $reservations = $resQuery->clone()->get()->map(function($item) {
            $item->type = 'Room';
            $item->display_name = $item->guest_name;
            $item->email = $item->email;
            $item->address = $item->address;
            $item->details = $item->room->title ?? '-';
            $item->discount_amount = ($item->total_price * ($item->discount_status === 'approved' ? $item->discount_percentage : 0)) / 100;
            return $item;
        });
        $events = $eventQuery->clone()->get()->map(function($item) {
            $item->type = 'Event';
            $item->display_name = $item->customer_name;
            $item->email = $item->email;
            $item->details = $item->event_type; 
            // For events, we override total_price to be the subtotal for report consistency
            // but final_price is the net.
            return $item;
        });

        $allSales = $reservations->concat($events);

        // Search Logic
        $search = $request->get('search');
        if ($search) {
            $search = strtolower($search);
            $allSales = $allSales->filter(function($sale) use ($search) {
                return str_contains(strtolower($sale->display_name), $search) ||
                       str_contains(strtolower($sale->email), $search) ||
                       str_contains(strtolower($sale->address ?? ''), $search) ||
                       str_contains(strtolower($sale->type), $search) ||
                       str_contains(strtolower($sale->details), $search) ||
                       str_contains((string)$sale->total_price, $search);
            });
        }

        // Sorting Logic
        $sortBy = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if ($direction === 'desc') {
            $sortedSales = $allSales->sortByDesc($sortBy == 'client' ? 'display_name' : ($sortBy == 'amount' ? 'final_price' : ($sortBy == 'details' ? 'details' : $sortBy)));
        } else {
            $sortedSales = $allSales->sortBy($sortBy == 'client' ? 'display_name' : ($sortBy == 'amount' ? 'final_price' : ($sortBy == 'details' ? 'details' : $sortBy)));
        }

        // Manual Pagination (10 per page)
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $pagedData = $sortedSales->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $recentSales = new LengthAwarePaginator($pagedData, $sortedSales->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('admin.reports.index', compact('today', 'week', 'month', 'year', 'recentSales', 'sortBy', 'direction', 'search'));
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
            $item->report_discount = ($item->total_price * ($item->discount_status === 'approved' ? $item->discount_percentage : 0)) / 100;
            return $item;
        });
        $eventSales = $eventQuery->oldest()->get()->map(function($item) {
            $item->report_type = 'Event';
            $item->report_name = $item->customer_name;
            $item->report_desc = $item->event_type;
            $item->report_discount = $item->discount_amount;
            return $item;
        });

        $sales = $resSales->concat($eventSales)->sortBy('created_at');
        
        $totalSubtotal = $sales->sum('total_price');
        $totalTax = $sales->sum('tax_amount');
        $totalDiscount = $sales->sum('report_discount');
        $totalNet = $sales->sum('final_price');

        return view('admin.reports.print', compact('sales', 'totalSubtotal', 'totalTax', 'totalDiscount', 'totalNet', 'title'));
    }
}
