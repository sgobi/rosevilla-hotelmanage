<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event Booking: {{ $event->customer_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-indigo-50/30 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/50">
                <form action="{{ route('admin.events.update', $event) }}" method="POST" class="p-8 md:p-12 space-y-10"
                    x-data="{ 
                        services: {{ old('additional_services', $event->additional_services) ? json_encode(old('additional_services', $event->additional_services)) : '[]' }},
                        basePrice: 0,
                        discountPercentage: 0,
                        selectedRooms: {{ old('room_ids', $event->room_ids) ? json_encode(array_map('strval', old('room_ids', $event->room_ids))) : '[]' }},
                        gardenSelection: {{ old('garden_selection', $event->garden_selection) == '1' ? 'true' : 'false' }},
                        checkIn: '{{ old('event_date', optional($event->event_date)->format('Y-m-d')) }}',
                        checkOut: '{{ old('check_out', optional($event->check_out)->format('Y-m-d')) }}',
                        roomPrices: {{ $roomPrices->toJson() }},
                        gardenPricePerDay: {{ $gardenPricePerDay }},
                        
                        addService() { this.services.push({ type: '', price: 0 }) },
                        removeService(index) { this.services.splice(index, 1) },

                        get days() {
                            if (!this.checkIn || !this.checkOut) return 1;
                            let start = new Date(this.checkIn);
                            let end = new Date(this.checkOut);
                            let diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                            return diff > 0 ? diff : 1; 
                        },

                        get totalAmount() {
                            let roomTotal = this.selectedRooms.reduce((sum, rId) => sum + (parseFloat(this.roomPrices[rId] || 0) * this.days), 0);
                            let gardenTotal = this.gardenSelection ? (this.gardenPricePerDay * this.days) : 0;
                            let additionalTotal = this.services.reduce((sum, s) => sum + (parseFloat(s.price) || 0), 0);
                            let subtotal = roomTotal + gardenTotal + additionalTotal;
                            let discount = subtotal * ((parseFloat(this.discountPercentage) || 0) / 100);
                            return subtotal - discount;
                        }
                    }">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="total_price" value="0">
                    <input type="hidden" name="discount_percentage" value="0">
                    
                    <!-- Section: Customer Info -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Customer Information</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="space-y-2">
                                <label for="customer_name" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Full Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $event->customer_name) }}" required
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('customer_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="customer_email" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Email Address</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', $event->customer_email) }}" required
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('customer_email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="customer_phone" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Phone Number</label>
                                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $event->customer_phone) }}" required
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('customer_phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="address" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Customer Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $event->address) }}"
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                @error('address') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Venue Selection -->
                    <div class="space-y-6 pt-4 bg-indigo-50/30 -mx-8 md:-mx-12 p-8 md:p-12 border-y border-indigo-100/50">
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-100 p-2 rounded-lg text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Venue Selection</h3>
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <label class="group relative flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-3xl cursor-pointer hover:border-emerald-500 transition-all shadow-sm">
                                <input type="hidden" name="garden_selection" value="0">
                                <input type="checkbox" name="garden_selection" id="garden_selection" value="1" x-model="gardenSelection"
                                    class="w-6 h-6 text-emerald-600 rounded-lg focus:ring-emerald-500 border-slate-300">
                                <div class="flex flex-col">
                                    <span class="text-base font-bold text-slate-800">Garden Venue</span>
                                    <span class="text-xs text-slate-500">Outdoor spaces & grounds</span>
                                </div>
                            </label>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Select Rooms</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @php $selectedRooms = is_array(old('room_ids', $event->room_ids)) ? old('room_ids', $event->room_ids) : []; @endphp
                                @foreach($rooms ?? [] as $room)
                                    <label class="group relative flex items-start gap-4 p-5 bg-white border border-slate-200 rounded-3xl cursor-pointer hover:border-indigo-500 transition-all shadow-sm">
                                        <div class="mt-1">
                                            <input type="checkbox" name="room_ids[]" value="{{ $room->id }}" x-model="selectedRooms"
                                                class="w-6 h-6 text-indigo-600 rounded-lg focus:ring-indigo-500 border-slate-300">
                                        </div>
                                        <div class="flex flex-col border-l border-slate-100 pl-4 space-y-1">
                                            <span class="text-sm font-black text-slate-800">{{ $room->title }}</span>
                                            <span class="text-xs font-bold text-slate-500 bg-slate-100 w-fit px-2 py-0.5 rounded-full">Cap: {{ $room->capacity }} Guests</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('room_ids') <p class="text-xs text-rose-600 mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Section: Event Detail -->
                    <div class="space-y-6 pt-10">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="bg-emerald-100 p-2 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Event Scheduling</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label for="event_type" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Event Type</label>
                                <select name="event_type" id="event_type" required
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                    <option value="Wedding" @selected(old('event_type', $event->event_type) == 'Wedding')>Wedding Ceremony</option>
                                    <option value="Party" @selected(old('event_type', $event->event_type) == 'Party')>Social Party</option>
                                    <option value="Corporate" @selected(old('event_type', $event->event_type) == 'Corporate')>Corporate Meeting</option>
                                    <option value="Other" @selected(old('event_type', $event->event_type) == 'Other')>Other Special Occasion</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="event_date" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Check-in Date</label>
                                <div class="relative group">
                                    <input type="text" name="event_date" id="event_date" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d')) }}" required x-model="checkIn"
                                        class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-colors group-hover:text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="check_out" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Check-out Date</label>
                                <div class="relative group">
                                    <input type="text" name="check_out" id="check_out" value="{{ old('check_out', optional($event->check_out)->format('Y-m-d')) }}" required x-model="checkOut"
                                        class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-colors group-hover:text-amber-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <label for="guests" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Total Guests</label>
                                <input type="number" name="guests" id="guests" value="{{ old('guests', $event->guests) }}" min="1" required
                                    class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            </div>

                            <div class="space-y-2">
                                <label for="arrival_time" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Arrival Time</label>
                                <div class="relative group">
                                    <input type="text" name="arrival_time" id="arrival_time" value="{{ old('arrival_time', $event->arrival_time ? \Carbon\Carbon::parse($event->arrival_time)->format('H:i') : '') }}"
                                        class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-colors group-hover:text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="start_time" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">Start Time</label>
                                <div class="relative group">
                                    <input type="text" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}" required
                                        class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-colors group-hover:text-emerald-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="end_time" class="block text-xs font-black text-slate-400 uppercase tracking-[0.1em]">End Time</label>
                                <div class="relative group">
                                    <input type="text" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}" required
                                        class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-colors group-hover:text-rose-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Services -->
                    <div class="space-y-6 pt-4 -mx-8 md:-mx-12 p-8 md:p-12 border-b border-slate-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800">Additional Services</h3>
                            </div>
                            <button type="button" @click="addService()" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Service
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(service, index) in services" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100 items-end shadow-sm">
                                    <div class="md:col-span-7 space-y-2">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Service Type</label>
                                        <input type="text" x-model="service.type" :name="'additional_services['+index+'][type]'" 
                                            class="w-full bg-white border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="e.g. Photography, Catering...">
                                    </div>
                                    <div class="md:col-span-4 space-y-2">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Price (LKR)</label>
                                        <input type="number" x-model="service.price" :name="'additional_services['+index+'][price]'" step="0.01"
                                            class="w-full bg-white border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="0.00">
                                    </div>
                                    <div class="md:col-span-1 flex justify-center pb-2">
                                        <button type="button" @click="removeService(index)" class="p-2.5 text-rose-500 hover:bg-rose-50 rounded-xl transition-all active:scale-90">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="services.length === 0" class="text-center py-8 border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/30">
                                 <p class="text-slate-400 font-medium text-xs italic">No additional services added yet. Click "Add Service" to include extras.</p>
                            </div>
                        </div>

                    <!-- Section: Message & Billing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-4">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">Event Details</h3>
                            </div>
                            <textarea name="message" id="message" rows="5"
                                class="w-full bg-slate-50/50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">{{ old('message', $event->message) }}</textarea>
                            @error('message') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-emerald-100 p-2 rounded-lg text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">Pricing & Summary</h3>
                            </div>
                            <div class="bg-slate-50/80 rounded-3xl p-6 border border-slate-100 space-y-4">
                                <div class="space-y-4">
                                    <div class="pt-4 border-t border-slate-200 mt-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Amount</span>
                                            <span class="text-2xl font-black text-indigo-600" x-text="'LKR ' + totalAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})">LKR 0.00</span>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end items-center gap-6 pt-10 border-t border-slate-100">
                        @if($event->status === 'approved')
                            <a href="{{ route('admin.events.invoice', $event) }}" target="_blank" class="bg-indigo-100 text-indigo-700 px-6 py-4 rounded-2xl text-sm font-black hover:bg-indigo-200 transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Print Invoice
                            </a>
                        @endif
                        <a href="{{ route('admin.events.index') }}" class="text-sm font-black text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">Cancel</a>
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-12 py-4 rounded-2xl text-base font-black hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95">
                            Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const initFlatpickr = () => {
            if (typeof flatpickr === 'undefined') {
                setTimeout(initFlatpickr, 100);
                return;
            }

            const formatDate = (date) => {
                const d = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
                return d.toISOString().split('T')[0];
            };

            window.bookedDatesByRoom = {!! $bookedDatesByRoom ?? '{}' !!};
            window.bookedDatesGarden = {!! $bookedDatesGarden ?? '[]' !!};

            const getSelectedRooms = () => Array.from(document.querySelectorAll('input[name="room_ids[]"]:checked')).map(cb => cb.value);
            const isGardenSelected = () => document.getElementById('garden_selection') && document.getElementById('garden_selection').checked;

            const disabledDatesFunc = function(date) {
                const dateStr = formatDate(date);
                const selectedRooms = getSelectedRooms();
                const gardenSelected = isGardenSelected();

                if (gardenSelected && window.bookedDatesGarden) {
                    for(let j = 0; j < window.bookedDatesGarden.length; j++) {
                        const range = window.bookedDatesGarden[j];
                        if (dateStr >= range.check_in && dateStr <= range.check_out) return true;
                    }
                }

                if (selectedRooms.length > 0 && window.bookedDatesByRoom) {
                    for (let i = 0; i < selectedRooms.length; i++) {
                        const rId = selectedRooms[i];
                        if (window.bookedDatesByRoom[rId]) {
                            for(let j = 0; j < window.bookedDatesByRoom[rId].length; j++) {
                                const range = window.bookedDatesByRoom[rId][j];
                                const isBooked = (range.check_in === range.check_out) 
                                    ? (dateStr === range.check_in)
                                    : (dateStr >= range.check_in && dateStr < range.check_out);
                                if (isBooked) return true;
                            }
                        }
                    }
                }
                return false;
            };

            const fpConfig = {
                dateFormat: "Y-m-d",
                minDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                disable: [disabledDatesFunc],
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.className = instance.input.className;
                        instance.altInput.placeholder = "Select Date...";
                    }
                }
            };

            const fpCheckIn = flatpickr("#event_date", {
                ...fpConfig,
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates[0]) fpCheckOut.set("minDate", formatDate(selectedDates[0]));
                    document.getElementById('event_date').dispatchEvent(new Event('input'));
                }
            });

            const fpCheckOut = flatpickr("#check_out", { 
                ...fpConfig,
                onChange: function(selectedDates, dateStr) {
                    document.getElementById('check_out').dispatchEvent(new Event('input'));
                }
            });

            const timeConfig = {
                noCalendar: true,
                enableTime: true,
                dateFormat: "H:i",
                altInput: true,
                altFormat: "h:i K",
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.className = instance.input.className;
                    }
                }
            };

            flatpickr("#arrival_time", timeConfig);
            flatpickr("#start_time", timeConfig);
            flatpickr("#end_time", timeConfig);

            document.querySelectorAll('input[name="room_ids[]"], #garden_selection').forEach(input => {
                input.addEventListener('change', () => {
                    fpCheckIn.redraw();
                    fpCheckOut.redraw();
                });
            });
        };
        initFlatpickr();
    });
    </script>
    @endpush
</x-app-layout>
