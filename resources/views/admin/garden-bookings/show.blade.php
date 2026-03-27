<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Booking Details</h2>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mt-1 italic">Viewing information for garden booking #{{ $gardenBooking->id }}</p>
            </div>

            <a href="{{ route('admin.garden-bookings.index') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                <div class="h-8 w-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 group-hover:scale-110 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest group-hover:text-emerald-500 transition-colors">Return To</span>
                    <span class="text-xs font-bold text-gray-900">Garden Bookings</span>
                </div>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- ── Guest Info Card ── --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 flex justify-between items-start gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-200 flex items-center justify-center shrink-0">
                            <span class="text-xl font-black text-emerald-700">{{ strtoupper(substr($gardenBooking->guest_name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">{{ $gardenBooking->guest_name }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $gardenBooking->email }} &bull; {{ $gardenBooking->phone }}</p>
                            @if($gardenBooking->address)
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $gardenBooking->address }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {{-- Status Badge --}}
                    <span class="shrink-0 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border
                        @if($gardenBooking->status === 'approved') bg-green-50 text-green-700 border-green-200
                        @elseif(in_array($gardenBooking->status, ['cancelled','rejected'])) bg-red-50 text-red-700 border-red-200
                        @else bg-yellow-50 text-yellow-700 border-yellow-200 @endif">
                        {{ str_replace('_', ' ', $gardenBooking->status) }}
                    </span>
                </div>
            </div>

            {{-- ── Booking Details & Financials ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Booking Details --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Booking Details</h4>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Check In</span>
                            <span class="text-sm font-bold text-gray-800">{{ $gardenBooking->check_in->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Check Out</span>
                            <span class="text-sm font-bold text-gray-800">{{ $gardenBooking->check_out->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Duration</span>
                            <span class="text-sm font-bold text-gray-800">
                                {{ $gardenBooking->check_in->diffInDays($gardenBooking->check_out) }} {{ Str::plural('Night', $gardenBooking->check_in->diffInDays($gardenBooking->check_out)) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Guests</span>
                            <span class="text-sm font-bold text-gray-800">{{ $gardenBooking->guests }} {{ Str::plural('Guest', $gardenBooking->guests) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Financials --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest">Financials</h4>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Price</span>
                            <span class="text-sm font-bold text-gray-800">LKR {{ number_format($gardenBooking->total_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Discount <span class="normal-case font-normal">({{ number_format($gardenBooking->discount_percentage ?? 0, 1) }}%)</span></span>
                            <span class="text-sm font-bold text-rose-500">− LKR {{ number_format($gardenBooking->discount_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-dashed border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Tax <span class="normal-case font-normal">({{ number_format($gardenBooking->tax_percentage, 1) }}%)</span></span>
                            <span class="text-sm font-bold text-amber-600">+ LKR {{ number_format($gardenBooking->tax_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 mt-1 border-t-2 border-gray-200">
                            <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Final Price</span>
                            <span class="text-lg font-black text-emerald-600">LKR {{ number_format($gardenBooking->final_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Notes ── --}}
            @if($gardenBooking->special_requirements || $gardenBooking->additional_notes)
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5 space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h4 class="text-xs font-black text-indigo-800 uppercase tracking-widest">Notes</h4>
                </div>
                @if($gardenBooking->special_requirements)
                    <div>
                        <p class="text-xs font-black text-indigo-500 uppercase tracking-wide mb-1">Special Requirements</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $gardenBooking->special_requirements }}</p>
                    </div>
                @endif
                @if($gardenBooking->additional_notes)
                    <div>
                        <p class="text-xs font-black text-indigo-500 uppercase tracking-wide mb-1">Additional Notes</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $gardenBooking->additional_notes }}</p>
                    </div>
                @endif
            </div>
            @endif

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-wrap gap-3 pb-2">
                @if(auth()->user()->isAdmin() || !in_array($gardenBooking->status, ['approved', 'cancelled']))
                    <a href="{{ route('admin.garden-bookings.edit', $gardenBooking) }}"
                       class="group inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Booking
                    </a>
                @endif
                @if($gardenBooking->status === 'approved')
                    <a href="{{ route('admin.garden.invoice', $gardenBooking) }}" target="_blank"
                       class="group inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print Invoice
                    </a>
                @endif
                <a href="{{ route('admin.garden-bookings.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold px-5 py-2.5 rounded-xl border border-gray-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to List
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
