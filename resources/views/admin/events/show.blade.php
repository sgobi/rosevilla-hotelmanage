<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Booking Details</h2>
                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mt-1 italic">Viewing information for event booking #{{ $event->id }}</p>
            </div>

            <a href="{{ route('admin.events.index') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                <div class="h-8 w-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 group-hover:scale-110 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest group-hover:text-indigo-500 transition-colors">Return To</span>
                    <span class="text-xs font-bold text-gray-900">Event Bookings</span>
                </div>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- ── Guest Info Card ── --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 flex justify-between items-start gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-100 to-violet-200 flex items-center justify-center shrink-0">
                            <span class="text-xl font-black text-indigo-700">{{ strtoupper(substr($event->customer_name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">{{ $event->customer_name }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $event->customer_email }} &bull; {{ $event->customer_phone }}</p>
                            @if($event->address)
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->address }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <span class="shrink-0 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border
                        @if($event->status === 'approved') bg-green-50 text-green-700 border-green-200
                        @elseif(in_array($event->status, ['cancelled','rejected'])) bg-red-50 text-red-700 border-red-200
                        @else bg-yellow-50 text-yellow-700 border-yellow-200 @endif">
                        {{ str_replace('_', ' ', $event->status) }}
                    </span>
                </div>
            </div>

            {{-- ── Event Details & Financials ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Event Details --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Event Details</h4>
                        </div>
                        <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100">{{ $event->event_type }}</span>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Event Date</span>
                            <span class="text-sm font-bold text-gray-800">{{ optional($event->event_date)->format('M d, Y') }}</span>
                        </div>
                        @if($event->check_out && $event->event_date && $event->check_out->ne($event->event_date))
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">End Date</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->check_out->format('M d, Y') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Duration</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->duration }} {{ Str::plural('Day', $event->duration) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Start Time</span>
                            <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">End Time</span>
                            <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</span>
                        </div>
                        @if($event->arrival_time)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Host Arrival</span>
                            <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($event->arrival_time)->format('h:i A') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Attendees</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->guests }} {{ Str::plural('Guest', $event->guests) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Financials --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Financials</h4>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Venue Subtotal</span>
                            <span class="text-sm font-bold text-gray-800">LKR {{ number_format($event->venue_total_price, 2) }}</span>
                        </div>
                        @if($event->total_price > 0)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Additional Rate</span>
                            <span class="text-sm font-bold text-gray-800">LKR {{ number_format($event->total_price, 2) }}</span>
                        </div>
                        @endif
                        @if(!empty($event->additional_services))
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Services Total</span>
                            <span class="text-sm font-bold text-gray-800">LKR {{ number_format($event->additional_services_total_price, 2) }}</span>
                        </div>
                        @endif
                        @if($event->discount_amount > 0)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Discount <span class="normal-case font-normal">({{ number_format($event->discount_percentage, 1) }}%)</span></span>
                            <span class="text-sm font-bold text-rose-500">− LKR {{ number_format($event->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Tax <span class="normal-case font-normal">({{ number_format($event->tax_percentage, 1) }}%)</span></span>
                            <span class="text-sm font-bold text-amber-600">+ LKR {{ number_format($event->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 mt-1 border-t-2 border-gray-200">
                            <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Final Price</span>
                            <span class="text-lg font-black text-emerald-600">LKR {{ number_format($event->final_price, 2) }}</span>
                        </div>
                        @if($event->advance_amount > 0)
                        <div class="flex justify-between items-center py-2 border-t border-dashed border-gray-100 mt-1">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Advance Paid</span>
                            <span class="text-sm font-bold text-indigo-600">− LKR {{ number_format($event->advance_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Balance Due</span>
                            <span class="text-sm font-bold text-amber-600">LKR {{ number_format($event->final_price - $event->advance_amount, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Venue Assignment ── --}}
            @if($event->garden_selection || count($event->rooms_list) > 0)
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Venue Assignment</h4>
                </div>
                <div class="p-5 space-y-3">
                    @if($event->garden_selection)
                        <div class="flex items-center justify-between py-2 border-b border-dashed border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Garden &amp; Grounds</p>
                                    <p class="text-xs text-gray-400">Outdoor Event Space</p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">LKR {{ number_format($event->garden_price_per_day, 2) }} /Day</span>
                        </div>
                    @endif
                    @forelse($event->rooms_list as $room)
                        <div class="flex items-center justify-between py-2 border-b border-dashed border-gray-100 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $room->title }}</p>
                                    <p class="text-xs text-gray-400">Indoor Accommodation</p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg border border-indigo-100">LKR {{ number_format($room->price_per_night, 2) }} /Night</span>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            @endif

            {{-- ── Additional Services ── --}}
            @if(!empty($event->additional_services))
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-violet-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Additional Services</h4>
                </div>
                <div class="p-5 space-y-3">
                    @foreach($event->additional_services as $service)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100 last:border-0">
                            <span class="text-sm font-bold text-gray-700">{{ $service['type'] }}</span>
                            <span class="text-sm font-black text-gray-800">LKR {{ number_format($service['price'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Notes / Message ── --}}
            @if($event->message)
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h4 class="text-xs font-black text-indigo-800 uppercase tracking-widest">Customer Notes</h4>
                </div>
                <p class="text-sm text-gray-700 leading-relaxed italic border-l-4 border-indigo-300 pl-4">"{{ $event->message }}"</p>
            </div>
            @endif

            {{-- ── Cancellation / Conflict reasons ── --}}
            @if($event->status === 'cancelled' && $event->cancellation_reason)
            <div class="bg-red-50 border border-red-100 rounded-2xl p-5">
                <p class="text-xs font-black text-red-500 uppercase tracking-widest mb-1">Cancellation Reason</p>
                <p class="text-sm text-red-700 leading-relaxed">{{ $event->cancellation_reason }}</p>
            </div>
            @endif

            @if($event->conflict_status && $event->conflict_status !== 'none' && $event->conflict_note)
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5">
                <p class="text-xs font-black text-amber-500 uppercase tracking-widest mb-1">Conflict Override Note</p>
                <p class="text-sm text-amber-700 leading-relaxed">{{ $event->conflict_note }}</p>
            </div>
            @endif

            {{-- ── Payments ── --}}
            @if($event->advance_paid_at || $event->final_payment_at)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Advance Payment --}}
                @if($event->advance_paid_at)
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Advance Payment</h4>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Amount</span>
                            <span class="text-sm font-black text-emerald-700">LKR {{ number_format($event->advance_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Method</span>
                            <span class="text-sm font-bold text-gray-800 uppercase">{{ $event->advance_payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Guest</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->advance_guest_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">NIC</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->advance_nic_no }}</span>
                        </div>
                        @if($event->advance_bank_name)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Bank</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->advance_bank_name }}@if($event->advance_bank_branch) / {{ $event->advance_bank_branch }}@endif</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Paid On</span>
                            <span class="text-sm font-bold text-emerald-600">{{ $event->advance_paid_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Final Payment --}}
                @if($event->final_payment_at)
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Final Payment</h4>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Amount</span>
                            <span class="text-sm font-black text-emerald-700">LKR {{ number_format($event->final_payment_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Method</span>
                            <span class="text-sm font-bold text-gray-800 uppercase">{{ $event->final_payment_method }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Guest</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->final_guest_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">NIC</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->final_nic_no }}</span>
                        </div>
                        @if($event->final_bank_name)
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Bank</span>
                            <span class="text-sm font-bold text-gray-800">{{ $event->final_bank_name }}@if($event->final_bank_branch) / {{ $event->final_bank_branch }}@endif</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Paid On</span>
                            <span class="text-sm font-bold text-emerald-600">{{ $event->final_payment_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            {{-- ── Event Lifecycle ── --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="bg-white shadow-sm rounded-2xl border {{ $event->checked_in_at ? 'border-indigo-100' : 'border-gray-100' }} overflow-hidden">
                    <div class="px-5 py-3.5 border-b {{ $event->checked_in_at ? 'border-indigo-100 bg-indigo-50/50' : 'border-gray-100' }} flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $event->checked_in_at ? 'bg-indigo-500' : 'bg-gray-300' }}"></span>
                        <h4 class="text-xs font-black {{ $event->checked_in_at ? 'text-indigo-700' : 'text-gray-400' }} uppercase tracking-widest">Event Started</h4>
                    </div>
                    <div class="p-5 text-center">
                        @if($event->checked_in_at)
                            <p class="text-lg font-black text-indigo-700">{{ $event->checked_in_at->format('M d, Y') }}</p>
                            <p class="text-sm font-bold text-indigo-500">{{ $event->checked_in_at->format('h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-300 font-bold italic">Pending</p>
                        @endif
                    </div>
                </div>
                <div class="bg-white shadow-sm rounded-2xl border {{ $event->checked_out_at ? 'border-emerald-100' : 'border-gray-100' }} overflow-hidden">
                    <div class="px-5 py-3.5 border-b {{ $event->checked_out_at ? 'border-emerald-100 bg-emerald-50/50' : 'border-gray-100' }} flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $event->checked_out_at ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                        <h4 class="text-xs font-black {{ $event->checked_out_at ? 'text-emerald-700' : 'text-gray-400' }} uppercase tracking-widest">Event Completed</h4>
                    </div>
                    <div class="p-5 text-center">
                        @if($event->checked_out_at)
                            <p class="text-lg font-black text-emerald-700">{{ $event->checked_out_at->format('M d, Y') }}</p>
                            <p class="text-sm font-bold text-emerald-500">{{ $event->checked_out_at->format('h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-300 font-bold italic">Pending</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Operations Panel ── --}}
            @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && !in_array($event->status, ['approved', 'cancelled'])))
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Operations Panel</h4>
                </div>
                <div class="p-5" x-data="{ status: '{{ $event->status }}' }">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest block mb-2">Override Status</label>
                    <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-3">
                        @csrf @method('PATCH')
                        <select x-model="status" name="status" class="w-full border border-gray-200 rounded-xl text-sm bg-gray-50 py-2.5 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-bold transition-all">
                            @foreach(['pending','approved','rejected','cancelled'] as $s)
                                <option value="{{ $s }}" @selected($event->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <div x-show="status === 'cancelled'" x-transition>
                            <textarea name="cancellation_reason" rows="2" class="w-full border border-gray-200 rounded-xl text-sm bg-rose-50 py-2.5 px-4 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-400 font-bold transition-all placeholder:text-rose-300" placeholder="Reason for cancellation..."></textarea>
                        </div>
                        <button class="w-full bg-gray-900 hover:bg-indigo-600 text-white py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                            Apply Status
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-wrap gap-3 pb-2">
                <a href="{{ route('admin.events.edit', $event) }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Booking
                </a>
                @if($event->status === 'approved')
                    @php $canPrint = auth()->user()->isAdmin() || ($event->invoice_print_count == 0 || $event->invoice_reprint_status === 'approved'); @endphp
                    @if($canPrint)
                    <a href="{{ route('admin.events.invoice', $event) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print Invoice
                    </a>
                    @endif
                    <a href="{{ route('admin.events.proforma', $event) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Proforma Invoice
                    </a>
                @endif
                <a href="{{ route('admin.events.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold px-5 py-2.5 rounded-xl border border-gray-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to List
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
