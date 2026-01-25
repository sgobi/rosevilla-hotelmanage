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
                    <p class="text-sm text-gray-500">Rooms & Suites</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['rooms'] ?? 0 }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">Pending Reservations</p>
                    <p class="text-3xl font-semibold text-amber-700 mt-2">{{ $stats['reservations_pending'] ?? 0 }}</p>
                </div>
                <div class="p-5 bg-white shadow rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500">All Reservations</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $stats['reservations_total'] ?? 0 }}</p>
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
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentReservations as $reservation)
                                <tr>
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
