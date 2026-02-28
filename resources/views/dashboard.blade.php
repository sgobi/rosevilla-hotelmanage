<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 text-center md:text-left">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">
                    {{ auth()->user()->isAdmin() ? 'Command Center' : (auth()->user()->isAccountant() ? 'Financial Terminal' : 'Staff Dashboard') }}
                </h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Rose Villa Heritage • Property Intel</p>
            </div>
            
            <div class="flex items-center justify-center md:justify-end gap-3 bg-white/50 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="h-10 w-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="text-left">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Last Sync</p>
                    <p class="text-sm font-black text-gray-900 leading-none tabular-nums">{{ now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-8 space-y-8">
            <!-- Notifications -->
            <div id="notifications-container" class="animate-fade-in-up">
                @include('partials.notifications')
            </div>

            <script>
                setInterval(function() {
                    fetch('{{ route('notifications.fetch', [], false) }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            if (html.trim() !== '') {
                                document.getElementById('notifications-container').innerHTML = html;
                            } else {
                                document.getElementById('notifications-container').innerHTML = '';
                            }
                        });
                }, 5000); 
            </script>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Card 1: Inventory --}}
                <div class="group relative bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-indigo-50/50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative flex flex-col gap-6">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-200 ring-4 ring-indigo-50 group-hover:rotate-12 transition-all duration-500" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">Room Inventory</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-5xl font-black text-gray-900 tracking-tight">{{ $stats['rooms'] ?? 0 }}</p>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Units</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Pending --}}
                <div class="group relative bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-amber-50/50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative flex flex-col gap-6">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-amber-200 ring-4 ring-amber-50 group-hover:-rotate-12 transition-all duration-500" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">Pending Gate</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-5xl font-black text-amber-600 tracking-tight">{{ $stats['reservations_pending'] ?? 0 }}</p>
                                <span class="text-xs font-bold text-amber-500 uppercase tracking-widest">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: In House --}}
                <div class="group relative bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-emerald-50/50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative flex flex-col gap-6">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200 ring-4 ring-emerald-50 group-hover:rotate-12 transition-all duration-500" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">In-House Guests</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-5xl font-black text-emerald-600 tracking-tight">{{ $stats['guests_in_house'] ?? 0 }}</p>
                                <span class="text-xs font-bold text-emerald-500 uppercase tracking-widest">Arrivals</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Reviews --}}
                <div class="group relative bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-gray-50/50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative flex flex-col gap-6">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-gray-200 ring-4 ring-gray-50 group-hover:-rotate-12 transition-all duration-500" style="background: linear-gradient(135deg, #374151 0%, #111827 100%);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.3em] mb-2">Global Reviews</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-5xl font-black text-gray-900 tracking-tight">{{ $stats['reviews'] ?? 0 }}</p>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Feedbacks</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-[3rem] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Recent Pipeline Activity</h3>
                        <p class="text-[10px] text-indigo-500 font-bold mt-1">Latest system transactions & status logs</p>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition">View Full Archive →</a>
                </div>
                <div class="p-8 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-[10px] uppercase font-black text-gray-400 tracking-widest">
                            <tr>
                                <th class="pb-6">Guest Terminal</th>
                                <th class="pb-6">Check In/Out</th>
                                <th class="pb-6 text-center">Occupants</th>
                                <th class="pb-6">Property Link</th>
                                <th class="pb-6">Settlement</th>
                                <th class="pb-6 text-right">Operational Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentReservations as $reservation)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="h-12 w-12 rounded-2xl bg-gray-50 group-hover:bg-white text-gray-400 group-hover:text-indigo-600 transition-colors flex items-center justify-center font-black text-lg border border-transparent group-hover:border-indigo-100 group-hover:shadow-sm">
                                                {{ substr($reservation->guest_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-gray-900 tracking-tight leading-none mb-1.5">{{ $reservation->guest_name }}</p>
                                                <p class="text-[10px] font-bold text-gray-400 tabular-nums uppercase tracking-widest">{{ $reservation->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                                <span class="text-[11px] font-black text-gray-700 tracking-tight leading-none uppercase">{{ optional($reservation->check_in)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                                <span class="text-[11px] font-black text-gray-700 tracking-tight leading-none uppercase">{{ optional($reservation->check_out)->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 text-center">
                                        <span class="px-3 py-1.5 bg-gray-50 text-gray-500 rounded-lg text-[10px] font-black tabular-nums border border-gray-100">{{ $reservation->guests }} PAX</span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            </div>
                                            <span class="text-[11px] font-black text-gray-700 uppercase tracking-widest">{{ $reservation->room->title ?? 'Heritage Room' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <div>
                                            <p class="text-[11px] font-black text-gray-900 tracking-tight leading-none mb-1">LKR {{ number_format($reservation->final_price, 2) }}</p>
                                            @if($reservation->discount_status === 'approved' && $reservation->discount_percentage > 0)
                                                <span class="text-[8px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded italic">-{{ $reservation->discount_percentage }}% Privileged</span>
                                            @else 
                                                <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Standard Tariff</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-5 text-right">
                                        <span class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                                            @if($reservation->status === 'approved') bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm shadow-emerald-50
                                            @elseif($reservation->status === 'cancelled') bg-rose-100 text-rose-700 border border-rose-200 shadow-sm shadow-rose-50
                                            @else bg-amber-100 text-amber-700 border border-amber-200 shadow-sm shadow-amber-50 @endif">
                                            {{ $reservation->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-10 text-center" colspan="6">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">No active transactions detected</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
