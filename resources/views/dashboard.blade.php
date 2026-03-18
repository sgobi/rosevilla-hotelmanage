<x-app-layout>
    <div class="px-8 py-10 space-y-10">
        <!-- Dashboard Header -->
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
                <p class="text-sm text-slate-500 mt-1">Real-time property performance and guest operations.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.front-desk.calendar') }}" class="px-4 py-2 bg-slate-900 text-white border border-slate-900 rounded-xl text-xs font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 uppercase tracking-widest">
                    Master Calendar
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $metrics = [
                    [
                        'label' => 'Active Stays',
                        'value' => $stats['guests_in_house'] ?? 0,
                        'trend' => '+12%',
                        'trendUp' => true,
                        'icon' => 'indigo',
                        'sparkline' => 'M0 20 Q5 5, 10 15 T20 10 T30 18 T40 5 T50 15'
                    ],
                    [
                        'label' => 'Pending Requests',
                        'value' => $stats['pending_requests'] ?? 0,
                        'trend' => '-2',
                        'trendUp' => false,
                        'icon' => 'amber',
                        'sparkline' => 'M0 10 Q5 15, 10 5 T20 18 T30 10 T40 15 T50 8'
                    ],
                    [
                        'label' => 'Monthly Revenue',
                        'value' => \App\Helpers\CurrencyHelper::format($stats['monthly_revenue'] ?? 0),
                        'trend' => '+8.4%',
                        'trendUp' => true,
                        'icon' => 'emerald',
                        'sparkline' => 'M0 20 L10 12 L20 15 L30 5 L40 10 L50 2'
                    ],
                    [
                        'label' => 'Occupancy Rate',
                        'value' => ($stats['occupancy_rate'] ?? 0) . '%',
                        'trend' => '+2.1%',
                        'trendUp' => true,
                        'icon' => 'blue',
                        'sparkline' => 'M0 15 Q10 5, 20 12 T40 8 T50 18'
                    ]
                ];
            @endphp

            @foreach($metrics as $metric)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="mb-4">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $metric['label'] }}</div>
                    </div>
                    <div class="flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-black text-slate-900 tracking-tight">{{ $metric['value'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content: Dual-Column Pipeline -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Room Bookings Feed -->
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Room Stays</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Recent guest activity</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition-all">View All Stays</a>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div class="divide-y divide-slate-50">
                        @forelse($recentReservations as $reservation)
                            <div class="p-6 hover:bg-slate-50 transition-all flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs ring-2 ring-white overflow-hidden shrink-0 group-hover:scale-105 transition-transform">
                                        {{ substr($reservation->guest_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $reservation->guest_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium lowercase truncate max-w-[150px]">{{ $reservation->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end gap-2">
                                    <div class="px-3 py-1 bg-slate-100 border border-slate-200 rounded-full text-[9px] font-black text-slate-600 tracking-wider">
                                        {{ optional($reservation->check_in)->format('M d') }} - {{ optional($reservation->check_out)->format('M d') }}
                                    </div>
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'checked_in' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'checked_out' => 'bg-slate-50 text-slate-600 border-slate-200',
                                        ][$reservation->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-md border {{ $statusClass }} text-[8px] font-black uppercase tracking-widest">
                                        {{ str_replace('_', ' ', $reservation->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 italic text-sm">No recent room bookings found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Garden & Events Feed -->
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-600/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Garden Events</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Nature-themed inquiries</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.garden-bookings.index') }}" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 transition-all">View Garden</a>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div class="divide-y divide-slate-50">
                        @forelse($recentGardenBookings as $booking)
                            <div class="p-6 hover:bg-slate-50 transition-all flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs ring-2 ring-white overflow-hidden shrink-0 group-hover:scale-105 transition-transform">
                                        {{ substr($booking->guest_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $booking->guest_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium lowercase truncate max-w-[150px]">{{ $booking->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end gap-2">
                                    <div class="px-3 py-1 bg-slate-100 border border-slate-200 rounded-full text-[9px] font-black text-slate-600 tracking-wider">
                                        {{ optional($booking->check_in)->format('M d') }} - {{ optional($booking->check_out)->format('M d') }}
                                    </div>
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'completed' => 'bg-slate-50 text-slate-600 border-slate-200',
                                        ][$booking->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-md border {{ $statusClass }} text-[8px] font-black uppercase tracking-widest">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 italic text-sm">No recent garden bookings found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-10 right-10 z-50" x-data="{ open: false }">
        <button @click="open = !open" 
                class="h-16 w-16 bg-slate-900 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 active:scale-95 transition-all shadow-slate-900/40 relative group">
            <svg class="w-8 h-8 transform transition-transform duration-300" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <!-- Label -->
            <span class="absolute right-20 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest py-2 px-4 rounded-xl opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all shadow-xl pointer-events-none whitespace-nowrap">New Booking</span>
        </button>

        <!-- Menu items -->
        <div x-show="open" @click.away="open = false" 
             class="absolute bottom-20 right-0 space-y-3" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-cloak>
            <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3 bg-white p-3 rounded-2xl shadow-xl border border-slate-100 hover:bg-slate-50 transition-colors whitespace-nowrap">
                <div class="h-8 w-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700">Manage Stays</span>
            </a>
            <a href="{{ route('admin.garden-bookings.create') }}" class="flex items-center gap-3 bg-white p-3 rounded-2xl shadow-xl border border-slate-100 hover:bg-slate-50 transition-colors whitespace-nowrap">
                <div class="h-8 w-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700">New Garden Event</span>
            </a>
            <a href="{{ route('admin.events.create') }}" class="flex items-center gap-3 bg-white p-3 rounded-2xl shadow-xl border border-slate-100 hover:bg-slate-50 transition-colors whitespace-nowrap">
                <div class="h-8 w-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-700">New Other Event</span>
            </a>
        </div>
    </div>
</x-app-layout>
