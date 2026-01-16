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
                                <th class="px-6 py-3"></th>
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
                                    <td class="px-6 py-3">
                                    <td class="px-6 py-3">
                                        <!-- Status Management -->
                                        @php 
                                            $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant(); 
                                        @endphp
                                        
                                        @if($reservation->status === 'pending' || $isAdmin)
                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex items-center gap-2 mb-3">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="border rounded px-2 py-1 text-xs">
                                                    @foreach(['pending','approved','cancelled'] as $status)
                                                        <option value="{{ $status }}" @selected($reservation->status === $status)>{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="text-indigo-600 text-xs uppercase font-semibold">Update</button>
                                            </form>
                                        @endif

                                        @if($reservation->status !== 'pending')
                                            <div class="mb-3 space-y-1">
                                                <div>
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                        @if($reservation->status === 'approved') bg-green-100 text-green-700
                                                        @else bg-red-100 text-red-700 @endif">
                                                        {{ ucfirst($reservation->status) }}
                                                    </span>
                                                </div>
                                                @if($reservation->discount_status === 'approved')
                                                    <div class="text-[10px] text-green-600 font-bold uppercase">
                                                        ✓ {{ $reservation->discount_percentage }}% Discount Applied
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Discount Management -->
                                        @if(($reservation->status === 'pending' || $isAdmin) && ($reservation->discount_status === 'none' || $reservation->discount_status === 'pending' || ($isAdmin && $reservation->status === 'approved')))
                                            <div class="border-t border-gray-100 pt-2">
                                                @if($reservation->discount_status === 'pending')
                                                    <div class="bg-yellow-50 p-2 rounded text-xs border border-yellow-100 mb-2">
                                                        <span class="font-bold text-yellow-700">Discount Request: {{ $reservation->discount_percentage }}%</span>
                                                        @if($isAdmin)
                                                            <div class="mt-2 flex gap-2">
                                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                                    @csrf @method('PUT')
                                                                    <input type="hidden" name="discount_action" value="approve">
                                                                    <button class="text-green-600 hover:text-green-800 font-bold uppercase">Approve</button>
                                                                </form>
                                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                                    @csrf @method('PUT')
                                                                    <input type="hidden" name="discount_action" value="reject">
                                                                    <button class="text-red-600 hover:text-red-800 font-bold uppercase">Reject</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <p class="text-gray-500 italic mt-1">Waiting for Admin approval</p>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Form to Suggest/Update Discount -->
                                                @if($reservation->discount_status === 'none' || $isAdmin)
                                                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="number" name="discount_percentage" min="0" max="100" value="{{ $reservation->discount_percentage }}" placeholder="%" class="w-16 border rounded px-2 py-1 text-xs" required>
                                                        <button class="text-rose-600 text-xs uppercase font-semibold" title="{{ $isAdmin ? 'Update Discount' : 'Suggest Discount' }}">
                                                            {{ $isAdmin ? 'Update' : 'Suggest' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Invoice / Reprint Logic -->
                                        @if($reservation->status === 'approved')
                                            <div class="mt-3">
                                                @php
                                                    $canPrint = false;
                                                    $isStaff = auth()->user()->isStaff();
                                                    $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant();
                                                    
                                                    if ($isAdmin) {
                                                        $canPrint = true;
                                                    } elseif ($isStaff) {
                                                        if ($reservation->invoice_print_count === 0 || $reservation->invoice_reprint_status === 'approved') {
                                                            $canPrint = true;
                                                        }
                                                    }
                                                @endphp

                                                @if($canPrint)
                                                    <a href="{{ route('admin.invoices.show', $reservation) }}" 
                                                       target="_blank" 
                                                       @if($isStaff) onclick="setTimeout(() => { this.style.display='none'; document.getElementById('reprint-req-{{ $reservation->id }}').style.display='block'; }, 100)" @endif
                                                       class="text-gray-500 hover:text-gray-800 text-sm flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                        </svg>
                                                        Download Invoice
                                                    </a>
                                                    {{-- Hidden placeholder for after print --}}
                                                    <div id="reprint-req-{{ $reservation->id }}" style="display:none;">
                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="reprint_action" value="request">
                                                            <button class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold underline flex items-center gap-1">
                                                                Request Reprint
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($isStaff)
                                                    @if($reservation->invoice_reprint_status === 'requested')
                                                        <span class="text-xs text-amber-600 font-medium flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 animate-pulse"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                            Reprint Pending
                                                        </span>
                                                    @else
                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="reprint_action" value="request">
                                                            <button class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold underline flex items-center gap-1">
                                                                Request Reprint
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif

                                                <!-- Admin Actions for Reprint -->
                                                @if($isAdmin && $reservation->invoice_reprint_status === 'requested')
                                                    <div class="mt-2 text-xs bg-red-50 p-2 rounded border border-red-100">
                                                        <p class="font-bold text-red-800 mb-1">Reprint Requested</p>
                                                        <div class="flex gap-2">
                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="reprint_action" value="approve">
                                                                <button class="text-green-600 font-bold uppercase hover:text-green-800">Approve</button>
                                                            </form>
                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="reprint_action" value="reject">
                                                                <button class="text-red-600 font-bold uppercase hover:text-red-800">Reject</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        @if($reservation->status === 'pending' || $isAdmin)
                                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Delete this reservation?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline text-sm">Delete</button>
                                            </form>
                                        @endif
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
