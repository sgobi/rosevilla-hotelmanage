<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        Finance
                    </span>
                    <span class="text-gray-200 text-xs">/</span>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Transaction Ledger</span>
                </div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Transaction Ledger</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Room Stay · Events · Garden — Revenue Breakdown</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.index', array_merge(request()->query(), ['print' => 1])) }}" target="_blank"
                   class="flex items-center gap-2 px-5 py-2.5 bg-white text-gray-900 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-300 transition-all font-black text-[11px] uppercase tracking-widest group">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-violet-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print PDF
                </a>

                <div class="flex items-center gap-3 bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="h-10 w-10 rounded-xl bg-violet-600 text-white flex items-center justify-center shadow-lg shadow-violet-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Period</p>
                        <p class="text-xs font-black text-gray-900 uppercase tabular-nums">
                            @if($period === 'custom')
                                {{ \Carbon\Carbon::parse($start)->format('d M Y') }} – {{ \Carbon\Carbon::parse($end)->format('d M Y') }}
                            @elseif($period === 'daily')
                                {{ now()->format('d M Y') }}
                            @elseif($period === 'monthly')
                                {{ now()->format('F Y') }}
                            @else
                                {{ now()->format('Y') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── PERIOD FILTER BAR ──────────────────────────────────────────── --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-2 flex flex-wrap items-center gap-2" x-data="{ customOpen: {{ $period === 'custom' ? 'true' : 'false' }} }">

                {{-- Period Tabs --}}
                @foreach(['daily' => 'Today', 'monthly' => 'This Month', 'yearly' => 'This Year'] as $key => $label)
                    <a href="{{ route('admin.reports.index', array_merge(request()->except(['period','start_date','end_date','page']), ['period' => $key, 'type' => $typeFilter])) }}"
                       @click="customOpen = false"
                       class="px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all
                           {{ $period === $key && $period !== 'custom'
                               ? 'bg-gray-900 text-white shadow-lg'
                               : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                        @if($key === 'daily')
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg>
                                Daily
                            </span>
                        @elseif($key === 'monthly')
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Monthly
                            </span>
                        @else
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                Yearly
                            </span>
                        @endif
                    </a>
                @endforeach

                {{-- Custom Toggle --}}
                <button @click="customOpen = !customOpen"
                        class="px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all flex items-center gap-2
                            {{ $period === 'custom' ? 'bg-violet-600 text-white shadow-lg' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    Custom Range
                </button>

                {{-- Custom Date Form --}}
                <div x-show="customOpen" x-cloak x-transition class="w-full mt-1 px-3 py-3 bg-gray-50 rounded-2xl border border-gray-100 flex flex-wrap items-center gap-4">
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-center gap-4 w-full">
                        <input type="hidden" name="period" value="custom">
                        <input type="hidden" name="type" value="{{ $typeFilter }}">
                        <div class="flex items-center gap-3 flex-1 min-w-[260px]">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">From</label>
                            <input type="date" name="start_date" value="{{ $startDate ?? old('start_date') }}" required
                                   class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-violet-500 focus:border-violet-500 py-2 px-3">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">To</label>
                            <input type="date" name="end_date" value="{{ $endDate ?? old('end_date') }}" required
                                   class="flex-1 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-violet-500 focus:border-violet-500 py-2 px-3">
                        </div>
                        <button type="submit" class="px-6 py-2 bg-violet-600 text-white rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-violet-700 transition-all shadow-md shadow-violet-100 active:scale-95">
                            Apply
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── SUMMARY CARDS ───────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                {{-- Grand Total --}}
                <div class="relative bg-gray-900 rounded-3xl p-6 overflow-hidden col-span-1 sm:col-span-2 lg:col-span-1 shadow-xl">
                    <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full bg-white/5"></div>
                    <div class="absolute -left-4 -bottom-6 w-20 h-20 rounded-full bg-white/5"></div>
                    <div class="relative">
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Grand Total</p>
                        <p class="text-3xl font-black text-white leading-none tabular-nums">LKR {{ number_format($grandTotal, 0) }}</p>
                        <p class="text-[10px] text-white/30 font-bold mt-2">{{ $grandCount }} Approved Transactions</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-[9px] text-white/30 uppercase tracking-widest ml-1">All Categories</span>
                        </div>
                    </div>
                </div>

                {{-- Room Stay --}}
                <div class="bg-white rounded-3xl p-6 border-t-4 border-indigo-500 shadow-sm hover:shadow-md transition-all group cursor-pointer"
                     onclick="window.location.href='{{ route('admin.reports.index', array_merge(request()->except(['type','page']), ['type' => 'room'])) }}'">
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-11 w-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        @if($typeFilter === 'room')
                            <span class="text-[9px] font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full uppercase tracking-widest">Active</span>
                        @endif
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Room Stay</p>
                    <p class="text-2xl font-black text-gray-900 tabular-nums leading-none">LKR {{ number_format($roomTotal, 0) }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-1.5">{{ $roomCount }} booking{{ $roomCount !== 1 ? 's' : '' }}</p>
                    @if($grandTotal > 0)
                        <div class="mt-3 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-indigo-500 h-full rounded-full transition-all duration-700" style="width: {{ $grandTotal > 0 ? round(($roomTotal / $grandTotal) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-1 font-bold">{{ $grandTotal > 0 ? round(($roomTotal / $grandTotal) * 100) : 0 }}% of total</p>
                    @endif
                </div>

                {{-- Events --}}
                <div class="bg-white rounded-3xl p-6 border-t-4 border-rose-500 shadow-sm hover:shadow-md transition-all group cursor-pointer"
                     onclick="window.location.href='{{ route('admin.reports.index', array_merge(request()->except(['type','page']), ['type' => 'event'])) }}'">
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-11 w-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        @if($typeFilter === 'event')
                            <span class="text-[9px] font-black text-rose-600 bg-rose-50 px-2 py-1 rounded-full uppercase tracking-widest">Active</span>
                        @endif
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Events</p>
                    <p class="text-2xl font-black text-gray-900 tabular-nums leading-none">LKR {{ number_format($eventTotal, 0) }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-1.5">{{ $eventCount }} booking{{ $eventCount !== 1 ? 's' : '' }}</p>
                    @if($grandTotal > 0)
                        <div class="mt-3 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full transition-all duration-700" style="width: {{ $grandTotal > 0 ? round(($eventTotal / $grandTotal) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-1 font-bold">{{ $grandTotal > 0 ? round(($eventTotal / $grandTotal) * 100) : 0 }}% of total</p>
                    @endif
                </div>

                {{-- Garden --}}
                <div class="bg-white rounded-3xl p-6 border-t-4 border-emerald-500 shadow-sm hover:shadow-md transition-all group cursor-pointer"
                     onclick="window.location.href='{{ route('admin.reports.index', array_merge(request()->except(['type','page']), ['type' => 'garden'])) }}'">
                    <div class="flex items-start justify-between mb-4">
                        <div class="h-11 w-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                        </div>
                        @if($typeFilter === 'garden')
                            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase tracking-widest">Active</span>
                        @endif
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Garden</p>
                    <p class="text-2xl font-black text-gray-900 tabular-nums leading-none">LKR {{ number_format($gardenTotal, 0) }}</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-1.5">{{ $gardenCount }} booking{{ $gardenCount !== 1 ? 's' : '' }}</p>
                    @if($grandTotal > 0)
                        <div class="mt-3 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-700" style="width: {{ $grandTotal > 0 ? round(($gardenTotal / $grandTotal) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-1 font-bold">{{ $grandTotal > 0 ? round(($gardenTotal / $grandTotal) * 100) : 0 }}% of total</p>
                    @endif
                </div>
            </div>

            {{-- ── LEDGER TABLE ─────────────────────────────────────────────────── --}}
            <div class="bg-white shadow-[0_20px_50px_-20px_rgba(0,0,0,0.07)] rounded-[2rem] border border-gray-100 overflow-hidden">

                {{-- Table Header --}}
                <div class="px-8 py-5 border-b border-gray-50 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-gray-50/40">
                    <div>
                        <h3 class="text-base font-black text-gray-900 tracking-tight uppercase">Transaction Records</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                            {{ $ledger->count() }} of {{ $ledger->total() }} entries
                            @if($typeFilter !== 'all')
                                · Filtered by <span class="text-indigo-600">{{ ucfirst($typeFilter) }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                        {{-- Type Filter Pills --}}
                        <div class="flex items-center gap-1 bg-gray-100 rounded-2xl p-1">
                            @foreach(['all' => 'All', 'room' => 'Room', 'event' => 'Event', 'garden' => 'Garden'] as $key => $label)
                                <a href="{{ route('admin.reports.index', array_merge(request()->except(['type','page']), ['type' => $key])) }}"
                                   class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                                       {{ $typeFilter === $key
                                           ? ($key === 'room' ? 'bg-indigo-600 text-white shadow' : ($key === 'event' ? 'bg-rose-500 text-white shadow' : ($key === 'garden' ? 'bg-emerald-600 text-white shadow' : 'bg-gray-900 text-white shadow')))
                                           : 'text-gray-500 hover:text-gray-800' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>

                        {{-- Search --}}
                        <form method="GET" action="{{ route('admin.reports.index') }}" class="relative flex-1 min-w-[200px] md:max-w-[280px]">
                            <input type="hidden" name="period" value="{{ $period }}">
                            <input type="hidden" name="type" value="{{ $typeFilter }}">
                            @if($period === 'custom')
                                <input type="hidden" name="start_date" value="{{ $startDate }}">
                                <input type="hidden" name="end_date" value="{{ $endDate }}">
                            @endif
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Search name, type, ID..."
                                   class="w-full pl-9 pr-4 py-2 border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-gray-300">
                        </form>

                        @if($search)
                            <a href="{{ route('admin.reports.index', array_merge(request()->except(['search','page']))) }}"
                               class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:text-rose-600">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-3">Date Booked</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3">Client</th>
                                <th class="px-6 py-3">Detail</th>
                                <th class="px-6 py-3">Service Date</th>
                                <th class="px-6 py-3 text-right text-emerald-600">Discount</th>
                                <th class="px-6 py-3 text-right text-rose-500">Tax</th>
                                <th class="px-6 py-3 text-right">Net Revenue</th>
                                <th class="px-6 py-3 text-center">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($ledger as $row)
                                @php
                                    $typeColor = match($row->ledger_type) {
                                        'Room'   => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'dot' => 'bg-indigo-400'],
                                        'Event'  => ['bg' => 'bg-rose-50',   'text' => 'text-rose-600',   'dot' => 'bg-rose-400'],
                                        'Garden' => ['bg' => 'bg-emerald-50','text' => 'text-emerald-600','dot' => 'bg-emerald-400'],
                                        default  => ['bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400'],
                                    };
                                    $invoiceRoute = match($row->ledger_type) {
                                        'Room'   => route('admin.invoices.show', $row),
                                        'Event'  => route('admin.events.invoice', $row),
                                        'Garden' => route('admin.garden.invoice', $row),
                                        default  => '#',
                                    };
                                @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-4">
                                        <div class="text-xs font-bold text-gray-900">{{ $row->created_at->format('d M, Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $row->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider {{ $typeColor['bg'] }} {{ $typeColor['text'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $typeColor['dot'] }}"></span>
                                            {{ $row->ledger_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 text-sm group-hover:text-indigo-600 transition-colors leading-tight">{{ $row->ledger_name }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $row->ledger_email }}</div>
                                        <div class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-0.5">#{{ $row->id }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-gray-600 max-w-[180px] block truncate" title="{{ $row->ledger_tooltip ?? '' }}">{{ $row->ledger_detail }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-gray-500 font-medium">{{ $row->ledger_date }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs font-bold text-emerald-600">LKR {{ number_format($row->discount_amount, 0) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs font-bold text-rose-500">LKR {{ number_format($row->tax_amount, 0) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm font-black text-gray-900 tabular-nums">LKR {{ number_format($row->final_price, 0) }}</div>
                                        <div class="text-[8px] font-black text-gray-300 uppercase tracking-widest">Net</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ $invoiceRoute }}" target="_blank"
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 text-gray-400 hover:bg-gray-900 hover:text-white transition-all hover:scale-110 active:scale-95 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 rounded-3xl bg-gray-50 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            </div>
                                            <p class="text-sm font-black text-gray-300 uppercase tracking-widest">No transactions found</p>
                                            <p class="text-xs text-gray-400">Try selecting a different period or changing filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- Footer Totals --}}
                        @if($ledger->count() > 0)
                        <tfoot>
                            <tr class="bg-gray-900 text-white">
                                <td colspan="5" class="px-8 py-4">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-white/40">
                                        Page Totals ({{ $ledger->count() }} records)
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs font-black text-emerald-400">LKR {{ number_format($ledger->sum('discount_amount'), 0) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs font-black text-rose-400">LKR {{ number_format($ledger->sum('tax_amount'), 0) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-base font-black text-amber-400 tabular-nums">LKR {{ number_format($ledger->sum('final_price'), 0) }}</div>
                                    <div class="text-[8px] font-black text-white/20 uppercase tracking-widest">This Page Net</div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-8 py-4 bg-gray-50/40 border-t border-gray-100">
                    {{ $ledger->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
