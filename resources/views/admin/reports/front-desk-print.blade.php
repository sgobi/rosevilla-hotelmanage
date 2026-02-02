<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; background: white; }
            .print-break { page-break-after: always; }
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 p-8 antialiased">
    <div class="max-w-5xl mx-auto bg-white p-12 shadow-sm min-h-screen relative overflow-hidden">
        
        {{-- Report Watermark/Decor --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-gray-50 rounded-full -mr-32 -mt-32 opacity-50"></div>
        
        {{-- Header Section --}}
        <div class="relative flex justify-between items-start border-b-2 border-gray-900 pb-8 mb-10">
            <div>
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter leading-none">Rose Villa</h1>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mt-2 italic">Heritage Property Management</p>
                <div class="mt-8 space-y-1">
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest leading-none">Operational Insight Report</p>
                    <p class="text-lg font-black text-gray-900 leading-none mt-1">{{ $title }}</p>
                </div>
            </div>
            
            <div class="text-right">
                <div class="bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-xl">
                    <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Generated At</p>
                    <p class="text-sm font-bold tabular-nums">{{ now()->format('M d, Y • H:i:s') }}</p>
                </div>
                <div class="mt-4 no-print">
                    <button onclick="window.print()" class="bg-rose-gold text-white px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition shadow-lg shadow-rose-gold/20">Print Report</button>
                </div>
            </div>
        </div>

        {{-- Summary Grid --}}
        <div class="grid grid-cols-2 gap-8 mb-12">
            <div class="border-l-4 border-indigo-600 pl-6 py-2 bg-indigo-50/30 rounded-r-2xl">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total Arrivals Processed</p>
                <p class="text-3xl font-black text-indigo-900 leading-none">{{ $checkIns->count() }} Guests</p>
            </div>
            <div class="border-l-4 border-amber-500 pl-6 py-2 bg-amber-50/30 rounded-r-2xl">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Total Departures Processed</p>
                <p class="text-3xl font-black text-amber-900 leading-none">{{ $checkOuts->count() }} Guests</p>
            </div>
        </div>

        {{-- Main Audit Tables --}}
        <div class="space-y-12">
            {{-- Check-in Log --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Arrival Audit Log</h2>
                </div>
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="py-4 pr-4"># ID</th>
                            <th class="py-4 pr-4">Guest Name</th>
                            <th class="py-4 pr-4">Room Category</th>
                            <th class="py-4 pr-4">Check-In Log Time</th>
                            <th class="py-4 text-right">Officer Signature</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($checkIns as $res)
                            <tr>
                                <td class="py-4 pr-4 font-bold text-gray-400 text-xs">#{{ $res->id }}</td>
                                <td class="py-4 pr-4 font-black text-gray-900">{{ $res->guest_name }}</td>
                                <td class="py-4 pr-4 text-xs font-bold text-gray-600">{{ $res->room->title ?? 'Heritage Room' }}</td>
                                <td class="py-4 pr-4">
                                    <span class="font-black text-indigo-600 text-xs uppercase">{{ $res->checked_in_at->format('M d, H:i') }}</span>
                                </td>
                                <td class="py-4 text-right border-b border-gray-100/50">_________________</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-gray-400 italic">No record found for this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="print-break"></div>

            {{-- Check-out Log --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-6 bg-amber-500 rounded-full"></div>
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Departure Audit Log</h2>
                </div>
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="py-4 pr-4"># ID</th>
                            <th class="py-4 pr-4">Guest Name</th>
                            <th class="py-4 pr-4">Room Category</th>
                            <th class="py-4 pr-4">Check-Out Log Time</th>
                            <th class="py-4 text-right">Officer Signature</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($checkOuts as $res)
                            <tr>
                                <td class="py-4 pr-4 font-bold text-gray-400 text-xs">#{{ $res->id }}</td>
                                <td class="py-4 pr-4 font-black text-gray-900">{{ $res->guest_name }}</td>
                                <td class="py-4 pr-4 text-xs font-bold text-gray-600">{{ $res->room->title ?? 'Heritage Room' }}</td>
                                <td class="py-4 pr-4">
                                    <span class="font-black text-amber-600 text-xs uppercase">{{ $res->checked_out_at->format('M d, H:i') }}</span>
                                </td>
                                <td class="py-4 text-right border-b border-gray-100/50">_________________</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-gray-400 italic">No record found for this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Report Footer --}}
        <div class="mt-20 pt-10 border-t border-gray-100 text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em] flex justify-between items-center">
            <div>Rose Villa Heritage - Front Desk Operations Official Archive</div>
            <div class="flex gap-4">
                <span>Certified By: _________________</span>
                <span>Page 1 of 1</span>
            </div>
        </div>
    </div>
</body>
</html>
