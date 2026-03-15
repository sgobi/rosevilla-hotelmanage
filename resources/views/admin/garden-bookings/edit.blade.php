<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">
            Edit Garden Booking #{{ $gardenBooking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form action="{{ route('admin.garden-bookings.update', $gardenBooking) }}" method="POST" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="guest_name" value="Guest Name" />
                        <x-input id="guest_name" class="block mt-1 w-full" type="text" name="guest_name" value="{{ old('guest_name', $gardenBooking->guest_name) }}" required />
                    </div>

                    <div>
                        <x-label for="email" value="Email" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $gardenBooking->email) }}" required />
                    </div>

                    <div>
                        <x-label for="phone" value="Phone" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ old('phone', $gardenBooking->phone) }}" />
                    </div>

                    <div>
                        <x-label for="address" value="Address" />
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ old('address', $gardenBooking->address) }}" />
                    </div>

                    <div>
                        <x-label for="check_in" value="Check In Date" />
                        <x-input id="check_in" class="block mt-1 w-full" type="date" name="check_in" value="{{ old('check_in', $gardenBooking->check_in->format('Y-m-d')) }}" required />
                    </div>

                    <div>
                        <x-label for="check_out" value="Check Out Date" />
                        <x-input id="check_out" class="block mt-1 w-full" type="date" name="check_out" value="{{ old('check_out', $gardenBooking->check_out->format('Y-m-d')) }}" required />
                    </div>

                    <div>
                        <x-label for="guests" value="Number of Guests" />
                        <x-input id="guests" class="block mt-1 w-full" type="number" min="1" name="guests" value="{{ old('guests', $gardenBooking->guests) }}" required />
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <div>
                        <x-label for="special_requirements" value="Special Requirements" />
                        <textarea id="special_requirements" name="special_requirements" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" rows="3">{{ old('special_requirements', $gardenBooking->special_requirements) }}</textarea>
                    </div>

                    <div>
                        <x-label for="additional_notes" value="Additional Notes (Internal)" />
                        <textarea id="additional_notes" name="additional_notes" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" rows="3">{{ old('additional_notes', $gardenBooking->additional_notes) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100 gap-4">
                    <a href="{{ route('admin.garden-bookings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                    <x-button class="ml-3">
                        Update Booking
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
