<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event Booking: {{ $event->customer_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <form action="{{ route('admin.events.update', $event) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Name -->
                        <div class="space-y-2">
                            <label for="customer_name" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $event->customer_name) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customer Email -->
                        <div class="space-y-2">
                            <label for="customer_email" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Email</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', $event->customer_email) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div class="space-y-2">
                            <label for="customer_phone" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Customer Phone</label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $event->customer_phone) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('customer_phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Event Type -->
                        <div class="space-y-2">
                            <label for="event_type" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Type</label>
                            <select name="event_type" id="event_type" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="Wedding" @selected(old('event_type', $event->event_type) == 'Wedding')>Wedding</option>
                                <option value="Party" @selected(old('event_type', $event->event_type) == 'Party')>Party</option>
                                <option value="Corporate" @selected(old('event_type', $event->event_type) == 'Corporate')>Corporate Event</option>
                                <option value="Other" @selected(old('event_type', $event->event_type) == 'Other')>Other</option>
                            </select>
                            @error('event_type') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Event Date -->
                        <div class="space-y-2">
                            <label for="event_date" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Date</label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('event_date') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Guests -->
                        <div class="space-y-2">
                            <label for="guests" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Number of Guests</label>
                            <input type="number" name="guests" id="guests" value="{{ old('guests', $event->guests) }}" min="1" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('guests') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Start Time -->
                        <div class="space-y-2">
                            <label for="start_time" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Start Time</label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_time') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- End Time -->
                        <div class="space-y-2">
                            <label for="end_time" class="text-sm font-bold text-gray-700 uppercase tracking-wider">End Time</label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}" required
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('end_time') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Message / Details -->
                    <div class="space-y-2">
                        <label for="message" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Event Details / Message</label>
                        <textarea name="message" id="message" rows="4"
                            class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('message', $event->message) }}</textarea>
                        @error('message') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Total Price -->
                    <div class="space-y-2">
                        <label for="total_price" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Total Price</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-400 font-bold">LKR</span>
                            <input type="number" name="total_price" id="total_price" value="{{ old('total_price', $event->total_price) }}" step="0.01"
                                class="w-full border-gray-200 rounded-xl pl-16 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        @error('total_price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <!-- Invoice Printing Section -->
                        @if($event->status === 'approved')
                            <div class="flex items-center gap-2 mr-auto">
                                @php
                                    $canPrint = false;
                                    $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant();
                                    $isStaff = auth()->user()->isStaff();
                                    
                                    if ($isAdmin) {
                                        $canPrint = true;
                                    } elseif ($isStaff) {
                                        if ($event->invoice_print_count === 0 || $event->invoice_reprint_status === 'approved') {
                                            $canPrint = true;
                                        }
                                    }
                                @endphp

                                @if($canPrint)
                                    <a href="{{ route('admin.events.invoice', $event) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-md flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Print Invoice
                                    </a>
                                @else
                                    <button disabled class="bg-gray-100 text-gray-400 px-4 py-2 rounded-xl text-sm font-bold cursor-not-allowed flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Print Locked
                                    </button>
                                    @if($event->invoice_reprint_status === 'none' || $event->invoice_reprint_status === 'rejected')
                                        <input type="submit" name="reprint_action" value="request" class="text-indigo-600 hover:text-indigo-800 text-sm font-bold cursor-pointer bg-transparent border-0 p-0" title="Request Reprint">
                                    @elseif($event->invoice_reprint_status === 'requested')
                                        <span class="text-amber-500 text-xs font-bold">Reprint Requested</span>
                                        @if($isAdmin)
                                            <div class="flex gap-1">
                                                <button type="submit" name="reprint_action" value="approve" class="bg-emerald-50 text-emerald-600 px-2 py-1 rounded text-xs font-bold hover:bg-emerald-100">Approve</button>
                                                <button type="submit" name="reprint_action" value="reject" class="bg-rose-50 text-rose-600 px-2 py-1 rounded text-xs font-bold hover:bg-rose-100">Reject</button>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @endif

                        <!-- Discount Management Section -->
                        <div class="flex items-center gap-4 border-r border-gray-100 pr-4">
                           @php $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant(); @endphp
                           
                           @if($event->discount_status === 'pending')
                                <div class="flex items-center gap-2">
                                    <span class="text-amber-600 text-xs font-bold bg-amber-50 px-2 py-1 rounded">
                                        {{ $event->discount_percentage }}% Pending
                                    </span>
                                    @if($isAdmin)
                                        <button type="submit" name="discount_action" value="approve" class="text-emerald-600 hover:text-emerald-800 text-xs font-bold">Approve</button>
                                        <button type="submit" name="discount_action" value="reject" class="text-rose-600 hover:text-rose-800 text-xs font-bold">Reject</button>
                                    @endif
                                </div>
                           @endif

                           <div class="flex items-center gap-2">
                               <label for="discount_percentage" class="text-xs font-bold text-gray-500 uppercase">Discount</label>
                               <div class="relative w-24">
                                   <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $event->discount_percentage) }}" min="0" max="100" class="w-full border-gray-200 rounded-lg text-sm p-1 pr-6 focus:ring-2 focus:ring-indigo-500">
                                   <span class="absolute right-2 top-1.5 text-gray-400 text-xs font-bold">%</span>
                               </div>
                           </div>
                        </div>

                        <a href="{{ route('admin.events.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Update & Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
