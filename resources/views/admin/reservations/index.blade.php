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
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reservations as $reservation)
                                <tr id="reservation-{{ $reservation->id }}" class="scroll-mt-20">
                                    <td class="px-6 py-3">
                                        <p class="font-semibold text-gray-800">{{ $reservation->guest_name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $reservation->email }} @if($reservation->phone) • {{ $reservation->phone }} @endif</p>
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">
                                        {{ optional($reservation->check_in)->format('M d, Y') }} – {{ optional($reservation->check_out)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->guests }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->room->title ?? 'Any' }}</td>
                                    <td class="px-6 py-3 text-right" x-data="{ editingStatus: false }">
                                        <div class="flex flex-col items-end gap-3">
                                            <!-- Status Display -->
                                            <div class="flex items-center gap-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($reservation->status === 'approved') bg-green-100 text-green-700
                                                    @elseif($reservation->status === 'cancelled') bg-red-100 text-red-700
                                                    @else bg-amber-100 text-amber-700 @endif">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                                
                                                @php 
                                                    $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant(); 
                                                @endphp
                                                
                                                @if($isAdmin || $reservation->status === 'pending')
                                                    <button @click="editingStatus = !editingStatus" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold uppercase">
                                                        Edit
                                                    </button>
                                                @endif
                                            </div>

                                            @if($reservation->discount_status === 'approved')
                                                <div class="text-[10px] text-green-600 font-bold uppercase">
                                                    ✓ {{ $reservation->discount_percentage }}% Discount Applied
                                                </div>
                                            @endif

                                            <!-- Status Update Form (Toggled) -->
                                            <template x-if="editingStatus">
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex items-center gap-2 bg-gray-50 p-2 rounded border border-gray-100 shadow-sm animate-fade-in">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" class="border rounded px-2 py-1 text-xs bg-white">
                                                        @foreach(['pending','approved','cancelled'] as $status)
                                                            <option value="{{ $status }}" @selected($reservation->status === $status)>{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="bg-indigo-600 text-white px-3 py-1 rounded text-[10px] uppercase font-bold hover:bg-indigo-700 transition">Update</button>
                                                    <button type="button" @click="editingStatus = false" class="text-gray-400 hover:text-gray-600">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            </template>

                                            <!-- Discount Management -->
                                            @if(($reservation->status === 'pending' || $isAdmin) && ($reservation->discount_status === 'none' || $reservation->discount_status === 'pending' || ($isAdmin && $reservation->status === 'approved')))
                                                <div class="flex flex-col items-end gap-2 w-full max-w-[200px]">
                                                    @if($reservation->discount_status === 'pending')
                                                        <div class="w-full bg-yellow-50 p-2 rounded text-[10px] border border-yellow-100">
                                                            <div class="font-bold text-yellow-700">Request: {{ $reservation->discount_percentage }}%</div>
                                                            @if($isAdmin)
                                                                <div class="mt-2 flex justify-end gap-3">
                                                                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="inline">
                                                                        @csrf @method('PUT')
                                                                        <input type="hidden" name="discount_action" value="approve">
                                                                        <button class="text-green-600 hover:text-green-800 font-bold uppercase">Approve</button>
                                                                    </form>
                                                                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="inline">
                                                                        @csrf @method('PUT')
                                                                        <input type="hidden" name="discount_action" value="reject">
                                                                        <button class="text-red-600 hover:text-red-800 font-bold uppercase">Reject</button>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <p class="text-gray-400 italic mt-1">Pending approval</p>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if($reservation->discount_status === 'none' || $isAdmin)
                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex items-center gap-2">
                                                            @csrf @method('PUT')
                                                            <input type="number" name="discount_percentage" min="0" max="100" value="{{ $reservation->discount_percentage }}" placeholder="%" class="w-12 border rounded px-2 py-1 text-[10px]">
                                                            <button class="text-rose-600 text-[10px] uppercase font-bold hover:text-rose-800">
                                                                {{ $isAdmin ? 'Update Discount' : 'Suggest Discount' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- Invoice / Deletion -->
                                            <div class="flex items-center gap-4 border-t border-gray-100 pt-3 w-full justify-end">
                                                @if($reservation->status === 'approved')
                                                    @php
                                                        $canPrint = false;
                                                        $isStaff = auth()->user()->isStaff();
                                                        if ($isAdmin) $canPrint = true;
                                                        elseif ($isStaff) {
                                                            if ($reservation->invoice_print_count === 0 || $reservation->invoice_reprint_status === 'approved') $canPrint = true;
                                                        }
                                                    @endphp

                                                    @if($canPrint)
                                                        <a href="{{ route('admin.invoices.show', $reservation) }}" target="_blank" class="text-gray-500 hover:text-gray-800 text-xs flex items-center gap-1">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                            Invoice
                                                        </a>
                                                    @endif
                                                @endif

                                                @if($reservation->status === 'pending' || $isAdmin)
                                                    <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Delete this reservation?');" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-bold uppercase transition">Delete</button>
                                                    </form>
                                                @endif
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
