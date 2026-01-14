<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Only count 'approved' reservations as actual sales
        $query = Reservation::where('status', 'approved');

        $today = $query->clone()->whereDate('created_at', Carbon::today())->sum('total_price');
        
        $week = $query->clone()->whereBetween('created_at', [
            Carbon::now()->startOfWeek(), 
            Carbon::now()->endOfWeek()
        ])->sum('total_price');

        $month = $query->clone()->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        $year = $query->clone()->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // Recent sales list
        $recentSales = $query->clone()->latest()->take(10)->get();

        return view('admin.reports.index', compact('today', 'week', 'month', 'year', 'recentSales'));
    }

    public function print(Request $request)
    {
        $query = Reservation::where('status', 'approved');
        $title = 'Sales Report';
        $period = $request->input('period');

        if ($request->has(['start_date', 'end_date'])) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $title .= ': ' . $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
        } elseif ($period === 'today') {
            $query->whereDate('created_at', Carbon::today());
            $title .= ': Today (' . now()->format('M d, Y') . ')';
        } elseif ($period === 'week') {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $query->whereBetween('created_at', [$start, $end]);
            $title .= ': This Week (' . $start->format('M d') . ' - ' . $end->format('M d, Y') . ')';
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
            $title .= ': ' . now()->format('F Y');
        } elseif ($period === 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
            $title .= ': ' . now()->format('Y');
        }

        $sales = $query->oldest()->get();
        $total = $sales->sum('total_price');

        return view('admin.reports.print', compact('sales', 'total', 'title'));
    }
}
