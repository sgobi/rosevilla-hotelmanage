<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Reservation Terminal</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Guest Lifecycle & Occupancy Logs</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white/50 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-100" style="background: #4f46e5;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Active Database</p>
                    <p class="text-xs font-black text-gray-900 tabular-nums">v4.2.0-STABLE</p>
                </div>
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
                    <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">All reservations</h3>
                    
                    <form method="GET" action="{{ route('admin.reservations.index') }}" class="flex flex-wrap items-center gap-3">
                        {{-- Search Input --}}
                        <div class="relative min-w-[200px]">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guest, email, phone..." 
                                   class="pl-9 pr-4 py-2 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full placeholder:text-gray-400">
                        </div>

                        {{-- Status Filter --}}
                        <select name="status" onchange="this.form.submit()" 
                                class="border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white pr-8">
                            <option value="">All Statuses</option>
                            @foreach(['pending', 'approved', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>

                        @if(request()->anyFilled(['search', 'status', 'sort']))
                            <a href="{{ route('admin.reservations.index') }}" class="text-[10px] text-rose-500 font-bold uppercase tracking-widest hover:text-rose-600 transition">Clear Filters</a>
                        @endif

                        <button type="submit" class="hidden">Search</button>
                    </form>
                </div>
                <div class="overflow-x-auto">
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
                                <th class="px-6 py-3">{!! sortLink('guest_name', 'Guest', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('check_in', 'Dates', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('guests', 'Guests', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">Room</th>
                                <th class="px-6 py-3">{!! sortLink('final_price', 'Total', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! sortLink('status', 'Status', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reservations as $reservation)
                                @php
                                    $hasPendingRequest = $reservation->status_update_requested || 
                                                         ($reservation->discount_status === 'pending' && auth()->user()->isAdmin()) || 
                                                         ($reservation->invoice_reprint_status === 'requested');
                                @endphp
                                <tr id="reservation-{{ $reservation->id }}" 
                                    class="scroll-mt-20 transition-all border-l-4 {{ $hasPendingRequest ? 'border-amber-400 bg-amber-50/30' : 'border-transparent hover:bg-gray-50' }} hover:relative hover:z-[60]" 
                                    :class="editing ? 'bg-indigo-50/20 relative z-50' : ''"
                                    x-data="{ editing: false }">
                                    <td class="px-6 py-3" x-data="{ showNotes: false }">
                                        <div class="relative" @mouseenter="showNotes = true" @mouseleave="showNotes = false">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-800 leading-tight">{{ $reservation->guest_name }}</p>
                                                    <p class="text-gray-500 text-xs mt-0.5 whitespace-nowrap overflow-hidden text-overflow-ellipsis">{{ $reservation->email }}</p>
                                                    @if($reservation->phone)
                                                        <p class="text-gray-400 text-[10px] mt-0.5">{{ $reservation->phone }}</p>
                                                    @endif
                                                </div>
                                                
                                                @if($reservation->special_requirements || $reservation->additional_notes || $reservation->message)
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
                                            @if($reservation->special_requirements || $reservation->additional_notes || $reservation->message)
                                                <div x-show="showNotes" x-cloak
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                     class="absolute left-0 {{ $loop->remaining < 2 ? 'bottom-full mb-2' : 'top-full mt-2' }} w-80 bg-gray-900 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-2xl p-6 z-[100] border border-white/10 pointer-events-none ring-1 ring-black ring-opacity-5"
                                                     style="display: none;">
                                                    
                                                    <div class="space-y-6">
                                                        {{-- Special Requirements Section --}}
                                                        <div>
                                                            <div class="flex items-center gap-2 mb-2 text-indigo-400">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <span class="text-[10px] font-black uppercase tracking-widest leading-none">Special Requirements</span>
                                                            </div>
                                                            @if($reservation->special_requirements)
                                                                <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-indigo-500/30 pl-3">"{{ $reservation->special_requirements }}"</p>
                                                            @else
                                                                <p class="text-[10px] text-gray-500 italic pl-3">Not specified</p>
                                                            @endif
                                                        </div>

                                                        {{-- Additional Requests & Notes Section --}}
                                                        <div class="pt-4 border-t border-white/5">
                                                            <div class="flex items-center gap-2 mb-2 text-rose-400">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                                <span class="text-[10px] font-black uppercase tracking-widest leading-none">Additional Requests & Notes</span>
                                                            </div>
                                                            @if($reservation->additional_notes)
                                                                <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-rose-500/30 pl-3">"{{ $reservation->additional_notes }}"</p>
                                                            @elseif(!$reservation->special_requirements && $reservation->message)
                                                                <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-amber-500/30 pl-3">"{{ $reservation->message }}"</p>
                                                            @else
                                                                <p class="text-[10px] text-gray-500 italic pl-3">No additional notes</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">
                                        {{ optional($reservation->check_in)->format('M d, Y') }} – {{ optional($reservation->check_out)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->guests }}</td>
                                    <td class="px-6 py-3 text-gray-700">{{ $reservation->room->title ?? 'Any' }}</td>
                                    <td class="px-6 py-3">
                                        <div x-data="{ show: false }" class="relative">
                                            <div @mouseenter="show = true" @mouseleave="show = false" class="cursor-help inline-block">
                                                <div class="font-bold text-gray-900">LKR {{ number_format($reservation->final_price, 2) }}</div>
                                                @if($reservation->discount_status === 'approved' && $reservation->discount_percentage > 0)
                                                    <div class="text-[9px] text-emerald-600 font-medium italic">-{{ $reservation->discount_percentage }}% Off applied</div>
                                                @endif
                                            </div>

                                             <!-- Tooltip Popover -->
                                            <div x-show="show" x-cloak
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 {{ $loop->remaining < 2 ? 'translate-y-1' : 'translate-y-1' }}"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 translate-y-0"
                                                 x-transition:leave-end="opacity-0 translate-y-1"
                                                 class="absolute z-[100] {{ $loop->remaining < 2 ? 'bottom-full' : 'top-full' }} right-0 {{ $loop->remaining < 2 ? 'mb-3' : 'mt-3' }} w-72 bg-gray-900/95 backdrop-blur-md text-white rounded-2xl p-5 shadow-2xl ring-1 ring-white/10 pointer-events-none"
                                                 style="display: none;">
                                                
                                                <div class="space-y-3 text-xs">
                                                    <div class="flex justify-between border-b border-white/10 pb-2.5 mb-2.5">
                                                        <span class="text-gray-400 uppercase tracking-widest font-black text-[9px]">Billing Summary</span>
                                                        <span class="font-bold text-indigo-300">#{{ $reservation->id }}</span>
                                                    </div>
                                                    
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-gray-400">Guest Name</span>
                                                        <span class="font-bold">{{ $reservation->guest_name }}</span>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-4 py-2 border-y border-white/5 my-1">
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Duration</div>
                                                            <div class="font-medium text-white">{{ ($reservation->check_in && $reservation->check_out) ? $reservation->check_in->diffInDays($reservation->check_out) ?: 1 : 1 }} Night(s)</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Occupancy</div>
                                                            <div class="font-medium text-white">{{ $reservation->guests }} Guest(s)</div>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1.5 pt-1">
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-400">Room Subtotal</span>
                                                            <span class="font-medium text-white">LKR {{ number_format($reservation->total_price, 2) }}</span>
                                                        </div>
                                                        
                                                        @if($reservation->discount_amount > 0)
                                                            <div class="flex justify-between text-emerald-400">
                                                                <span>Discount ({{ number_format($reservation->discount_percentage, 1) }}%)</span>
                                                                <span>- LKR {{ number_format($reservation->discount_amount, 2) }}</span>
                                                            </div>
                                                        @endif

                                                        <div class="flex justify-between text-gray-400">
                                                            <span>Service Tax ({{ number_format($reservation->tax_percentage, 1) }}%)</span>
                                                            <span>+ LKR {{ number_format($reservation->tax_amount, 2) }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-between border-t border-white/20 pt-3 mt-3 items-end">
                                                        <div>
                                                            <div class="text-[9px] text-gray-400 uppercase font-black tracking-widest">Grand Total</div>
                                                            <div class="text-xs text-gray-500 italic">Net amount payable</div>
                                                        </div>
                                                        <div class="text-right">
                                                            <div class="text-lg font-black text-amber-400 leading-none">LKR {{ number_format($reservation->final_price, 2) }}</div>
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
                                    <td class="px-6 py-3 text-center">
                                        <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase shadow-sm border
                                            @if($reservation->status === 'approved') bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($reservation->status === 'cancelled') bg-rose-50 text-rose-700 border-rose-100
                                            @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                            {{ $reservation->status }}
                                        </span>
                                        @if($reservation->checked_in_at && !$reservation->checked_out_at)
                                            <div class="mt-1 flex items-center justify-center gap-1">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-tighter">In House</span>
                                            </div>
                                        @elseif($reservation->checked_out_at)
                                            <div class="mt-1 flex items-center justify-center gap-1 opacity-60">
                                                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                <span class="text-[9px] font-bold text-gray-500 uppercase tracking-tighter">Checked Out</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end gap-2 relative">
                                            <!-- Status & Main Actions -->
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col items-end">
                                                    @if($hasPendingRequest)
                                                        <span class="flex items-center gap-1 text-[9px] text-amber-600 font-bold mt-1 bg-amber-100 px-1.5 py-0.5 rounded border border-amber-200 animate-pulse">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            Action Required
                                                        </span>
                                                    @endif
                                                    @if($reservation->discount_status === 'approved')
                                                        <span class="text-[9px] text-emerald-600 font-bold mt-1 bg-emerald-50 px-1.5 rounded">
                                                            {{ $reservation->discount_percentage }}% OFF
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-gray-200 shadow-sm relative z-10">
                                                    @if($reservation->status === 'approved')
                                                        @php
                                                            $canPrint = false;
                                                            $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant();
                                                            $isStaff = auth()->user()->isStaff();
                                                            if ($isAdmin) $canPrint = true;
                                                            elseif ($isStaff) {
                                                                if ($reservation->invoice_print_count === 0 || $reservation->invoice_reprint_status === 'approved') $canPrint = true;
                                                            }
                                                        @endphp
                                                        @if($canPrint)
                                                            <a href="{{ route('admin.invoices.show', $reservation) }}" target="_blank" 
                                                               class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Download Invoice">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant() || auth()->user()->isStaff())
                                                        <button @click="editing = !editing" 
                                                                :class="editing ? 'text-indigo-600 bg-indigo-50' : 'text-gray-400 hover:text-indigo-600 hover:bg-indigo-50'"
                                                                class="p-2 rounded-lg transition-all" title="Manage Details">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Unified Edit Form (Experimental / User Friendly) -->
                                            <div x-show="editing" x-cloak @click.away="editing = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                 class="bg-white border border-gray-200 rounded-2xl p-5 shadow-2xl text-left w-80 absolute right-0 mt-14 z-[100] ring-1 ring-black ring-opacity-5">
                                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-3">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-gray-900">Manage Reservation</h4>
                                                        <p class="text-[10px] text-gray-500 mt-0.5">Quickly update status or discount</p>
                                                    </div>
                                                    <button @click="editing = false" class="text-gray-400 hover:text-gray-600 bg-gray-50 p-1 rounded-md transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <div class="space-y-5">
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 tracking-widest">Update Status</label>
                                                        
                                                        @if($reservation->status_update_requested)
                                                            <div class="bg-amber-50 rounded-xl p-3 border border-amber-100 mb-3 shadow-sm">
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <div class="p-1 bg-amber-100 text-amber-600 rounded-lg">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wide">Status Change Requested</p>
                                                                        <p class="text-[10px] text-amber-600">to {{ ucfirst($reservation->status_update_requested) }}</p>
                                                                    </div>
                                                                </div>

                                                                @if(auth()->user()->isAdmin())
                                                                    <div class="flex gap-2">
                                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                            @csrf @method('PUT')
                                                                            <input type="hidden" name="status_change_action" value="approve">
                                                                            <button class="w-full bg-indigo-600 text-white py-1.5 rounded-lg text-[10px] font-bold hover:bg-indigo-700 transition shadow-sm">Approve</button>
                                                                        </form>
                                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                            @csrf @method('PUT')
                                                                            <input type="hidden" name="status_change_action" value="reject">
                                                                            <button class="w-full bg-white text-rose-500 border border-rose-100 py-1.5 rounded-lg text-[10px] font-bold hover:bg-rose-50 transition">Reject</button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    <div class="text-[10px] text-amber-600 font-medium italic bg-amber-100/50 p-2 rounded-lg text-center">
                                                                        Waiting for Admin approval...
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @elseif(auth()->user()->isStaff() && $reservation->status === 'approved')
                                                             <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex flex-col gap-2">
                                                                @csrf @method('PUT')
                                                                <div class="flex gap-2">
                                                                    <select name="request_status_change" class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                                        @foreach(['pending','cancelled'] as $status)
                                                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button class="bg-indigo-600 text-white px-3 py-2 rounded-xl text-[10px] font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100 whitespace-nowrap">Request</button>
                                                                </div>
                                                                <p class="text-[9px] text-gray-400 italic">This change requires admin approval.</p>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex gap-2">
                                                                @csrf @method('PUT')
                                                                <select name="status" class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                                    @foreach(['pending','approved','cancelled'] as $status)
                                                                        <option value="{{ $status }}" @selected($reservation->status === $status)>{{ ucfirst($status) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-100">Set</button>
                                                            </form>
                                                        @endif
                                                    </div>





                                                    @php $isAdmin = auth()->user()->isAdmin() || auth()->user()->isAccountant(); @endphp
                                                    @if(($isAdmin || $reservation->status === 'pending') && $reservation->status !== 'cancelled')
                                                        {{-- Discount Management --}}
                                                    <div class="mb-5">
                                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">Discount Management</label>

                                                        @if($reservation->discount_percentage > 0)
                                                            <div class="mb-3">
                                                                @if($reservation->discount_status === 'approved')
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                        Approved
                                                                    </span>
                                                                @elseif($reservation->discount_status === 'rejected')
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

                                                                @if($reservation->discount_status === 'pending' && $isAdmin)
                                                                    <div class="mt-2 flex gap-2 relative z-10">
                                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                            @csrf @method('PUT')
                                                                            <input type="hidden" name="discount_action" value="approve">
                                                                            <button class="w-full bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 uppercase transition-colors shadow-sm shadow-indigo-200 flex items-center justify-center gap-1">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                Approve
                                                                            </button>
                                                                        </form>
                                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                            @csrf @method('PUT')
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

                                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex gap-2 items-center">
                                                            @csrf @method('PUT')
                                                            <div class="relative flex-1 group">
                                                                <input type="number" name="discount_percentage" min="0" max="100" value="{{ $reservation->discount_percentage }}" class="w-full border-gray-200 rounded-xl text-xs bg-gray-50 focus:bg-white pl-3 pr-8 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-gray-700" placeholder="0">
                                                                <span class="absolute right-3 top-2.5 text-xs font-bold text-gray-400 group-hover:text-indigo-400 transition-colors">%</span>
                                                            </div>
                                                            <button class="bg-indigo-600 text-white border border-transparent px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-200">
                                                                {{ $isAdmin ? 'Set' : 'Suggest' }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @endif

                                                    {{-- Reprint Control --}}
                                                    @if($reservation->status === 'approved')
                                                        <div class="pt-5 border-t border-gray-100 mt-5">
                                                            <label class="block text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">Invoice Printing</label>
                                                            
                                                            @if($reservation->invoice_reprint_status === 'requested')
                                                                <div class="bg-orange-50 rounded-xl p-3 border border-orange-100 shadow-sm relative overflow-hidden">
                                                                    <div class="flex items-center gap-2 mb-3">
                                                                        <div class="p-1.5 bg-orange-100 text-orange-600 rounded-lg">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                        </div>
                                                                        <p class="text-xs font-bold text-orange-800 uppercase tracking-wide">Reprint Requested</p>
                                                                    </div>

                                                                    @if(auth()->user()->isAdmin())
                                                                        <div class="flex gap-2">
                                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                                @csrf @method('PUT')
                                                                                <input type="hidden" name="reprint_action" value="approve">
                                                                                <button class="w-full bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm shadow-indigo-200 flex items-center justify-center gap-1">
                                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                                    Approve
                                                                                </button>
                                                                            </form>
                                                                            <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}" class="flex-1">
                                                                                @csrf @method('PUT')
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
                                                            @elseif($reservation->invoice_print_count > 0 && $reservation->invoice_reprint_status !== 'approved' && !auth()->user()->isAdmin())
                                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <input type="hidden" name="reprint_action" value="request">
                                                                    <button type="submit" class="w-full bg-gray-50 text-gray-600 border border-gray-200 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center gap-2 group">
                                                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                        Request Reprint
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant() || $reservation->status === 'pending')
                                                        <div class="pt-5 border-t border-rose-100 mt-5">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <label class="block text-[10px] font-bold text-rose-500 uppercase tracking-widest">Danger Zone</label>
                                                                <span class="text-[9px] text-rose-400 italic">Auth Required</span>
                                                            </div>
                                                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="space-y-3">
                                                                @csrf @method('DELETE')
                                                                <div class="relative">
                                                                    <input type="password" name="password" required placeholder="Enter password to delete" 
                                                                           class="w-full border-gray-200 rounded-xl text-xs bg-rose-50/30 pr-10 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 placeholder-rose-300">
                                                                    <div class="absolute right-3 top-2.5 text-rose-400/50">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                                    </div>
                                                                </div>
                                                                @error('password')
                                                                    <p class="text-[9px] text-rose-600 font-bold mt-1 px-1">{{ $message }}</p>
                                                                @enderror
                                                                <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-xl text-[10px] font-bold hover:bg-rose-700 transition shadow-md shadow-rose-200 flex items-center justify-center gap-2">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    Permanently Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
