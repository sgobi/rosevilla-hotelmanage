<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sales Reports
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Daily -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border-t-4 border-indigo-500 p-6 transition-all hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Today\'s Sales') }}</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 leading-tight">LKR {{ number_format($today, 0) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Weekly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border-t-4 border-emerald-500 p-6 transition-all hover:shadow-md relative group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('This Week') }}</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 leading-tight">LKR {{ number_format($week, 0) }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.print', ['period' => 'week']) }}" target="_blank" class="absolute top-4 right-4 text-gray-300 hover:text-emerald-500 transition-colors" title="Print Weekly Report">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </a>
                </div>

                <!-- Monthly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border-t-4 border-rose-500 p-6 transition-all hover:shadow-md relative group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('This Month') }}</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 leading-tight">LKR {{ number_format($month, 0) }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.print', ['period' => 'month']) }}" target="_blank" class="absolute top-4 right-4 text-gray-300 hover:text-rose-500 transition-colors" title="Print Monthly Report">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </a>
                </div>

                <!-- Yearly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl border-t-4 border-amber-500 p-6 transition-all hover:shadow-md relative group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Year to Date') }}</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 leading-tight">LKR {{ number_format($year, 0) }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.print', ['period' => 'year']) }}" target="_blank" class="absolute top-4 right-4 text-gray-300 hover:text-amber-500 transition-colors" title="Print Yearly Report">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Custom Report & Search Bar Container -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Custom Report Form -->
                <div class="bg-gray-900 rounded-3xl p-1 shadow-xl flex-1 max-w-2xl overflow-hidden">
                    <div class="bg-gray-800/50 rounded-[inherit] px-6 py-4 flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-rose-gold"></div>
                             <span class="text-[10px] font-black text-white/50 uppercase tracking-widest">Custom Period</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <input type="date" form="custom-report" name="start_date" required 
                                   class="bg-transparent border-none p-0 text-white text-xs focus:ring-0 cursor-pointer">
                            <span class="text-white/20">/</span>
                            <input type="date" form="custom-report" name="end_date" required 
                                   class="bg-transparent border-none p-0 text-white text-xs focus:ring-0 cursor-pointer">
                        </div>

                        <form id="custom-report" action="{{ route('admin.reports.print') }}" method="GET" target="_blank" class="ml-auto">
                            <button class="bg-white text-gray-900 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-rose-gold hover:text-white transition-all transform active:scale-95 flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                {{ __('Print') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Transaction Search -->
                <div class="flex-1">
                    <form action="{{ route('admin.reports.index') }}" method="GET" class="relative group h-full">
                        <input type="hidden" name="sort" value="{{ $sortBy }}">
                        <input type="hidden" name="direction" value="{{ $direction }}">
                        
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Filter by name, email, transaction ID..." 
                               class="w-full h-full pl-12 pr-4 bg-white border border-gray-100 rounded-3xl text-sm focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-indigo-500">
                            <svg class="w-5 h-5 transition-transform group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        @if($search)
                            <a href="{{ route('admin.reports.index', ['sort' => $sortBy, 'direction' => $direction]) }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-rose-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Recent Transactions Table Card -->
            <div class="bg-white shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] rounded-[2rem] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ __('Transaction Ledger') }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-0.5">Showing {{ $recentSales->count() }} of {{ $recentSales->total() }} Records</p>
                    </div>
                    
                    <a href="{{ route('admin.reservations.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase text-indigo-600 hover:text-indigo-700 tracking-widest transition-colors py-2 px-4 rounded-full bg-indigo-50/50">
                        {{ __('Manage Operations') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold">
                            @php
                                $toggleDir = $direction === 'asc' ? 'desc' : 'asc';
                                $sortIcon = function($col) use ($sortBy, $direction) {
                                    if ($sortBy !== $col) return '<svg class="w-3 h-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>';
                                    return $direction === 'asc' 
                                        ? '<svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>'
                                        : '<svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                                };
                            @endphp
                            <tr>
                                <th class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $sortBy == 'created_at' ? $toggleDir : 'desc']) }}" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                                        Date {!! $sortIcon('created_at') !!}
                                    </a>
                                </th>
                                <th class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => $sortBy == 'type' ? $toggleDir : 'asc']) }}" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                                        Type {!! $sortIcon('type') !!}
                                    </a>
                                </th>
                                <th class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'client', 'direction' => $sortBy == 'client' ? $toggleDir : 'asc']) }}" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                                        Client {!! $sortIcon('client') !!}
                                    </a>
                                </th>
                                <th class="px-6 py-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'details', 'direction' => $sortBy == 'details' ? $toggleDir : 'asc']) }}" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                                        Details {!! $sortIcon('details') !!}
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-right text-emerald-600">Discount</th>
                                <th class="px-6 py-3 text-right text-rose-600">Tax</th>
                                <th class="px-6 py-3 text-right">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount', 'direction' => $sortBy == 'amount' ? $toggleDir : 'desc']) }}" class="flex items-center justify-end gap-1 hover:text-indigo-600 transition-colors">
                                        Revenue {!! $sortIcon('amount') !!}
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-center">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentSales as $sale)
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="text-gray-900 font-bold text-xs">{{ $sale->created_at->format('d M, Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $sale->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                            {{ $sale->type === 'Room' ? 'bg-indigo-50 text-indigo-600' : 'bg-rose-50 text-rose-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $sale->type === 'Room' ? 'bg-indigo-400' : 'bg-rose-400' }}"></span>
                                            {{ $sale->type }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $sale->display_name }}</span>
                                            <span class="text-[10px] text-gray-500 font-medium">{{ $sale->email }}</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">ID: #{{ $sale->id }}</span>
                                                @if($sale->address)
                                                    <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                                    <span class="text-[9px] text-gray-400 font-medium italic truncate max-w-[150px]">{{ $sale->address }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-xs font-bold text-gray-600 max-w-[200px] truncate">{{ $sale->details }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-0.5">- {{ number_format($sale->discount_amount, 0) }}</div>
                                        <div class="text-[10px] font-black text-rose-600 uppercase tracking-widest">+ {{ number_format($sale->tax_amount, 0) }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="text-sm font-black text-gray-900 leading-none mb-1">LKR {{ number_format($sale->final_price, 0) }}</div>
                                        <div class="text-[8px] font-black text-gray-300 uppercase tracking-[0.2em]">{{ __('Net Revenue') }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @php 
                                            $invoiceRoute = $sale->type === 'Room' ? route('admin.invoices.show', $sale) : route('admin.events.invoice', $sale);
                                        @endphp
                                        <a href="{{ $invoiceRoute }}" target="_blank" 
                                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-gray-900 hover:text-white transition-all transform hover:scale-110 active:scale-95 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No approved sales to report yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $recentSales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
