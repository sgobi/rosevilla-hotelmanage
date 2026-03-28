<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Ledger Print Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { 
                background-color: white !important; 
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .no-print { display: none !important; }
            @page {
                size: A4 landscape;
                margin: 1cm;
            }
            .page-break-inside-avoid {
                page-break-inside: avoid;
            }
        }
        body { background-color: #f3f4f6; padding: 2rem; font-family: 'Inter', sans-serif; }
        .print-container { 
            max-width: 297mm; /* A4 landscape width */
            margin: 0 auto; 
            background: white; 
            padding: 2rem; 
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        @media print {
            body { padding: 0; }
            .print-container { box-shadow: none; padding: 0; max-width: none; }
        }
    </style>
</head>
<body class="text-gray-900 antialiased">
    
    <div class="no-print mb-6 max-w-[297mm] mx-auto flex justify-end gap-3">
        <button type="button" onclick="window.close()" class="px-6 py-2 bg-white text-gray-600 rounded-xl text-xs font-black uppercase tracking-widest border border-gray-200 hover:bg-gray-50 transition-colors">
            Close
        </button>
        <button type="button" onclick="window.print()" class="px-6 py-2 bg-violet-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-md shadow-violet-200 hover:bg-violet-700 transition-colors">
            Print Ledger
        </button>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="flex items-start justify-between border-b-2 border-gray-900 pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-black uppercase tracking-tight text-gray-900">Transaction Ledger</h1>
                <p class="text-xs font-black text-violet-600 uppercase tracking-widest mt-1">
                    @if($noDateFilter)
                        All Time Report
                    @else
                        {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}
                    @endif
                </p>
                <div class="flex items-center gap-3 mt-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                    <span>Generated: {{ now()->format('M d, Y h:i A') }}</span>
                    <span>•</span>
                    <span>Filter: {{ $typeFilter === 'all' ? 'All Categories' : ucfirst($typeFilter) }}</span>
                    @if($search)
                        <span>•</span>
                        <span>Search: "{{ $search }}"</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-black text-gray-900 uppercase tracking-tighter">Rose Villa</div>
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Heritage Homes</div>
            </div>
        </div>

        <!-- Master Totals -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Room Stay Revenue</div>
                <div class="text-lg font-black text-indigo-600 tabular-nums">LKR {{ number_format($roomTotal, 0) }}</div>
                <div class="text-[9px] font-bold text-gray-500 mt-1">{{ $roomCount }} bookings</div>
            </div>
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Events Revenue</div>
                <div class="text-lg font-black text-rose-600 tabular-nums">LKR {{ number_format($eventTotal, 0) }}</div>
                <div class="text-[9px] font-bold text-gray-500 mt-1">{{ $eventCount }} bookings</div>
            </div>
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Garden Revenue</div>
                <div class="text-lg font-black text-emerald-600 tabular-nums">LKR {{ number_format($gardenTotal, 0) }}</div>
                <div class="text-[9px] font-bold text-gray-500 mt-1">{{ $gardenCount }} bookings</div>
            </div>
            <div class="p-4 bg-gray-900 rounded-2xl border border-gray-900 text-white">
                <div class="text-[9px] font-black text-white/50 uppercase tracking-widest mb-1">Grand Total</div>
                <div class="text-lg font-black text-white tabular-nums">LKR {{ number_format($grandTotal, 0) }}</div>
                <div class="text-[9px] font-bold text-white/50 mt-1">{{ $grandCount }} total records</div>
            </div>
        </div>

        <!-- Ledger Table -->
        <table class="w-full text-left text-xs mb-8">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="py-2 pr-2 font-black text-[10px] uppercase tracking-wider text-gray-500">Date/Time</th>
                    <th class="py-2 px-2 font-black text-[10px] uppercase tracking-wider text-gray-500">Type</th>
                    <th class="py-2 px-2 font-black text-[10px] uppercase tracking-wider text-gray-500">Client Info</th>
                    <th class="py-2 px-2 font-black text-[10px] uppercase tracking-wider text-gray-500">Detail / Service Date</th>
                    <th class="py-2 pl-2 font-black text-[10px] uppercase tracking-wider text-gray-500 text-right">Net Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($allRows as $row)
                    <tr class="page-break-inside-avoid">
                        <td class="py-3 pr-2 align-top">
                            <div class="font-bold text-gray-900">{{ $row->created_at->format('M d, Y') }}</div>
                            <div class="text-[9px] text-gray-500">{{ $row->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 px-2 align-top">
                            <span class="font-black text-[10px] uppercase tracking-wider 
                                {{ $row->ledger_type === 'Room' ? 'text-indigo-600' : '' }}
                                {{ $row->ledger_type === 'Event' ? 'text-rose-600' : '' }}
                                {{ $row->ledger_type === 'Garden' ? 'text-emerald-600' : '' }}
                            ">
                                {{ $row->ledger_type }}
                            </span>
                            <div class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">#{{ $row->id }}</div>
                        </td>
                        <td class="py-3 px-2 align-top">
                            <div class="font-bold text-gray-900">{{ $row->ledger_name }}</div>
                            <div class="text-[10px] text-gray-500">{{ $row->ledger_email ?? 'No Email' }}</div>
                        </td>
                        <td class="py-3 px-2 align-top">
                            <div class="font-medium text-gray-800">{{ $row->ledger_detail }}</div>
                            <div class="text-[9px] text-gray-500 uppercase tracking-widest mt-0.5">{{ $row->ledger_date }}</div>
                            
                            @if($row->discount_amount > 0 || $row->tax_amount > 0)
                                <div class="mt-1 flex gap-2 text-[9px] font-bold">
                                    @if($row->discount_amount > 0)
                                        <span class="text-emerald-600">Off: {{ number_format($row->discount_amount, 0) }}</span>
                                    @endif
                                    @if($row->tax_amount > 0)
                                        <span class="text-rose-500">Tax: {{ number_format($row->tax_amount, 0) }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="py-3 pl-2 align-top text-right">
                            <div class="font-black text-gray-900 tabular-nums text-sm">LKR {{ number_format($row->final_price, 0) }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 text-xs font-bold uppercase tracking-widest border-b border-gray-100">
                            No active transactions found for this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($allRows->count() > 0)
                <tfoot>
                    <tr class="border-t-2 border-gray-900">
                        <td colspan="4" class="py-3 text-right text-[10px] font-black uppercase tracking-widest text-gray-500 pr-4">
                            Report Total
                        </td>
                        <td class="py-3 pl-2 text-right">
                            <div class="text-lg font-black text-gray-900 tabular-nums">LKR {{ number_format($allRows->sum('final_price'), 0) }}</div>
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>

        <div class="text-center text-[9px] font-black uppercase tracking-widest text-gray-400 pt-8 border-t border-gray-100">
            End of Report · Generated accurately by Rose Villa Finance System
        </div>
    </div>

    <!-- Auto print on load -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
