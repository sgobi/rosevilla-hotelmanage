<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Event Management Terminal</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Social Gatherings & Corporate Logistics</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.calendar') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-100 group-hover:rotate-6 transition-transform" style="background: #4f46e5;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1 text-left">Planning</p>
                        <p class="text-xs font-black text-gray-900 uppercase">View Calendar</p>
                    </div>
                </a>
                <a href="{{ route('admin.events.create') }}" class="group bg-gray-900 px-5 py-2.5 rounded-2xl border border-gray-800 shadow-sm transition-all hover:bg-black hover:shadow-xl flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-900/20 group-hover:rotate-6 transition-transform" style="background: #10b981;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-1 text-left">New Entry</p>
                        <p class="text-xs font-black text-white uppercase">Register Event</p>
                    </div>
                </a>
            </div>
        </div>
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
                    <h3 class="text-lg font-semibold text-gray-800">All Event Bookings</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Event Details</th>
                                <th class="px-6 py-3">Date & Time</th>
                                <th class="px-6 py-3">Guests</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                                <tr id="event-{{ $booking->id }}" 
                                    class="transition-colors hover:bg-gray-50 scroll-mt-20 hover:relative hover:z-[60]" 
                                    :class="editing ? 'bg-gray-50 relative z-50' : ''"
                                    x-data="{ editing: false }">
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $booking->customer_email }} • {{ $booking->customer_phone }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-wider">
                                            {{ $booking->event_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <div class="font-medium">{{ $booking->event_date->format('M d, Y') }}</div>
                                        @php
                                            $startTime = \Carbon\Carbon::parse($booking->start_time);
                                            $endTime = \Carbon\Carbon::parse($booking->end_time);
                                            $isNextDay = $endTime->lt($startTime);
                                        @endphp
                                        <div class="text-xs text-gray-500">
                                            {{ $startTime->format('h:i A') }} - {{ $endTime->format('h:i A') }}
                                            @if($isNextDay)
                                                <div class="text-[10px] text-rose-600 font-bold mt-0.5">
                                                    Dep: {{ $booking->event_date->copy()->addDay()->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $booking->guests }}</td>
                                    <td class="px-6 py-4">
                                        <div x-data="{ show: false }" class="relative">
                                            <div @mouseenter="show = true" @mouseleave="show = false" class="cursor-help inline-block">
                                                <div class="font-bold text-gray-900">LKR {{ number_format($booking->final_price, 2) }}</div>
                                                @if($booking->discount_status === 'approved' && $booking->discount_percentage > 0)
                                                    <div class="text-[9px] text-emerald-600 font-medium italic">-{{ $booking->discount_percentage }}% Off applied</div>
                                                @endif
                                            </div>

                                             <!-- Tooltip Popover -->
                                            <div x-show="show" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 translate-y-1"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 translate-y-0"
                                                 x-transition:leave-end="opacity-0 translate-y-1"
                                                 class="absolute z-[100] {{ $loop->remaining < 2 ? 'bottom-full' : 'top-full' }} right-0 {{ $loop->remaining < 2 ? 'mb-3' : 'mt-3' }} w-72 bg-gray-900 text-white rounded-2xl p-5 shadow-2xl ring-1 ring-white/10 pointer-events-none"
                                                 style="display: none;">
                                                
                                                <div class="space-y-3 text-xs">
                                                    <div class="flex justify-between border-b border-white/10 pb-2.5 mb-2.5">
                                                        <span class="text-gray-400 uppercase tracking-widest font-black text-[9px]">Event Summary</span>
                                                        <span class="font-bold text-indigo-300">#{{ $booking->id }}</span>
                                                    </div>
                                                    
                                                    <div class="flex justify-between items-center text-gray-400">
                                                        <span>Customer</span>
                                                        <span class="font-bold text-white">{{ $booking->customer_name }}</span>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-4 py-2 border-y border-white/5 my-1">
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Date & Time</div>
                                                            @php
                                                                $tooltipStart = \Carbon\Carbon::parse($booking->start_time);
                                                                $tooltipEnd = \Carbon\Carbon::parse($booking->end_time);
                                                                $tooltipNext = $tooltipEnd->lt($tooltipStart);
                                                            @endphp
                                                            <div class="font-medium text-white">{{ $booking->event_date->format('M d, Y') }}</div>
                                                            <div class="text-[10px] text-gray-400 mt-0.5">
                                                                <div class="flex justify-between">
                                                                    <span>Start:</span>
                                                                    <span>{{ $tooltipStart->format('h:i A') }}</span>
                                                                </div>
                                                                <div class="flex justify-between {{ $tooltipNext ? 'text-rose-300 font-bold' : '' }}">
                                                                    <span>End:</span>
                                                                    <span>
                                                                        {{ $tooltipEnd->format('h:i A') }}
                                                                        @if($tooltipNext)
                                                                            <span class="block text-[9px] opacity-75">{{ $booking->event_date->copy()->addDay()->format('M d') }}</span>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Guests</div>
                                                            <div class="font-medium text-white">{{ $booking->guests }} Person(s)</div>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1.5 pt-1">
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-400">Base Price</span>
                                                            <span class="font-medium text-white">LKR {{ number_format($booking->total_price, 2) }}</span>
                                                        </div>
                                                        
                                                        @if($booking->discount_amount > 0)
                                                            <div class="flex justify-between text-emerald-400">
                                                                <span>Discount ({{ number_format($booking->discount_percentage, 1) }}%)</span>
                                                                <span>- LKR {{ number_format($booking->discount_amount, 2) }}</span>
                                                            </div>
                                                        @endif

                                                        <div class="flex justify-between text-gray-400">
                                                            <span>Tax ({{ number_format($booking->tax_percentage, 1) }}%)</span>
                                                            <span>+ LKR {{ number_format($booking->tax_amount, 2) }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-between border-t border-white/20 pt-3 mt-3 items-end">
                                                        <div>
                                                            <div class="text-[9px] text-gray-400 uppercase font-black tracking-widest">Grand Total</div>
                                                            <div class="text-xs text-gray-500 italic">Net revenue</div>
                                                        </div>
                                                        <div class="text-right">
                                                            <div class="text-lg font-black text-amber-400 leading-none">LKR {{ number_format($booking->final_price, 2) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Arrow -->
                                                @if($loop->remaining < 2)
                                                    <div class="absolute -bottom-1.5 right-12 w-3 h-3 bg-gray-900/95 rotate-45 border-r border-b border-white/10"></div>
                                                @else
                                                    <div class="absolute -top-1.5 right-12 w-3 h-3 bg-gray-900/95 rotate-45 border-l border-t border-white/10"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="px-3 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase shadow-sm border inline-block w-max
                                                @if($booking->conflict_status === 'requested') bg-rose-50 text-rose-700 border-rose-100
                                                @elseif($booking->status === 'approved') bg-emerald-50 text-emerald-700 border-emerald-100
                                                @elseif($booking->status === 'cancelled' || $booking->status === 'rejected') bg-rose-50 text-rose-700 border-rose-100
                                                @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                                @if($booking->conflict_status === 'requested')
                                                    Conflict Pending
                                                @else
                                                    {{ $booking->status }}
                                                @endif
                                            </span>
                                            @if($booking->discount_status === 'approved' && $booking->discount_percentage > 0)
                                                <span class="text-[9px] text-emerald-600 font-bold mt-1 bg-emerald-50 px-1.5 rounded w-max">
                                                    {{ $booking->discount_percentage }}% OFF
                                                </span>
                                            @elseif($booking->discount_status === 'pending')
                                                <span class="text-[9px] text-amber-600 font-bold mt-1 bg-amber-50 px-1.5 rounded w-max uppercase italic">
                                                    {{ $booking->discount_percentage }}% Pending
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end items-center gap-3">
                                            {{-- Invoice & Management --}}
                                            <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-gray-200 shadow-sm relative">
                                                @if($booking->status === 'approved')
                                                    @php
                                                        $canPrint = auth()->user()->isAdmin() || 
                                                                   ($booking->invoice_print_count == 0 || $booking->invoice_reprint_status === 'approved');
                                                    @endphp

                                                    @if($canPrint)
                                                        <a href="{{ route('admin.events.invoice', $booking) }}" target="_blank" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Print Invoice">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                        </a>
                                                    @endif
                                                @endif

                                                <button @click="editing = !editing" 
                                                        :class="editing ? 'text-indigo-600 bg-indigo-50' : 'text-gray-400 hover:text-indigo-600 hover:bg-indigo-50'"
                                                        class="p-2 rounded-lg transition-all" title="Manage Booking">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                </button>

                                                {{-- Management Modal --}}
                                                <div x-show="editing" @click.away="editing = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                     class="bg-white border border-gray-200 rounded-2xl p-6 shadow-2xl text-left w-96 absolute right-0 top-full mt-2 z-[1000] ring-1 ring-black ring-opacity-5 max-h-[80vh] overflow-y-auto" style="display: none;">
                                                    <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-3">
                                                        <div>
                                                            <h4 class="text-sm font-bold text-gray-900">Manage Event</h4>
                                                            <p class="text-[10px] text-gray-500 mt-0.5">Update status or discounts</p>
                                                        </div>
                                                        <button @click="editing = false" class="text-gray-400 hover:text-gray-600 bg-gray-50 p-1 rounded-md transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>

                                                    <div class="space-y-5">
                                                        {{-- Admin Status Update --}}
                                                        @if((auth()->user()->isAdmin() || (auth()->user()->isStaff() && !in_array($booking->status, ['approved', 'cancelled']))) && $booking->conflict_status !== 'requested')
                                                                <div x-data="{ status: '{{ $booking->status }}' }">
                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 tracking-widest">Update Status</label>
                                                                    <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex flex-col gap-2">
                                                                        @csrf @method('PATCH')
                                                                        <div class="flex gap-2">
                                                                            <select x-model="status" name="status" class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                                                @foreach(['pending','approved','rejected','cancelled'] as $status)
                                                                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Set</button>
                                                                        </div>
                                                                        <div x-show="status === 'cancelled'" x-transition class="mt-2">
                                                                            <textarea name="cancellation_reason" rows="2" class="w-full border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 bg-rose-50 placeholder-rose-300" placeholder="Reason for cancellation (optional)..."></textarea>
                                                                        </div>
                                                                    </form>
                                                                    @if($booking->status === 'cancelled' && $booking->cancellation_reason)
                                                                        <div class="mt-2 p-2 bg-rose-50 border border-rose-100 rounded-lg">
                                                                            <p class="text-[9px] text-rose-800 font-bold uppercase mb-1">Cancellation Reason:</p>
                                                                            <p class="text-[10px] text-rose-600 italic">"{{ $booking->cancellation_reason }}"</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                        @endif

                                                        {{-- Conflict Management --}}
                                                        @if($booking->conflict_status !== 'none' && $booking->status !== 'cancelled')
                                                            <div class="mb-5 pb-5 border-b border-gray-100">
                                                                <label class="block text-xs font-bold text-rose-500 uppercase mb-3 tracking-wider flex items-center gap-2">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                    Conflict Management
                                                                </label>

                                                                @if($booking->conflict_status === 'requested')
                                                                    <div class="bg-rose-50 rounded-xl p-3 mb-3 border border-rose-100">
                                                                        <p class="text-xs text-rose-800 font-bold mb-2">Overbooking Requested</p>
                                                                        @if(auth()->user()->isAdmin())
                                                                            <form method="POST" action="{{ route('admin.events.update', $booking) }}">
                                                                                @csrf @method('PATCH')
                                                                                <textarea name="conflict_note" rows="2" class="w-full border-rose-200 rounded-lg text-xs mb-2 focus:ring-rose-500 focus:border-rose-500 bg-white" placeholder="Add a note (optional)..."></textarea>
                                                                                <div class="flex gap-2">
                                                                                    <button type="submit" name="conflict_action" value="approve" class="flex-1 bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm">Approve Override</button>
                                                                                    <button type="submit" name="conflict_action" value="reject" class="flex-1 bg-white text-rose-500 border border-rose-200 py-2 rounded-lg text-xs font-bold hover:bg-rose-50 transition">Reject</button>
                                                                                </div>
                                                                            </form>
                                                                        @else
                                                                            <span class="text-[10px] uppercase font-bold text-rose-400">Waiting for Admin</span>
                                                                        @endif
                                                                    </div>
                                                                @elseif($booking->conflict_status === 'approved')
                                                                    <div>
                                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                            Override Approved
                                                                        </span>
                                                                        @if($booking->conflict_note)
                                                                            <p class="text-[9px] text-gray-500 mt-1 italic border-l-2 border-rose-200 pl-2">
                                                                                "{{ $booking->conflict_note }}"
                                                                            </p>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        {{-- Discount Management --}}
                                                            <div class="mb-5">
                                                                <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">Discount Management</label>

                                                                @if($booking->discount_percentage > 0)
                                                                    <div class="mb-3">
                                                                        @if($booking->discount_status === 'approved')
                                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                Approved
                                                                            </span>
                                                                        @elseif($booking->discount_status === 'rejected')
                                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                                Rejected
                                                                            </span>
                                                                        @else
                                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                                Pending Approval
                                                                            </span>
                                                                        @endif

                                                                        @if($booking->discount_status === 'pending' && auth()->user()->isAdmin())
                                                                            <div class="mt-2 flex gap-2 relative z-10">
                                                                                <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="discount_action" value="approve">
                                                                                    <button class="w-full bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 uppercase transition-colors shadow-sm shadow-indigo-200 flex items-center justify-center gap-1">
                                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                        Approve
                                                                                    </button>
                                                                                </form>
                                                                                <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="discount_action" value="reject">
                                                                                    <button class="w-full bg-white text-rose-500 border border-rose-100 py-2 rounded-lg text-xs font-bold hover:bg-rose-50 uppercase transition-colors flex items-center justify-center gap-1">
                                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                                        Reject
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                                @if($booking->status === 'pending')
                                                                    <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex flex-col gap-3">
                                                                        @csrf @method('PATCH')
                                                                        <div class="relative w-full group">
                                                                            <input type="number" name="discount_percentage" min="0" max="100" value="{{ $booking->discount_percentage }}" class="w-full border-gray-300 rounded-xl text-sm bg-white focus:bg-white pl-3 pr-8 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-900 shadow-sm" placeholder="Enter %">
                                                                            <span class="absolute right-3 top-2.5 text-xs font-bold text-gray-500 pointer-events-none">%</span>
                                                                        </div>
                                                                        
                                                                        @if($booking->discount_amount > 0)
                                                                            <div class="bg-emerald-50 rounded-lg p-2 text-center border border-emerald-100">
                                                                                <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Discount Amount</p>
                                                                                <p class="text-sm text-emerald-700 font-bold">{{ number_format($booking->discount_amount, 2) }}</p>
                                                                            </div>
                                                                        @endif

                                                                        <button class="w-full bg-indigo-600 text-white border border-transparent px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200">
                                                                            {{ auth()->user()->isAdmin() ? 'Set Discount' : 'Suggest Discount' }}
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>

                                                        {{-- Reprint Control --}}
                                                        @if($booking->status === 'approved')
                                                            <div class="pt-5 border-t border-gray-100">
                                                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-widest">Invoice Printing</label>
                                                                
                                                                @if($booking->invoice_reprint_status === 'requested')
                                                                    <div class="bg-orange-50 rounded-xl p-3 border border-orange-100 shadow-sm relative overflow-hidden">
                                                                        <div class="flex items-center gap-2 mb-3">
                                                                            <div class="p-1.5 bg-orange-100 text-orange-600 rounded-lg">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                            </div>
                                                                            <p class="text-xs font-bold text-orange-800 uppercase tracking-wide">Reprint Requested</p>
                                                                        </div>

                                                                        @if(auth()->user()->isAdmin())
                                                                            <div class="flex gap-2">
                                                                                <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="reprint_action" value="approve">
                                                                                    <button class="w-full bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm shadow-indigo-200 flex items-center justify-center gap-1">
                                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                        Approve
                                                                                    </button>
                                                                                </form>
                                                                                <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                    @csrf @method('PATCH')
                                                                                    <input type="hidden" name="reprint_action" value="reject">
                                                                                    <button class="w-full bg-white text-rose-500 border border-rose-100 py-2 rounded-lg text-xs font-bold hover:bg-rose-50 transition flex items-center justify-center gap-1">
                                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                                        Reject
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <div class="text-xs text-orange-600 font-medium italic bg-orange-100/50 p-2 rounded-lg text-center">
                                                                                Waiting for Admin approval...
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    @elseif($booking->invoice_print_count > 0 && $booking->invoice_reprint_status !== 'approved' && !auth()->user()->isAdmin())
                                                                        <form action="{{ route('admin.events.update', $booking) }}" method="POST">
                                                                            @csrf @method('PATCH')
                                                                            <input type="hidden" name="reprint_action" value="request">
                                                                            <button type="submit" class="w-full bg-gray-50 text-gray-600 border border-gray-200 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center gap-2 group">
                                                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                                Request Reprint
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('admin.events.edit', $booking) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Info">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                
                                                <div x-data="{ showDelete: false }" class="relative">
                                                    <button @click="showDelete = !showDelete" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Delete">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>

                                                    <div x-show="showDelete" x-cloak @click.away="showDelete = false" 
                                                         class="absolute right-0 bottom-full mb-2 w-72 bg-white border border-rose-100 rounded-2xl p-6 shadow-2xl z-[100] ring-1 ring-black ring-opacity-5">
                                                        <div class="mb-5 border-b border-rose-50 pb-3">
                                                            <h4 class="text-[10px] font-black text-rose-600 uppercase tracking-widest leading-none">Management Terminal</h4>
                                                            <p class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-1">Advanced Data Controls</p>
                                                        </div>

                                                        {{-- Operational Reset --}}
                                                        @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                                                            <form action="{{ route('admin.event-front-desk.reset', $booking) }}" method="POST" class="mb-6 pb-6 border-b border-rose-50">
                                                                @csrf
                                                                <div class="flex flex-col gap-2">
                                                                    <label class="text-[9px] font-black text-rose-400 uppercase tracking-widest px-1">Safe Reset (In/Out/Pay)</label>
                                                                    <input type="password" name="password" required placeholder="Verify Password" 
                                                                           class="w-full border-gray-100 rounded-xl text-[11px] bg-rose-50/20 py-2 focus:ring-2 focus:ring-rose-500">
                                                                    <button type="submit" onclick="return confirm('Reset all operational data (check-in/out/payments) for this event?')"
                                                                            class="w-full bg-rose-50 text-rose-600 border border-rose-100 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-rose-100 transition">
                                                                        Operational Reset
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @endif

                                                        {{-- Permanent Delete --}}
                                                        <form action="{{ route('admin.events.destroy', $booking) }}" method="POST" class="space-y-3">
                                                            @csrf @method('DELETE')
                                                            <div class="flex flex-col gap-2">
                                                                <label class="text-[9px] font-black text-rose-600 uppercase tracking-widest px-1">Permanent Destruction</label>
                                                                <input type="password" name="password" required placeholder="Verify Password" 
                                                                       class="w-full border-gray-100 rounded-xl text-[11px] bg-rose-50/20 py-2 focus:ring-2 focus:ring-rose-500">
                                                                <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-rose-700 transition shadow-md shadow-rose-200">
                                                                    Delete Record
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p>No event bookings found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
