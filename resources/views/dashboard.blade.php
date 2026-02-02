<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->isAdmin() ? 'Rosevilla Admin Dashboard' : (auth()->user()->isAccountant() ? 'Rosevilla Accountant Dashboard' : 'Rosevilla Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Notifications -->
            <div id="notifications-container">
                @include('partials.notifications')
            </div>

            <script>
                setInterval(function() {
                    fetch('{{ route('notifications.fetch') }}', {
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
                }, 5000); // Check every 5 seconds
            </script>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Rooms</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['rooms'] ?? 0 }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Pending Reservations</p>
                    <p class="text-3xl font-semibold text-amber-700 mt-2">{{ $stats['reservations_pending'] ?? 0 }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Guests In-House</p>
                        <p class="text-3xl font-semibold text-emerald-600 mt-2">{{ $stats['guests_in_house'] ?? 0 }}</p>
                    </div>
                    <div class="h-10 w-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Published Reviews</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['reviews'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Reservations</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="pb-3">Guest</th>
                                <th class="pb-3">Dates</th>
                                <th class="pb-3">Guests</th>
                                <th class="pb-3">Room</th>
                                <th class="pb-3">Total</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentReservations as $reservation)
                                <tr class="hover:relative hover:z-[60] group transition-colors hover:bg-gray-50/50">
                                    <td class="py-3">
                                        <p class="font-semibold text-gray-800">{{ $reservation->guest_name }}</p>
                                        <p class="text-gray-500">{{ $reservation->email }}</p>
                                        @if($reservation->message)
                                            <div class="mt-2 relative" x-data="{ showMessage: false }">
                                                <button @mouseenter="showMessage = true" @mouseleave="showMessage = false" class="flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors group cursor-help">
                                                    <svg class="w-3 h-3 text-indigo-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                    <span class="text-[9px] font-bold uppercase tracking-wide">Request</span>
                                                </button>
                                                
                                                <div x-show="showMessage" 
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-1"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     x-transition:leave="transition ease-in duration-150"
                                                     x-transition:leave-start="opacity-100 translate-y-0"
                                                     x-transition:leave-end="opacity-0 translate-y-1"
                                                     class="absolute left-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 p-3 z-[60] pointer-events-none text-left">
                                                    <div class="absolute -top-1.5 left-4 w-3 h-3 bg-white border-l border-t border-gray-100 transform rotate-45"></div>
                                                    <p class="text-[10px] text-gray-600 leading-relaxed relative z-10">{{ $reservation->message }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 text-gray-700">
                                        {{ optional($reservation->check_in)->format('M d, Y') }} – {{ optional($reservation->check_out)->format('M d, Y') }}
                                    </td>
                                    <td class="py-3 text-gray-700">{{ $reservation->guests }}</td>
                                    <td class="py-3 text-gray-700">{{ $reservation->room->title ?? 'Any' }}</td>
                                    <td class="py-3">
                                        <div x-data="{ show: false }" class="relative">
                                            <div @mouseenter="show = true" @mouseleave="show = false" class="cursor-help inline-block">
                                                <div class="font-bold text-gray-900 leading-none">LKR {{ number_format($reservation->final_price, 2) }}</div>
                                                @if($reservation->discount_status === 'approved' && $reservation->discount_percentage > 0)
                                                    <div class="text-[8px] text-emerald-600 mt-0.5 tracking-tight">-{{ $reservation->discount_percentage }}% Off</div>
                                                @endif
                                            </div>

                                            <!-- Tooltip Popover -->
                                            <div x-show="show" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 translate-y-1"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 translate-y-0"
                                                 x-transition:leave-end="opacity-0 translate-y-1"
                                                 class="absolute z-[100] {{ $loop->remaining < 2 ? 'bottom-full' : 'top-full' }} right-0 {{ $loop->remaining < 2 ? 'mb-3' : 'mt-3' }} w-64 bg-gray-900/95 backdrop-blur-md text-white rounded-2xl p-4 shadow-2xl ring-1 ring-white/10 pointer-events-none"
                                                 style="display: none;">
                                                
                                                <div class="space-y-2 text-[10px]">
                                                    <div class="flex justify-between border-b border-white/10 pb-2 mb-2">
                                                        <span class="text-gray-400 uppercase tracking-widest font-black text-[8px]">Quick Summary</span>
                                                        <span class="font-bold text-indigo-300">#{{ $reservation->id }}</span>
                                                    </div>
                                                    
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-400">Duration</span>
                                                        <span class="font-medium text-white">{{ ($reservation->check_in && $reservation->check_out) ? $reservation->check_in->diffInDays($reservation->check_out) ?: 1 : 1 }} Night(s)</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-400">Guests</span>
                                                        <span class="font-medium text-white">{{ $reservation->guests }} Person(s)</span>
                                                    </div>
                                                    <div class="flex justify-between {{ $reservation->discount_amount > 0 ? 'text-emerald-400' : 'text-gray-500' }} pt-1 border-t border-white/5 mt-1">
                                                        <span>Discount</span>
                                                        <span>- LKR {{ number_format($reservation->discount_amount, 2) }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-gray-400">
                                                        <span>Tax Charge</span>
                                                        <span>+ LKR {{ number_format($reservation->tax_amount, 2) }}</span>
                                                    </div>
                                                    <div class="flex justify-between border-t border-white/20 pt-2 mt-2">
                                                        <span class="font-bold text-gray-300 uppercase tracking-widest text-[8px]">Grand Total</span>
                                                        <span class="font-black text-amber-400">LKR {{ number_format($reservation->final_price, 2) }}</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Arrow -->
                                                @if($loop->remaining < 2)
                                                    <div class="absolute -bottom-1.5 right-8 w-2.5 h-2.5 bg-gray-900/95 rotate-45 border-r border-b border-white/10"></div>
                                                @else
                                                    <div class="absolute -top-1.5 right-8 w-2.5 h-2.5 bg-gray-900/95 rotate-45 border-l border-t border-white/10"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($reservation->status === 'approved') bg-green-100 text-green-700
                                            @elseif($reservation->status === 'cancelled') bg-red-100 text-red-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-3 text-gray-500" colspan="5">No reservations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
