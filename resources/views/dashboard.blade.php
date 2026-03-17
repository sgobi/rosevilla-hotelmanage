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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                {{-- Card 1: Room Inventory --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-indigo-500 to-indigo-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Room Units</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-gray-900">{{ $stats['rooms'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Room Pending --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-amber-500 to-amber-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Room Pending</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-amber-600">{{ $stats['reservations_pending'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Garden Pending --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-emerald-500 to-emerald-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Garden Pending</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-emerald-600">{{ $stats['garden_pending'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Events Pending --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-rose-500 to-rose-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Event Pending</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-rose-600">{{ $stats['events_pending'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 5: In House --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-blue-500 to-blue-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">In House Rooms</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-blue-600">{{ $stats['guests_in_house'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 6: Reviews --}}
                <div class="group relative bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                    <div class="relative flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-lg bg-gradient-to-br from-gray-700 to-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Reviews</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-3xl font-black text-gray-900">{{ $stats['reviews'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Room Pipeline --}}
                <div class="bg-white shadow-sm rounded-[2.5rem] border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-indigo-50/30">
                        <div>
                            <h3 class="text-xs font-black text-indigo-900 uppercase tracking-[0.3em]">Room Pipeline</h3>
                            <p class="text-[9px] text-indigo-500 font-bold mt-1 uppercase">Latest Room Stays</p>
                        </div>
                        <a href="{{ route('admin.reservations.index') }}" class="text-[9px] font-black text-indigo-400 uppercase tracking-widest hover:text-indigo-600 transition">Archive →</a>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentReservations as $reservation)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-8 py-5">
                                            <p class="font-black text-gray-900 leading-none mb-1">{{ $reservation->guest_name }}</p>
                                            <p class="text-[10px] text-gray-400 lowercase">{{ $reservation->email }}</p>
                                        </td>
                                        <td class="px-4 py-5">
                                            <span class="text-[10px] font-bold text-indigo-600 uppercase">{{ optional($reservation->check_in)->format('M d') }} - {{ optional($reservation->check_out)->format('M d') }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[9px] font-bold uppercase">{{ $reservation->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="p-10 text-center text-[10px] font-black text-gray-400 uppercase">Empty Pipeline</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Garden Pipeline --}}
                <div class="bg-white shadow-sm rounded-[2.5rem] border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-emerald-50/30">
                        <div>
                            <h3 class="text-xs font-black text-emerald-900 uppercase tracking-[0.3em]">Garden Pipeline</h3>
                            <p class="text-[9px] text-emerald-500 font-bold mt-1 uppercase">Latest Garden Use</p>
                        </div>
                        <a href="{{ route('admin.garden-bookings.index') }}" class="text-[9px] font-black text-emerald-400 uppercase tracking-widest hover:text-emerald-600 transition">Archive →</a>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentGardenBookings as $booking)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-8 py-5">
                                            <p class="font-black text-gray-900 leading-none mb-1">{{ $booking->guest_name }}</p>
                                            <p class="text-[10px] text-gray-400 lowercase">{{ $booking->email }}</p>
                                        </td>
                                        <td class="px-4 py-5">
                                            <span class="text-[10px] font-bold text-emerald-600 uppercase">{{ optional($booking->check_in)->format('M d') }} - {{ optional($booking->check_out)->format('M d') }}</span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[9px] font-bold uppercase">{{ $booking->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="p-10 text-center text-[10px] font-black text-gray-400 uppercase">Empty Pipeline</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
