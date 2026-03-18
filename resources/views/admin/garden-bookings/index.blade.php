<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Garden Bookings</h2>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mt-1 italic">Outdoor Event Space · Guest Lifecycle Logs</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.garden.calendar') }}" class="group bg-indigo-600 px-5 py-2.5 rounded-2xl border border-indigo-500 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-white/20 text-white flex items-center justify-center shadow-lg group-hover:rotate-6 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-1 text-left">Schedule</p>
                        <p class="text-xs font-black text-white uppercase">Calendar View</p>
                    </div>
                </a>
                <a href="{{ route('admin.garden-profile.edit') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-100 group-hover:rotate-6 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1 text-left">Management</p>
                        <p class="text-xs font-black text-gray-900 uppercase">Garden Profile</p>
                    </div>
                </a>
                <div class="hidden lg:flex items-center gap-3 bg-gray-900 px-5 py-2.5 rounded-2xl border border-gray-800 shadow-sm">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-1 text-left">Terminal Status</p>
                        <p class="text-xs font-black text-white uppercase tabular-nums">Garden Ops</p>
                    </div>
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
                    <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">All Garden Bookings</h3>
                    <form method="GET" action="{{ route('admin.garden-bookings.index') }}" class="flex flex-wrap items-center gap-3">
                        <div class="relative min-w-[200px]">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guest, email, phone..."
                                   class="pl-9 pr-4 py-2 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full placeholder:text-gray-400">
                        </div>
                        <select name="status" onchange="this.form.submit()"
                                class="border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white pr-8">
                            <option value="">All Statuses</option>
                            @foreach(['pending', 'approved', 'checked_in', 'checked_out', 'rejected', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                        @if(request()->anyFilled(['search', 'status', 'sort']))
                            <a href="{{ route('admin.garden-bookings.index') }}" class="text-[10px] text-rose-500 font-bold uppercase tracking-widest hover:text-rose-600 transition">Clear Filters</a>
                        @endif
                        <button type="submit" class="hidden">Search</button>
                    </form>
                </div>

                <div class="overflow-x-auto {{ $bookings->count() < 6 ? 'min-h-[500px]' : '' }}">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs uppercase text-gray-500 bg-gray-50/50">
                            @php
                                $sort = request('sort', 'created_at');
                                $dir = request('direction', 'desc');
                                $nextDir = $dir === 'asc' ? 'desc' : 'asc';
                                function gardenSortLink($column, $label, $currentSort, $currentDir, $nextDir) {
                                    $icon = '';
                                    if ($currentSort === $column) {
                                        $icon = $currentDir === 'asc'
                                            ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>'
                                            : '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>';
                                    }
                                    $url = request()->fullUrlWithQuery(['sort' => $column, 'direction' => $nextDir]);
                                    return "<a href='{$url}' class='flex items-center gap-1 hover:text-emerald-600 transition'>{$label}<span class='text-gray-400'>{$icon}</span></a>";
                                }
                            @endphp
                            <tr>
                                <th class="px-6 py-3">{!! gardenSortLink('guest_name', 'Guest', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! gardenSortLink('check_in', 'Dates', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! gardenSortLink('guests', 'Guests', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! gardenSortLink('final_price', 'Total', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3">{!! gardenSortLink('status', 'Status', $sort, $dir, $nextDir) !!}</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                                <tr class="transition-all hover:bg-gray-50 border-l-4 border-transparent hover:border-emerald-400"
                                    x-data="{ editing: false }">

                                    {{-- Guest --}}
                                    <td class="px-6 py-3" x-data="{ showNotes: false }">
                                        <div class="relative" @mouseenter="showNotes = true" @mouseleave="showNotes = false">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-800 leading-tight">{{ $booking->guest_name }}</p>
                                                    <p class="text-gray-500 text-xs mt-0.5">{{ $booking->email }}</p>
                                                    @if($booking->phone)
                                                        <p class="text-gray-400 text-[10px] mt-0.5">{{ $booking->phone }}</p>
                                                    @endif
                                                </div>
                                                @if($booking->special_requirements || $booking->additional_notes)
                                                    <div class="flex-shrink-0 mt-0.5">
                                                        <div class="relative flex items-center justify-center">
                                                            <span class="absolute inline-flex h-2 w-2 rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                            <svg class="w-3.5 h-3.5 text-emerald-400 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($booking->special_requirements || $booking->additional_notes)
                                                <div x-show="showNotes" x-cloak
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                     class="absolute left-0 {{ ($loop->index > 3 && $loop->remaining < 3) ? 'bottom-full mb-3' : 'top-full mt-3' }} w-80 bg-gray-900 shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-2xl p-6 z-[100] border border-white/10 pointer-events-none"
                                                     style="display: none;">
                                                    <div class="space-y-4">
                                                        <div>
                                                            <div class="flex items-center gap-2 mb-2 text-emerald-400">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                <span class="text-[10px] font-black uppercase tracking-widest leading-none">Special Requirements</span>
                                                            </div>
                                                            @if($booking->special_requirements)
                                                                <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-emerald-500/30 pl-3">"{{ $booking->special_requirements }}"</p>
                                                            @else
                                                                <p class="text-[10px] text-gray-500 italic pl-3">Not specified</p>
                                                            @endif
                                                        </div>
                                                        @if($booking->additional_notes)
                                                            <div class="pt-4 border-t border-white/5">
                                                                <div class="flex items-center gap-2 mb-2 text-rose-400">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                    <span class="text-[10px] font-black uppercase tracking-widest leading-none">Additional Notes</span>
                                                                </div>
                                                                <p class="text-xs text-gray-300 leading-relaxed italic border-l-2 border-rose-500/30 pl-3">"{{ $booking->additional_notes }}"</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Dates --}}
                                    <td class="px-6 py-3 text-gray-700">
                                        {{ optional($booking->check_in)->format('M d, Y') }} – {{ optional($booking->check_out)->format('M d, Y') }}
                                        @php $days = optional($booking->check_in) && optional($booking->check_out) ? $booking->check_in->diffInDays($booking->check_out) : 0; @endphp
                                        @if($days)
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $days }} day{{ $days > 1 ? 's' : '' }}</p>
                                        @endif
                                    </td>

                                    {{-- Guests --}}
                                    <td class="px-6 py-3 text-gray-700">{{ $booking->guests }}</td>

                                    {{-- Total with billing tooltip --}}
                                    <td class="px-6 py-3">
                                        <div x-data="{ show: false }" class="relative">
                                            <div @mouseenter="show = true" @mouseleave="show = false" class="cursor-help inline-block">
                                                <div class="font-bold text-gray-900">LKR {{ number_format($booking->final_price, 2) }}</div>
                                            </div>
                                            <div x-show="show" x-cloak
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 translate-y-1"
                                                 x-transition:enter-end="opacity-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100"
                                                 x-transition:leave-end="opacity-0"
                                                 class="absolute z-[100] {{ ($loop->index > 2 && $loop->remaining < 3) ? 'bottom-full mb-4' : 'top-full mt-4' }} right-0 w-72 bg-gray-900 text-white rounded-2xl p-5 shadow-2xl ring-1 ring-white/10 pointer-events-none"
                                                 style="display: none;">
                                                <div class="space-y-3 text-xs">
                                                    <div class="flex justify-between border-b border-white/10 pb-2.5 mb-2.5">
                                                        <span class="text-gray-400 uppercase tracking-widest font-black text-[9px]">Billing Summary</span>
                                                        <span class="font-bold text-emerald-300">#{{ $booking->id }}</span>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-4 py-2 border-y border-white/5 my-1">
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Duration</div>
                                                            <div class="font-medium text-white">{{ $days ?? 0 }} Day(s)</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-[9px] text-gray-500 uppercase font-bold mb-0.5">Guests</div>
                                                            <div class="font-medium text-white">{{ $booking->guests }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1.5 pt-1">
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-400">Garden Subtotal</span>
                                                            <span class="font-medium text-white">LKR {{ number_format($booking->total_price, 2) }}</span>
                                                        </div>
                                                        <div class="flex justify-between text-gray-400">
                                                            <span>Service Tax ({{ number_format($booking->tax_percentage ?? 0, 1) }}%)</span>
                                                            <span>+ LKR {{ number_format($booking->tax_amount ?? 0, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between border-t border-white/20 pt-3 mt-3 items-end">
                                                        <div>
                                                            <div class="text-[9px] text-gray-400 uppercase font-black tracking-widest">Grand Total</div>
                                                        </div>
                                                        <div class="text-lg font-black text-amber-400 leading-none">LKR {{ number_format($booking->final_price, 2) }}</div>
                                                    </div>
                                                </div>
                                                <div class="absolute -top-1.5 right-12 w-3 h-3 bg-gray-900/95 rotate-45 border-l border-t border-white/10"></div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-3 text-center">
                                        <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase shadow-sm border
                                            @if($booking->status === 'approved') bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($booking->status === 'checked_in') bg-blue-50 text-blue-700 border-blue-100
                                            @elseif($booking->status === 'checked_out') bg-purple-50 text-purple-700 border-purple-100
                                            @elseif(in_array($booking->status, ['cancelled', 'rejected'])) bg-rose-50 text-rose-700 border-rose-100
                                            @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                            {{ str_replace('_', ' ', $booking->status) }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                                            <a href="{{ route('admin.garden-bookings.show', $booking) }}"
                                               class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>

                                            @if($booking->status === 'approved' || $booking->status === 'pending')
                                                <a href="{{ route('admin.garden.proforma', $booking) }}" target="_blank"
                                                   class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Download Quotation">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </a>
                                            @endif

                                            @if($booking->status === 'approved')
                                                <a href="{{ route('admin.garden.invoice', $booking) }}" target="_blank"
                                                   class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Print Invoice">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                </a>
                                            @endif

                                            <button @click="editing = !editing"
                                                    :class="editing ? 'text-emerald-600 bg-emerald-50' : 'text-gray-400 hover:text-emerald-600 hover:bg-emerald-50'"
                                                    class="p-2 rounded-lg transition-all" title="Manage Booking">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </button>

                                            {{-- Management Modal --}}
                                            <template x-teleport="body">
                                                <div x-show="editing" x-cloak
                                                     class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6 bg-gray-900/90 backdrop-blur-sm">
                                                    <div @click.away="editing = false"
                                                         class="bg-white w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-gray-100">
                                                        <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                                            <div class="flex items-center gap-4">
                                                                <div class="h-12 w-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text-lg font-black text-gray-900 uppercase tracking-tight leading-none">Garden Terminal</h4>
                                                                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mt-1.5 leading-none">{{ $booking->guest_name }} · Status &amp; Lifecycle Control</p>
                                                                </div>
                                                            </div>
                                                            <button @click="editing = false" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                                                                <svg class="w-5 h-5 text-gray-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                            </button>
                                                        </div>

                                                        <div class="p-8 space-y-8 max-h-[70vh] overflow-y-auto">
                                                            {{-- Status Control --}}
                                                            <div class="space-y-4">
                                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Global Status Protocol</label>
                                                                <div x-data="{ status: '{{ $booking->status }}' }">
                                                                    <form method="POST" action="{{ route('admin.garden-bookings.update', $booking) }}" class="space-y-4">
                                                                        @csrf @method('PUT')
                                                                        <div class="flex gap-3">
                                                                            <select x-model="status" name="status" class="flex-1 border-gray-100 rounded-2xl text-[13px] bg-gray-50/50 py-4 px-6 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold transition-all">
                                                                                @foreach(['pending', 'approved', 'checked_in', 'checked_out', 'cancelled', 'rejected'] as $s)
                                                                                    <option value="{{ $s }}" @selected($booking->status === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <button class="bg-emerald-600 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-emerald-100 active:scale-95 leading-none">Execute</button>
                                                                        </div>
                                                                        <div x-show="status === 'cancelled' || status === 'rejected'" x-transition class="animate-fade-in-down">
                                                                            <textarea name="cancellation_reason" rows="2" class="w-full border-gray-100 rounded-2xl text-[13px] bg-rose-50/30 py-4 px-6 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold transition-all placeholder:text-rose-200" placeholder="State reason..."></textarea>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            {{-- Payment Notes --}}
                                                            <div class="space-y-4 bg-gray-50/50 p-6 rounded-[2rem] border border-gray-100/50">
                                                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Payment Notes</label>
                                                                <form method="POST" action="{{ route('admin.garden-bookings.update', $booking) }}" class="space-y-4">
                                                                    @csrf @method('PUT')
                                                                    <input type="hidden" name="status" value="{{ $booking->status }}">
                                                                    <div class="flex gap-3">
                                                                        <div class="relative flex-1">
                                                                            <input type="number" name="advance_amount" min="0" value="{{ $booking->advance_amount ?? '' }}"
                                                                                   class="w-full border-gray-100 rounded-2xl text-[13px] bg-white py-4 px-6 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 font-bold transition-all tabular-nums" placeholder="Advance amount (LKR)">
                                                                        </div>
                                                                        <button class="bg-gray-900 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all leading-none">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            {{-- Danger Zone --}}
                                                            <div class="pt-4 space-y-4">
                                                                <div class="flex items-center gap-2 px-1">
                                                                    <div class="h-1.5 w-1.5 rounded-full bg-rose-500"></div>
                                                                    <label class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Restricted Operations</label>
                                                                </div>
                                                                <form action="{{ route('admin.garden-bookings.destroy', $booking) }}" method="POST" class="space-y-4">
                                                                    @csrf @method('DELETE')
                                                                    <input type="password" name="password" required placeholder="Confirm Destruction"
                                                                           class="w-full border-gray-100 rounded-2xl text-[13px] bg-red-50/20 py-4 px-6 focus:ring-4 focus:ring-red-100 focus:border-red-500 font-bold transition-all placeholder:text-red-200">
                                                                    <button type="submit" onclick="return confirm('Permanently delete this garden booking?')"
                                                                            class="w-full bg-red-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-100 active:scale-95 leading-none">
                                                                        Delete Permanent Record
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gray-50/50 p-6 text-center border-t border-gray-50">
                                                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest italic leading-none">System Integrity Verified · Terminal {{ auth()->id() }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <p class="text-sm font-semibold">No garden bookings found</p>
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
