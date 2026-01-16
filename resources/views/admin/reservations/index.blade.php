<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservations
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">All reservations</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Guest</th>
                                <th class="px-6 py-3">Dates</th>
                                <th class="px-6 py-3">Guests</th>
                                <th class="px-6 py-3">Room</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reservations as $reservation)
                                <tr id="reservation-{{ $reservation->id }}" 
                                    class="scroll-mt-20 transition-colors" 
                                    :class="editing ? 'bg-indigo-50/20 relative z-50' : ''"
                                    x-data="{ editing: false }">
                                    <td class="px-6 py-3">
                                        <p class="font-semibold text-gray-800">{{ $reservation->guest_name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $reservation->email }} @if($reservation->phone) • {{ $reservation->phone }} @endif</p>
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">
                                        {{ optional($reservation->check_in)->format('M d, Y') }} – {{ optional($reservation->check_out)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->guests }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->room->title ?? 'Any' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end gap-2 relative">
                                            <!-- Status & Main Actions -->
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col items-end">
                                                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase shadow-sm border
                                                        @if($reservation->status === 'approved') bg-emerald-50 text-emerald-700 border-emerald-100
                                                        @elseif($reservation->status === 'cancelled') bg-rose-50 text-rose-700 border-rose-100
                                                        @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                                        {{ $reservation->status }}
                                                    </span>
                                                    @if($reservation->discount_status === 'approved')
                                                        <span class="text-[9px] text-emerald-600 font-bold mt-1 bg-emerald-50 px-1.5 rounded">
                                                            {{ $reservation->discount_percentage }}% OFF
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-gray-200 shadow-sm relative z-10">
                                                    @if($reservation->status === 'approved')
                                                        @php
                                                            $canPrint = false;
                                                            $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant();
                                                            $isStaff = auth()->user()->isStaff();
                                                            if ($isAdmin) $canPrint = true;
                                                            elseif ($isStaff) {
                                                                if ($reservation->invoice_print_count === 0 || $reservation->invoice_reprint_status === 'approved') $canPrint = true;
                                                            }
                                                        @endphp
                                                        @if($canPrint)
                                                            <a href="{{ route('admin.invoices.show', $reservation) }}" target="_blank" 
                                                               class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Download Invoice">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant() || $reservation->status === 'pending')
                                                        <button @click="editing = !editing" 
                                                                :class="editing ? 'text-indigo-600 bg-indigo-50' : 'text-gray-400 hover:text-indigo-600 hover:bg-indigo-50'"
                                                                class="p-2 rounded-lg transition-all" title="Manage Details">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Unified Edit Form (Experimental / User Friendly) -->
                                            <div x-show="editing" @click.away="editing = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                 class="bg-white border border-gray-200 rounded-2xl p-5 shadow-2xl text-left w-80 absolute right-0 mt-14 z-[100] ring-1 ring-black ring-opacity-5">
                                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-3">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-gray-900">Manage Reservation</h4>
                                                        <p class="text-[10px] text-gray-500 mt-0.5">Quickly update status or discount</p>
                                                    </div>
                                                    <button @click="editing = false" class="text-gray-400 hover:text-gray-600 bg-gray-50 p-1 rounded-md transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <div class="space-y-5">
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 tracking-widest">Update Status</label>
                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex gap-2">
                                                            @csrf @method('PUT')
                                                            <select name="status" class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                                @foreach(['pending','approved','cancelled'] as $status)
                                                                    <option value="{{ $status }}" @selected($reservation->status === $status)>{{ ucfirst($status) }}</option>
                                                                @endforeach
                                                            </select>
                                                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Set</button>
                                                        </form>
                                                    </div>

                                                    @php $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant(); @endphp
                                                    @if($isAdmin || $reservation->status === 'pending')
                                                        <div class="pt-5 border-t border-gray-100">
                                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 tracking-widest">Discount Management</label>
                                                            
                                                            @if($reservation->discount_status === 'pending')
                                                                <div class="bg-amber-50 rounded-xl p-3 mb-4 border border-amber-100 shadow-inner">
                                                                    <div class="flex items-center gap-2 text-amber-800 font-bold text-[10px] mb-3 uppercase tracking-tight">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                        Requested: {{ $reservation->discount_percentage }}%
                                                                    </div>
                                                                    @if($isAdmin)
                                                                        <div class="flex gap-2">
                                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                                @csrf @method('PUT')
                                                                                <input type="hidden" name="discount_action" value="approve">
                                                                                <button class="w-full bg-emerald-600 text-white py-2 rounded-lg text-[10px] font-bold hover:bg-emerald-700 uppercase transition-colors shadow-sm shadow-emerald-100">Approve</button>
                                                                            </form>
                                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                                @csrf @method('PUT')
                                                                                <input type="hidden" name="discount_action" value="reject">
                                                                                <button class="w-full bg-rose-600 text-white py-2 rounded-lg text-[10px] font-bold hover:bg-rose-700 uppercase transition-colors shadow-sm shadow-rose-100">Reject</button>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex gap-2">
                                                                @csrf @method('PUT')
                                                                <div class="relative flex-1">
                                                                    <input type="number" name="discount_percentage" min="0" max="100" value="{{ $reservation->discount_percentage }}" class="w-full border-gray-200 rounded-xl text-xs bg-white pr-6 focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                                                                    <span class="absolute right-3 top-2.5 text-[10px] font-bold text-gray-400">%</span>
                                                                </div>
                                                                <button class="bg-rose-50 text-rose-600 border border-rose-100 px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-rose-100 transition-all active:scale-95 shadow-sm shadow-rose-50">
                                                                    {{ $isAdmin ? 'Apply' : 'Suggest' }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif

                                                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant() || $reservation->status === 'pending')
                                                        <div class="pt-5 border-t border-rose-100 mt-5">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <label class="block text-[10px] font-bold text-rose-500 uppercase tracking-widest">Danger Zone</label>
                                                                <span class="text-[9px] text-rose-400 italic">Auth Required</span>
                                                            </div>
                                                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="space-y-3">
                                                                @csrf @method('DELETE')
                                                                <div class="relative">
                                                                    <input type="password" name="password" required placeholder="Enter password to delete" 
                                                                           class="w-full border-gray-200 rounded-xl text-xs bg-rose-50/30 pr-10 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder-rose-300">
                                                                    <div class="absolute right-3 top-2.5 text-rose-400/50">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                                    </div>
                                                                </div>
                                                                @error('password')
                                                                    <p class="text-[9px] text-rose-600 font-bold mt-1 px-1">{{ $message }}</p>
                                                                @enderror
                                                                <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-xl text-[10px] font-bold hover:bg-rose-700 transition shadow-md shadow-rose-200 flex items-center justify-center gap-2">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    Permanently Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
