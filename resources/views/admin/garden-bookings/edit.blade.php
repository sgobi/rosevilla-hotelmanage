<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">
            Edit Garden Booking #{{ $gardenBooking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl shadow-sm">
                    <div class="font-bold text-sm">Whoops! Something went wrong.</div>
                    <ul class="mt-2 list-disc list-inside text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.garden-bookings.update', $gardenBooking) }}" method="POST" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="guest_name" :value="__('Guest Name')" />
                        <x-text-input id="guest_name" class="block mt-1 w-full" type="text" name="guest_name" value="{{ old('guest_name', $gardenBooking->guest_name) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('guest_name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $gardenBooking->email) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ old('phone', $gardenBooking->phone) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div>
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ old('address', $gardenBooking->address) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>

                    <div>
                        <x-input-label for="check_in" :value="__('Check In Date')" />
                        <x-text-input id="check_in" class="block mt-1 w-full" type="date" name="check_in" value="{{ old('check_in', $gardenBooking->check_in->format('Y-m-d')) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('check_in')" />
                    </div>

                    <div>
                        <x-input-label for="check_out" :value="__('Check Out Date')" />
                        <x-text-input id="check_out" class="block mt-1 w-full" type="date" name="check_out" value="{{ old('check_out', $gardenBooking->check_out->format('Y-m-d')) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('check_out')" />
                    </div>

                    <div>
                        <x-input-label for="guests" :value="__('Number of Guests')" />
                        <x-text-input id="guests" class="block mt-1 w-full" type="number" min="1" name="guests" value="{{ old('guests', $gardenBooking->guests) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('guests')" />
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <div>
                        <x-input-label for="special_requirements" :value="__('Special Requirements')" />
                        <textarea id="special_requirements" name="special_requirements" class="rounded-xl shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 block mt-1 w-full" rows="3">{{ old('special_requirements', $gardenBooking->special_requirements) }}</textarea>
                    </div>

                    <div>
                        <x-input-label for="additional_notes" :value="__('Additional Notes (Internal)')" />
                        <textarea id="additional_notes" name="additional_notes" class="rounded-xl shadow-sm border-gray-300 focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 block mt-1 w-full" rows="3">{{ old('additional_notes', $gardenBooking->additional_notes) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100 gap-4">
                    <a href="{{ route('admin.garden-bookings.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Cancel</a>
                    <x-primary-button class="ml-3">
                        Update Booking
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
