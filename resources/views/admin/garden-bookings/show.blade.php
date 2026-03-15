<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">
            Garden Booking #{{ $gardenBooking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold">{{ $gardenBooking->guest_name }}</h3>
                            <p class="text-gray-600">{{ $gardenBooking->email }} | {{ $gardenBooking->phone }}</p>
                            @if($gardenBooking->address)
                                <p class="text-sm text-gray-500 mt-1">{{ $gardenBooking->address }}</p>
                            @endif
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold uppercase
                            @if($gardenBooking->status === 'approved') bg-green-100 text-green-800 
                            @elseif($gardenBooking->status === 'cancelled' || $gardenBooking->status === 'rejected') bg-red-100 text-red-800 
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ str_replace('_', ' ', $gardenBooking->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase">Booking Details</h4>
                            <div class="mt-2 bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">Check In:</span> {{ $gardenBooking->check_in->format('M d, Y') }}</p>
                                <p><span class="font-medium">Check Out:</span> {{ $gardenBooking->check_out->format('M d, Y') }}</p>
                                <p><span class="font-medium">Guests:</span> {{ $gardenBooking->guests }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 uppercase">Financials</h4>
                            <div class="mt-2 bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">Total Price:</span> LKR {{ number_format($gardenBooking->total_price, 2) }}</p>
                                <p><span class="font-medium">Discount ({{ number_format($gardenBooking->discount_percentage ?? 0, 1) }}%):</span> - LKR {{ number_format($gardenBooking->discount_amount, 2) }}</p>
                                <p><span class="font-medium">Tax ({{ number_format($gardenBooking->tax_percentage, 1) }}%):</span> + LKR {{ number_format($gardenBooking->tax_amount, 2) }}</p>
                                <div class="mt-2 pt-2 border-t border-gray-200 font-bold text-lg text-emerald-600">
                                    Final Price: LKR {{ number_format($gardenBooking->final_price, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($gardenBooking->special_requirements || $gardenBooking->additional_notes)
                    <div class="mb-8 p-4 bg-indigo-50 rounded-lg">
                        <h4 class="text-sm font-semibold text-indigo-900 uppercase mb-2">Notes</h4>
                        @if($gardenBooking->special_requirements)
                            <div class="mb-2"><strong>Special Requirements:</strong> <br> {{ $gardenBooking->special_requirements }}</div>
                        @endif
                        @if($gardenBooking->additional_notes)
                            <div><strong>Additional Notes:</strong> <br> {{ $gardenBooking->additional_notes }}</div>
                        @endif
                    </div>
                    @endif

                    <div class="flex gap-4">
                        <a href="{{ route('admin.garden-bookings.edit', $gardenBooking) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Edit Booking</a>
                        <a href="{{ route('admin.garden-bookings.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
