<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Reservation Details</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Viewing information for reservation #{{ $reservation->id }}</p>
            </div>
            
            <a href="{{ route('admin.reservations.index') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                <div class="h-8 w-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 group-hover:scale-110 group-hover:bg-amber-100 group-hover:text-amber-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest group-hover:text-amber-500 transition-colors">Return To</span>
                    <span class="text-xs font-bold text-gray-900">Terminals</span>
                </div>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold">{{ $reservation->guest_name }}</h3>
                            <p class="text-gray-600">{{ $reservation->email }} | {{ $reservation->phone }}</p>
                            @if($reservation->address)
                                <p class="text-sm text-gray-500 mt-1">{{ $reservation->address }}</p>
                            @endif
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold uppercase
                            @if($reservation->status === 'approved') bg-green-100 text-green-800 
                            @elseif($reservation->status === 'cancelled' || $reservation->status === 'rejected') bg-red-100 text-red-800 
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ str_replace('_', ' ', $reservation->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase">Booking Details</h4>
                            <div class="mt-2 bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">Check In:</span> {{ $reservation->check_in->format('M d, Y') }}</p>
                                <p><span class="font-medium">Check Out:</span> {{ $reservation->check_out->format('M d, Y') }}</p>
                                <p><span class="font-medium">Guests:</span> {{ $reservation->guests }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase">Financials</h4>
                            <div class="mt-2 bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">Total Price:</span> LKR {{ number_format($reservation->total_price, 2) }}</p>
                                @if($reservation->discount_percentage > 0)
                                    <p><span class="font-medium text-emerald-600">Discount ({{ number_format($reservation->discount_percentage, 1) }}% OFF):</span> - LKR {{ number_format(($reservation->total_price * $reservation->discount_percentage) / 100, 2) }}</p>
                                @endif
                                <div class="mt-2 pt-2 border-t border-gray-200 font-bold text-lg text-emerald-600">
                                    Final Price: LKR {{ number_format($reservation->final_price, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($reservation->special_requirements || $reservation->additional_notes)
                    <div class="mb-8 p-4 bg-indigo-50 rounded-lg">
                        <h4 class="text-sm font-semibold text-indigo-900 uppercase mb-2">Notes</h4>
                        @if($reservation->special_requirements)
                            <div class="mb-2"><strong>Special Requirements:</strong> <br> {{ $reservation->special_requirements }}</div>
                        @endif
                        @if($reservation->additional_notes)
                            <div><strong>Additional Notes:</strong> <br> {{ $reservation->additional_notes }}</div>
                        @endif
                    </div>
                    @endif

                    <div class="flex gap-4">
                        @if(auth()->user()->isAdmin() || !in_array($reservation->status, ['approved', 'cancelled']))
                            <a href="{{ route('admin.reservations.edit', $reservation) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Edit Reservation</a>
                        @endif
                        @if($reservation->status === 'approved')
                            <a href="{{ route('admin.invoices.show', $reservation) }}" target="_blank" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Print Invoice</a>
                        @endif
                        <a href="{{ route('admin.reservations.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
