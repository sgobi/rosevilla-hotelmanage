<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Event Management Terminal</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Social Gatherings & Corporate Logistics</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.event-front-desk.index') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-100 group-hover:rotate-6 transition-transform" style="background: #f59e0b;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1 text-left">Operations</p>
                        <p class="text-xs font-black text-gray-900 uppercase">Event Desk</p>
                    </div>
                </a>
                <a href="{{ route('admin.events.calendar') }}" class="hidden lg:flex group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-100 group-hover:rotate-6 transition-transform" style="background: #4f46e5;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1 text-left">Planning</p>
                        <p class="text-xs font-black text-gray-900 uppercase">Calendar</p>
                    </div>
                </a>
                <a href="{{ route('admin.events.create') }}" class="group bg-gray-900 px-5 py-2.5 rounded-2xl border border-gray-800 shadow-sm transition-all hover:bg-black hover:shadow-xl flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-900/20 group-hover:rotate-6 transition-transform" style="background: #10b981;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-1 text-left">New Entry</p>
                        <p class="text-xs font-black text-white uppercase">Register</p>
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
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">All event bookings</h3>
                    
                    <form method="GET" action="{{ route('admin.events.index') }}" class="flex flex-wrap items-center gap-3">
                        {{-- Search Input --}}
                        <div class="relative min-w-[200px]">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer, email..." 
                                   class="pl-9 pr-4 py-2 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full placeholder:text-gray-400">
                        </div>

                        {{-- Status Filter --}}
                        <select name="status" onchange="this.form.submit()" 
                                class="border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white pr-8">
                            <option value="">All Statuses</option>
                            @foreach(['pending', 'approved', 'rejected', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>

                        @if(request()->anyFilled(['search', 'status', 'sort']))
                            <a href="{{ route('admin.events.index') }}" class="text-[10px] text-rose-500 font-bold uppercase tracking-widest hover:text-rose-600 transition">Clear Filters</a>
                        @endif

                        <button type="submit" class="hidden">Search</button>
                    </form>
                </div>
                <div class="overflow-x-auto {{ $bookings->count() < 6 ? 'min-h-[650px]' : '' }}">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50/50">
                            @php
                                $sort = request('sort', 'created_at');
                                $dir = request('direction', 'desc');
                                $nextDir = $dir === 'asc' ? 'desc' : 'asc';
                                
                                function sortLink($column, $label, $currentSort, $currentDir, $nextDir) {
                                    $icon = '';
                                    if ($currentSort === $column) {
                                        $icon = $currentDir === 'asc' 
                                            ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>'
                                            : '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                                    }
                                    
                                    $url = request()->fullUrlWithQuery(['sort' => $column, 'direction' => $nextDir]);
                                    return "<a href='{$url}' class='flex items-center gap-1 hover:text-indigo-600 transition'>
                                                {$label}
                                                <span class='text-gray-400'>{$icon}</span>
                                            </a>";
                                }
                            @endphp
                            <tr>
                                <th class="px-6 py-3">{!! sortLink('customer_name', 'Customer', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('event_type', 'Event Type', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('event_date', 'Date & Time', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('guests', 'Guests', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3 text-center">{!! sortLink('status', 'Status', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                                @php
                                    $hasPendingRequest = $booking->conflict_status === 'requested' || 
                                                         ($booking->discount_status === 'pending' && auth()->user()->isAdmin()) || 
                                                         ($booking->invoice_reprint_status === 'requested');
                                @endphp
                                <tr id="event-{{ $booking->id }}" 
                                    class="transition-all border-l-4 {{ $hasPendingRequest ? 'border-amber-400 bg-amber-50/30' : 'border-transparent hover:bg-gray-50' }} hover:relative hover:z-[60]" 
                                    :class="editing ? 'bg-gray-50 relative z-50' : ''"
                                    x-data="{ editing: false }">
                                     <td class="px-6 py-4" x-data="{ showNotes: false }">
                                         <div class="relative" @mouseenter="showNotes = true" @mouseleave="showNotes = false">
                                             <div class="flex items-start justify-between gap-4">
                                                 <div class="flex-1">
                                                     <p class="font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                                                     <p class="text-gray-500 text-xs">{{ $booking->customer_email }} • {{ $booking->customer_phone }}</p>
                                                 </div>
                                                 
                                                 @if($booking->message)
                                                     <div class="flex-shrink-0 mt-0.5">
                                                         <div class="relative flex items-center justify-center">
                                                             <span class="absolute inline-flex h-2 w-2 rounded-full bg-indigo-400 opacity-75 animate-ping"></span>
                                                             <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                                             <svg class="w-3.5 h-3.5 text-indigo-400 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                         </div>
                                                     </div>
                                                 @endif
                                             </div>

                                             {{-- Notes Popover --}}
                                             @if($booking->message)
                                                 <div x-show="showNotes" x-cloak
                                                      x-transition:enter="transition ease-out duration-200"
                                                      x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                                      x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                      class="absolute left-0 {{ ($loop->index > 2 && $loop->remaining < 3) ? 'bottom-full mb-3' : 'top-full mt-3' }} w-80 bg-gray-900 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-2xl p-6 z-[100] border border-white/10 pointer-events-none ring-1 ring-black ring-opacity-5"
                                                      style="display: none;">
                                                     
                                                     <div class="space-y-6">
                                                         <div>
                                                             <div class="flex items-center gap-2 mb-2 text-indigo-400">
                                                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                                 <span class="text-[10px] font-black uppercase tracking-widest leading-none">Customer Message</span>
                                                             </div>
                                                             <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-indigo-500/30 pl-3">"{{ $booking->message }}"</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @endif
                                         </div>
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
                                                 class="absolute z-[100] {{ ($loop->index > 2 && $loop->remaining < 3) ? 'bottom-full mb-4' : 'top-full mt-4' }} right-0 w-72 bg-gray-900 text-white rounded-2xl p-5 shadow-2xl ring-1 ring-white/10 pointer-events-none"
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
                                                @if($loop->index > 2 && $loop->remaining < 3)
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
                                                {{-- Management Terminal Modal --}}
                                                <template x-teleport="body">
                                                    <div x-show="editing" x-cloak
                                                         class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6 bg-gray-900/90 backdrop-blur-sm">
                                                        
                                                        <div @click.away="editing = false" 
                                                             class="bg-white w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-gray-100 animate-fade-in-up">
                                                            
                                                            <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                                                <div class="flex items-center gap-4">
                                                                    <div class="h-12 w-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                                    </div>
                                                                    <div>
                                                                        <h4 class="text-lg font-black text-gray-900 uppercase tracking-tight leading-none">Management Terminal</h4>
                                                                        <p class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em] mt-1.5 leading-none">Status, Financials & Conflict Control</p>
                                                                    </div>
                                                                </div>
                                                                <button @click="editing = false" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                                                                    <svg class="w-5 h-5 text-gray-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>

                                                            <div class="p-8 space-y-8 max-h-[70vh] overflow-y-auto custom-scrollbar">
                                                                {{-- Admin Status Update --}}
                                                                @if((auth()->user()->isAdmin() || (auth()->user()->isStaff() && !in_array($booking->status, ['approved', 'cancelled']))) && $booking->conflict_status !== 'requested')
                                                                        <div x-data="{ status: '{{ $booking->status }}' }" class="space-y-4">
                                                                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Override Global Status</label>
                                                                            <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="space-y-4">
                                                                                @csrf @method('PATCH')
                                                                                <div class="flex gap-3">
                                                                                    <select x-model="status" name="status" class="flex-1 border-gray-100 rounded-2xl text-[13px] bg-gray-50/50 py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold transition-all">
                                                                                        @foreach(['pending','approved','rejected','cancelled'] as $status)
                                                                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <button class="bg-indigo-600 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-indigo-100 active:scale-95 leading-none">Confirm</button>
                                                                                </div>
                                                                                <div x-show="status === 'cancelled'" x-transition class="animate-fade-in-down">
                                                                                    <textarea name="cancellation_reason" rows="2" class="w-full border-gray-100 rounded-2xl text-[13px] bg-rose-50/30 py-4 px-6 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold transition-all placeholder:text-rose-200" placeholder="State reason for cancellation..."></textarea>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                @endif

                                                                {{-- Conflict Management Section --}}
                                                                @if($booking->conflict_status !== 'none' && $booking->status !== 'cancelled')
                                                                    <div class="space-y-4 bg-rose-50/50 p-6 rounded-[2rem] border border-rose-100/50">
                                                                        <label class="text-[10px] font-black text-rose-500 uppercase tracking-widest px-1 flex items-center gap-2">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                            Collision Protocol
                                                                        </label>

                                                                        @if($booking->conflict_status === 'requested')
                                                                            <div class="space-y-4">
                                                                                <p class="text-xs font-black text-rose-800 uppercase leading-none italic">Attention: Overbooking request awaiting terminal clearance</p>
                                                                                @if(auth()->user()->isAdmin())
                                                                                    <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="space-y-4">
                                                                                        @csrf @method('PATCH')
                                                                                        <textarea name="conflict_note" rows="2" class="w-full border-gray-100 rounded-2xl text-[13px] bg-white py-4 px-6 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold transition-all placeholder:text-gray-300" placeholder="Terminal log note..."></textarea>
                                                                                        <div class="flex gap-3">
                                                                                            <button type="submit" name="conflict_action" value="approve" class="flex-1 bg-indigo-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-indigo-100 active:scale-95 leading-none">Authorize Override</button>
                                                                                            <button type="submit" name="conflict_action" value="reject" class="flex-1 bg-white text-rose-600 border-2 border-rose-100 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-50 transition-all active:scale-95 leading-none">Reject</button>
                                                                                        </div>
                                                                                    </form>
                                                                                @else
                                                                                    <div class="bg-white/50 py-4 px-6 rounded-2xl border border-rose-100 flex items-center justify-center gap-3">
                                                                                        <div class="h-2 w-2 rounded-full bg-rose-500 animate-pulse"></div>
                                                                                        <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Awaiting Admin Override</span>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @elseif($booking->conflict_status === 'approved')
                                                                            <div class="space-y-3">
                                                                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl border border-emerald-200">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                                                    <span class="text-[10px] font-black uppercase tracking-widest">Collision Cleared</span>
                                                                                </div>
                                                                                @if($booking->conflict_note)
                                                                                    <div class="bg-white/50 p-4 rounded-xl border border-emerald-100 text-[11px] font-bold text-gray-600 italic">
                                                                                        "{{ $booking->conflict_note }}"
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                                {{-- Financial Adjustments --}}
                                                                <div class="space-y-4 bg-gray-50/50 p-6 rounded-[2rem] border border-gray-100/50">
                                                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Discount Operations</label>

                                                                    @if($booking->discount_percentage > 0)
                                                                        <div class="flex items-center gap-3 mb-4">
                                                                            @if($booking->discount_status === 'approved')
                                                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-200">Authorized: {{ number_format($booking->discount_percentage, 1) }}%</span>
                                                                            @elseif($booking->discount_status === 'rejected')
                                                                                 <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-rose-200">Denied</span>
                                                                            @else
                                                                                <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-amber-200 animate-pulse">Pending Review: {{ number_format($booking->discount_percentage, 1) }}%</span>
                                                                            @endif

                                                                            @if($booking->discount_status === 'pending' && auth()->user()->isAdmin())
                                                                                <div class="flex gap-2">
                                                                                    <form method="POST" action="{{ route('admin.events.update', $booking) }}">
                                                                                        @csrf @method('PATCH')
                                                                                        <input type="hidden" name="discount_action" value="approve">
                                                                                        <button class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-black transition-all">Grant</button>
                                                                                    </form>
                                                                                    <form method="POST" action="{{ route('admin.events.update', $booking) }}">
                                                                                        @csrf @method('PATCH')
                                                                                        <input type="hidden" name="discount_action" value="reject">
                                                                                        <button class="px-3 py-1 bg-white text-rose-600 border border-rose-100 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-rose-50 transition-all">Revoke</button>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    @endif

                                                                    @if($booking->status === 'pending')
                                                                        <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="space-y-4">
                                                                            @csrf @method('PATCH')
                                                                            <div class="flex gap-3">
                                                                                <div class="relative flex-1">
                                                                                    <input type="number" name="discount_percentage" min="0" max="100" value="{{ $booking->discount_percentage }}" class="w-full border-gray-100 rounded-2xl text-[13px] bg-white py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold transition-all tabular-nums" placeholder="Percentage %">
                                                                                    <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-300 tracking-widest">%</span>
                                                                                </div>
                                                                                <button class="bg-gray-900 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all leading-none">Apply</button>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </div>

                                                                {{-- Logistics: Printer Clearances --}}
                                                                @if($booking->status === 'approved')
                                                                    <div class="space-y-4 bg-gray-900 text-white p-6 rounded-[2rem] border border-white/10">
                                                                        <label class="text-[10px] font-black text-white/30 uppercase tracking-widest px-1">Hardware Interface: Invoice Clearance</label>
                                                                        
                                                                        @if($booking->invoice_reprint_status === 'requested')
                                                                            <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                                                                                <p class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                                    Manual Reprint Request Detected
                                                                                </p>
                                                                                @if(auth()->user()->isAdmin())
                                                                                    <div class="flex gap-3">
                                                                                        <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                            @csrf @method('PATCH')
                                                                                            <input type="hidden" name="reprint_action" value="approve">
                                                                                            <button class="w-full bg-white text-gray-900 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-400 hover:text-white transition-all active:scale-95 leading-none">Authorize</button>
                                                                                        </form>
                                                                                        <form method="POST" action="{{ route('admin.events.update', $booking) }}" class="flex-1">
                                                                                            @csrf @method('PATCH')
                                                                                            <input type="hidden" name="reprint_action" value="reject">
                                                                                            <button class="w-full bg-transparent border border-white/20 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white/5 transition-all active:scale-95 leading-none">Deny</button>
                                                                                        </form>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="text-[10px] font-black text-white/40 uppercase text-center py-4 bg-white/5 rounded-xl italic">Awaiting Terminal Command from Administrator</div>
                                                                                @endif
                                                                            </div>
                                                                        @elseif($booking->invoice_print_count > 0 && $booking->invoice_reprint_status !== 'approved' && !auth()->user()->isAdmin())
                                                                            <form action="{{ route('admin.events.update', $booking) }}" method="POST">
                                                                                @csrf @method('PATCH')
                                                                                <input type="hidden" name="reprint_action" value="request">
                                                                                <button type="submit" class="w-full bg-white text-gray-900 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest hover:bg-indigo-400 hover:text-white transition-all shadow-xl active:scale-95 leading-none">Request Reprint Token</button>
                                                                            </form>
                                                                        @else
                                                                            <div class="text-[10px] font-black text-emerald-400 uppercase text-center py-4 bg-emerald-400/5 rounded-xl tracking-widest">Printer Status: Ready for Initialization</div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="bg-gray-50/50 p-6 text-center border-t border-gray-50">
                                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic leading-none">System Integrity Verified • Terminal {{ auth()->id() }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('admin.events.edit', $booking) }}" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit Info">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                
                                                <div x-data="{ open: false }" class="relative">
                                                    <button @click="open = true" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Manage Record">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
 
                                                    <template x-teleport="body">
                                                        <div x-show="open" x-cloak
                                                             class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6 bg-gray-900/90 backdrop-blur-sm">
                                                            
                                                            <div @click.away="open = false" 
                                                                 class="bg-white w-full max-w-md rounded-[2.5rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-gray-100 animate-fade-in-up">
                                                                
                                                                <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                                                    <div class="flex items-center gap-4">
                                                                        <div class="h-12 w-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                                                        </div>
                                                                        <div>
                                                                            <h4 class="text-lg font-black text-gray-900 uppercase tracking-tight leading-none">Record Operations</h4>
                                                                            <p class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] mt-1.5 leading-none">Administrative Event Control</p>
                                                                        </div>
                                                                    </div>
                                                                    <button @click="open = false" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                                                                        <svg class="w-5 h-5 text-gray-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                    </button>
                                                                </div>

                                                                <div class="p-8 space-y-8">
                                                                    {{-- Operational Reset --}}


                                                                    {{-- Permanent Delete --}}
                                                                    <form action="{{ route('admin.events.destroy', $booking) }}" method="POST" class="space-y-4">
                                                                        @csrf @method('DELETE')
                                                                        <div class="space-y-2.5">
                                                                            <label class="text-[10px] font-black text-red-600 uppercase tracking-widest px-1">Permanent Destruction</label>
                                                                            <input type="password" name="password" required placeholder="Confirm Destruction" 
                                                                                   class="w-full border-gray-100 rounded-2xl text-[13px] bg-red-50/20 py-4 px-6 focus:ring-4 focus:ring-red-100 focus:border-red-500 font-bold transition-all placeholder:text-red-200">
                                                                        </div>
                                                                        <button type="submit" 
                                                                                onclick="return confirm('CRITICAL: Permanently delete this event?')"
                                                                                class="w-full bg-red-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-100 active:scale-95 text-center leading-none">
                                                                            Delete Record Permanently
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="bg-gray-50/50 p-6 text-center">
                                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic leading-none">Verified Administrative Operation</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
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
                @if($bookings->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
