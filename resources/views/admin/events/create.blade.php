<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Event Booking
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <form action="{{ route('admin.events.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    
                    @if($errors->has('conflict'))
                        <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 mb-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-rose-800">Booking Conflict Detected</h3>
                                    <p class="mt-1 text-sm text-rose-600">{{ $errors->first('conflict') }}</p>
                                    @if($errors->has('conflict_details'))
                                        <div class="mt-2 text-xs text-rose-500 bg-rose-100 p-2 rounded">
                                            Time: {{ \Carbon\Carbon::parse($errors->first('conflict_details')->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($errors->first('conflict_details')->end_time)->format('h:i A') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex gap-3 pl-10">
                                <a href="{{ route('admin.events.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800">Cancel</a>
                                <button type="submit" name="force_conflict" value="1" class="text-sm font-bold text-rose-600 hover:text-rose-800 underline">
                                    Request Admin Approval to Overbook
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Name -->
                        <div class="space-y-2">
                            <label for="customer_name" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customer Email -->
                        <div class="space-y-2">
                            <label for="customer_email" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Email</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div class="space-y-2">
                            <label for="customer_phone" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Phone</label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Event Type -->
                        <div class="space-y-2">
                            <label for="event_type" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Type</label>
                            <select name="event_type" id="event_type" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select Type</option>
                                <option value="Wedding" @selected(old('event_type') == 'Wedding')>Wedding</option>
                                <option value="Party" @selected(old('event_type') == 'Party')>Party</option>
                                <option value="Corporate" @selected(old('event_type') == 'Corporate')>Corporate Event</option>
                                <option value="Other" @selected(old('event_type') == 'Other')>Other</option>
                            </select>
                            @error('event_type') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Event Date -->
                        <div class="space-y-2">
                            <label for="event_date" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Date</label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('event_date') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Guests -->
                        <div class="space-y-2">
                            <label for="guests" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Number of Guests</label>
                            <input type="number" name="guests" id="guests" value="{{ old('guests') }}" min="1" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('guests') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Start Time -->
                        <div class="space-y-2">
                            <label for="start_time" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Start Time</label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_time') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- End Time -->
                        <div class="space-y-2">
                            <label for="end_time" class="text-sm font-bold text-gray-700 uppercase tracking-wider">End Time</label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('end_time') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Message / Details -->
                    <div class="space-y-2">
                        <label for="message" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Details / Message</label>
                        <textarea name="message" id="message" rows="4"
                            class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('message') }}</textarea>
                        @error('message') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Total Price -->
                    <div class="space-y-2">
                        <label for="total_price" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Total Price (Optional)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-400 font-bold">LKR</span>
                            <input type="number" name="total_price" id="total_price" value="{{ old('total_price') }}" step="0.01"
                                class="w-full border-gray-200 rounded-xl pl-16 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        @error('total_price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.events.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Create Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
