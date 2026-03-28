<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period   = $request->get('period', 'yearly');
        $typeFilter = $request->get('type', 'all');   // all | room | event | garden
        $startDate  = $request->get('start_date');
        $endDate    = $request->get('end_date');

        // Resolve date range -------------------------------------------------
        $noDateFilter = false;
        switch ($period) {
            case 'daily':
                $start = Carbon::now()->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;
            case 'monthly':
                $start = Carbon::now()->startOfMonth();
                $end   = Carbon::now()->endOfMonth();
                break;
            case 'yearly':
                $start = Carbon::now()->startOfYear();
                $end   = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $start = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfYear();
                $end   = $endDate   ? Carbon::parse($endDate)->endOfDay()     : Carbon::now()->endOfDay();
                break;
            case 'all':
            default:
                $noDateFilter = true;
                $start = Carbon::now()->startOfYear();
                $end   = Carbon::now()->endOfDay();
        }

        // Helpers ------------------------------------------------------------
        $sumFinal = fn($q) => $q->get()->sum('final_price');

        // ---- Room Reservations ---------------------------------------------
        $resBase = Reservation::where('status', 'approved');
        if (!$noDateFilter) {
            $resBase = $resBase->whereBetween('created_at', [$start, $end]);
        }

        $roomTotal    = $sumFinal(clone $resBase);
        $roomCount    = (clone $resBase)->count();

        // ---- Events --------------------------------------------------------
        $evBase = EventBooking::where('status', 'approved');
        if (!$noDateFilter) {
            $evBase = $evBase->whereBetween('created_at', [$start, $end]);
        }

        $eventTotal   = $sumFinal(clone $evBase);
        $eventCount   = (clone $evBase)->count();

        // ---- Garden --------------------------------------------------------
        $gdBase = \App\Models\GardenBooking::where('status', 'approved');
        if (!$noDateFilter) {
            $gdBase = $gdBase->whereBetween('created_at', [$start, $end]);
        }

        $gardenTotal  = $sumFinal(clone $gdBase);
        $gardenCount  = (clone $gdBase)->count();

        // ---- Build unified ledger ------------------------------------------
        $roomRows = (clone $resBase)->oldest()->get()->map(function ($item) {
            $item->ledger_type    = 'Room';
            $item->ledger_name    = $item->guest_name;
            $item->ledger_email   = $item->email;
            $item->ledger_detail  = $item->rooms()->pluck('title')->implode(', ') ?: 'Room Stay';
            $item->ledger_date    = $item->check_in ? $item->check_in->format('M d, Y') . ' – ' . optional($item->check_out)->format('M d, Y') : '—';
            return $item;
        });

        $eventRows = (clone $evBase)->oldest()->get()->map(function ($item) {
            $servicesLabel = '';
            $fullTooltip   = '';
            if (is_array($item->additional_services) && count($item->additional_services) > 0) {
                $services = collect($item->additional_services)->pluck('type')->filter();
                if ($services->count() > 0) {
                    $fullTooltip = $services->implode(', ');
                    if ($services->count() <= 2) {
                        $servicesLabel = ' (+ ' . $services->implode(', ') . ')';
                    } else {
                        $servicesLabel = ' (+ ' . $services->take(2)->implode(', ') . ' & ' . ($services->count() - 2) . ' more)';
                    }
                }
            }
            
            $item->ledger_type     = 'Event';
            $item->ledger_name     = $item->customer_name;
            $item->ledger_email    = $item->customer_email;
            $item->ledger_detail   = $item->event_type . $servicesLabel;
            $item->ledger_tooltip  = $fullTooltip;
            $item->ledger_date    = $item->event_date ? $item->event_date->format('M d, Y') : '—';
            return $item;
        });

        $gardenRows = (clone $gdBase)->oldest()->get()->map(function ($item) {
            $item->ledger_type    = 'Garden';
            $item->ledger_name    = $item->guest_name;
            $item->ledger_email   = $item->email;
            $item->ledger_detail  = 'Garden Rental';
            $item->ledger_date    = $item->check_in ? $item->check_in->format('M d, Y') . ' – ' . optional($item->check_out)->format('M d, Y') : '—';
            return $item;
        });

        // Filter by type
        if ($typeFilter === 'room') {
            $allRows = $roomRows;
        } elseif ($typeFilter === 'event') {
            $allRows = $eventRows;
        } elseif ($typeFilter === 'garden') {
            $allRows = $gardenRows;
        } else {
            $allRows = $roomRows->concat($eventRows)->concat($gardenRows)->sortByDesc('created_at');
        }

        // Search
        $search = $request->get('search');
        if ($search) {
            $q = strtolower($search);
            $allRows = $allRows->filter(fn($r) =>
                str_contains(strtolower($r->ledger_name), $q) ||
                str_contains(strtolower($r->ledger_email ?? ''), $q) ||
                str_contains(strtolower($r->ledger_type), $q) ||
                str_contains(strtolower($r->ledger_detail), $q) ||
                str_contains((string) $r->id, $q)
            );
        }

        $grandTotal = $roomTotal + $eventTotal + $gardenTotal;
        $grandCount = $roomCount + $eventCount + $gardenCount;

        // If print request, return full unpaginated view
        if ($request->has('print')) {
            return view('admin.reports.print', compact(
                'allRows', 'period', 'typeFilter', 'search',
                'start', 'end', 'noDateFilter',
                'roomTotal', 'roomCount',
                'eventTotal', 'eventCount',
                'gardenTotal', 'gardenCount',
                'grandTotal', 'grandCount'
            ));
        }

        // Paginate for UI view
        $perPage     = 15;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $pagedData   = $allRows->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $ledger      = new \Illuminate\Pagination\LengthAwarePaginator($pagedData, $allRows->count(), $perPage, $currentPage, [
            'path'  => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('admin.reports.index', compact(
            'ledger', 'period', 'typeFilter', 'search',
            'start', 'end',
            'roomTotal', 'roomCount',
            'eventTotal', 'eventCount',
            'gardenTotal', 'gardenCount',
            'grandTotal', 'grandCount',
            'startDate', 'endDate'
        ));
    }
}
