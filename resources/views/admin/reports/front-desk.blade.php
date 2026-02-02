<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Front Desk Report</h2>
                <p class="text-[10px] font-black text-rose-gold uppercase tracking-[0.3em] mt-1">Operational Metrics & Log Audit</p>
            </div>
            
            <form action="{{ route('admin.reports.front-desk') }}" method="GET" class="flex items-center gap-3">
                <input type="date" name="start_date" value="{{ $start->format('Y-m-d') }}" class="rounded-xl border-gray-200 text-xs font-bold text-gray-600 focus:ring-rose-gold focus:border-rose-gold">
                <span class="text-gray-400 font-bold text-xs uppercase">to</span>
                <input type="date" name="end_date" value="{{ $end->format('Y-m-d') }}" class="rounded-xl border-gray-200 text-xs font-bold text-gray-600 focus:ring-rose-gold focus:border-rose-gold">
                <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all">Filter</button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Period Insights --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Check-ins --}}
                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Total Arrivals</p>
                            <p class="text-3xl font-black text-gray-900 leading-none">{{ $checkIns->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Total Check-outs --}}
                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Total Departures</p>
                            <p class="text-3xl font-black text-gray-900 leading-none">{{ $checkOuts->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Occupancy Level --}}
                <div class="bg-gray-900 p-7 rounded-[2.5rem] shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-2">Period Occupancy</p>
                            <p class="text-3xl font-black text-white leading-none">{{ $occupancyData->count() }} <span class="text-sm text-white/40 font-bold uppercase tracking-widest ml-1">Books</span></p>
                        </div>
                        <a href="{{ route('admin.reports.front-desk-print', ['start_date' => $start->toDateString(), 'end_date' => $end->toDateString()]) }}" target="_blank" class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white hover:bg-rose-gold transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Check-in Log --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="font-black text-gray-900 text-sm uppercase tracking-widest">Arrival Audit Log</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Guest</th>
                                    <th class="px-8 py-4">Room</th>
                                    <th class="px-8 py-4">Log Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($checkIns as $res)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="px-8 py-4">
                                            <p class="font-bold text-gray-900 text-sm">{{ $res->guest_name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium">#{{ $res->id }}</p>
                                        </td>
                                        <td class="px-8 py-4">
                                            <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">{{ $res->room->title ?? 'Room' }}</span>
                                        </td>
                                        <td class="px-8 py-4">
                                            <p class="font-bold text-gray-600 text-[11px] leading-none">{{ $res->checked_in_at->format('M d, Y') }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-black">{{ $res->checked_in_at->format('h:i A') }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-10 text-center text-gray-400 text-xs font-bold uppercase italic tracking-widest">No check-in logs for this period</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Check-out Log --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h3 class="font-black text-gray-900 text-sm uppercase tracking-widest">Departure Audit Log</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Guest</th>
                                    <th class="px-8 py-4">Room</th>
                                    <th class="px-8 py-4">Log Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($checkOuts as $res)
                                    <tr class="hover:bg-gray-50/30 transition-colors">
                                        <td class="px-8 py-4">
                                            <p class="font-bold text-gray-900 text-sm">{{ $res->guest_name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium">#{{ $res->id }}</p>
                                        </td>
                                        <td class="px-8 py-4">
                                            <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">{{ $res->room->title ?? 'Room' }}</span>
                                        </td>
                                        <td class="px-8 py-4">
                                            <p class="font-bold text-gray-600 text-[11px] leading-none">{{ $res->checked_out_at->format('M d, Y') }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-black">{{ $res->checked_out_at->format('h:i A') }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-10 text-center text-gray-400 text-xs font-bold uppercase italic tracking-widest">No check-out logs for this period</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
