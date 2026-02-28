<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Event Front Desk</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Event Logistics & Financial Settlement</p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.events.calendar') }}" class="group relative px-6 py-2.5 bg-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-indigo-200 hover:bg-black hover:shadow-xl transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Calendar View
                </a>

                <div class="flex items-center gap-3 bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                    <div class="h-10 w-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-lg" style="background: #111827;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Current Shift</p>
                        <p class="text-sm font-black text-gray-900 leading-none tabular-nums">{{ now()->format('D, M d • H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ 
        advanceModal: false, 
        finalPaymentModal: false,
        currentRes: null,
        paymentMethod: 'bank',
        remainingBalance: 0,
        advanceAmount: 0
    }">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-8 space-y-8">
            
            {{-- Professional Alert System --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="fixed top-28 right-8 z-[100] bg-gray-900 text-white px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-4 border border-white/10 animate-fade-in-right">
                    <div class="h-10 w-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center ring-1 ring-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest leading-none mb-1">Operation Success</p>
                        <p class="text-sm font-bold text-white/90">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 p-1 hover:bg-white/10 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="fixed top-28 right-8 z-[100] bg-rose-600 text-white px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(225,29,72,0.3)] flex items-center gap-4 border border-white/10 animate-fade-in-right">
                    <div class="h-10 w-10 rounded-2xl bg-white/20 text-white flex items-center justify-center ring-1 ring-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/70 uppercase tracking-widest leading-none mb-1">Attention Required</p>
                        <p class="text-sm font-bold text-white">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="ml-4 p-1 hover:bg-white/10 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Summary Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Events Today</p>
                        <p class="text-2xl font-black text-gray-900">{{ $startingToday->count() }}</p>
                    </div>
                </div>

                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Events</p>
                        <p class="text-2xl font-black text-gray-900">{{ $activeBookings->whereNotNull('checked_in_at')->count() }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <form method="GET" action="{{ route('admin.event-front-desk.index') }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Client or Event Type..." class="w-full pl-12 pr-4 py-5 bg-gray-900 text-white border-transparent rounded-[2rem] text-sm focus:ring-4 focus:ring-amber-500/20 placeholder:text-gray-500 font-bold">
                        <svg class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
                {{-- Arrivals --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between px-4">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Scheduled for Today</h3>
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-black">{{ $startingToday->count() }} PENDING</span>
                    </div>

                    <div class="space-y-4">
                        @forelse($startingToday as $booking)
                            <div class="bg-white p-7 rounded-[3rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-6">
                                        <div class="h-16 w-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center font-black text-2xl">
                                            {{ substr($booking->customer_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-900 text-xl tracking-tight">{{ $booking->customer_name }}</h4>
                                            <p class="text-xs font-black text-amber-500 uppercase tracking-widest mt-1">{{ $booking->event_type }} • {{ $booking->guests }} Guests</p>
                                            <div class="flex items-center gap-3 mt-3 text-[10px] font-bold text-gray-400">
                                                <span><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</span>
                                                @if($booking->advance_paid_at)
                                                    <span class="text-emerald-600 font-black tracking-widest uppercase">● Advance Paid</span>
                                                @else
                                                    <span class="text-rose-500 font-black tracking-widest uppercase">● Advance Required (LKR {{ number_format($booking->total_price * 0.1, 2) }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($booking->advance_paid_at)
                                        <form method="POST" action="{{ route('admin.event-front-desk.check-in', $booking) }}">
                                            @csrf
                                            <button class="bg-gray-900 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all">Start Event</button>
                                        </form>
                                    @else
                                        <button @click="currentRes = {{ json_encode($booking) }}; advanceAmount = (currentRes.total_price * 0.1).toFixed(2); advanceModal = true" class="bg-amber-500 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all">Collect Advance</button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 border border-dashed border-gray-200 p-12 rounded-[3rem] text-center text-gray-400 text-xs font-bold uppercase tracking-widest">No scheduled events for today</div>
                        @endforelse
                    </div>
                </div>

                {{-- Master List --}}
                <div class="bg-gray-50/50 rounded-[3rem] p-8 border border-gray-200/50">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Operational Master Terminal</h3>
                        <span class="bg-white border text-gray-500 px-3 py-1 rounded-full text-[10px] font-black">{{ $activeBookings->count() }} TOTAL</span>
                    </div>

                    <div class="space-y-5">
                        @forelse($activeBookings as $booking)
                            <div class="bg-white p-7 rounded-[3rem] border border-gray-100 shadow-sm transition-all hover:shadow-xl group">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <div class="flex-1 space-y-6">
                                        <div class="flex items-center gap-5">
                                            <div class="h-14 w-14 rounded-2xl {{ $booking->checked_in_at ? 'bg-emerald-600 text-white' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center font-black text-xl">
                                                {{ substr($booking->customer_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-3">
                                                    <h4 class="font-black text-gray-900 text-xl">{{ $booking->customer_name }}</h4>
                                                    @if($booking->checked_in_at)
                                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase">Active</span>
                                                    @else
                                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 rounded-lg text-[9px] font-black uppercase">Upcoming</span>
                                                    @endif
                                                </div>
                                                <p class="text-[10px] font-black text-gray-400 uppercase mt-1">{{ $booking->event_type }} • {{ $booking->event_date->format('M d, Y') }}</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-gray-50 p-4 rounded-2xl">
                                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Bill</p>
                                                <p class="text-sm font-black text-gray-900 leading-none">LKR {{ number_format($booking->final_price, 2) }}</p>
                                            </div>
                                            <div class="bg-gray-50 p-4 rounded-2xl">
                                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Outstanding</p>
                                                <p class="text-sm font-black text-rose-600 leading-none">LKR {{ number_format($booking->final_price - $booking->advance_amount - $booking->final_payment_amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full md:w-48 flex flex-col gap-3 justify-center">
                                        @if(!$booking->checked_in_at)
                                            <button @click="currentRes = {{ json_encode($booking) }}; advanceAmount = (currentRes.total_price * 0.1).toFixed(2); advanceModal = true" class="w-full bg-amber-500 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-amber-100">Record Advance</button>
                                        @elseif(!$booking->checked_out_at)
                                            @if($booking->final_payment_at)
                                                <form method="POST" action="{{ route('admin.event-front-desk.check-out', $booking) }}" class="w-full">
                                                    @csrf
                                                    <button class="w-full bg-rose-gold text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-gold/20">Mark Completed</button>
                                                </form>
                                            @else
                                                <button @click="currentRes = {{ json_encode($booking) }}; remainingBalance = {{ $booking->final_price - $booking->advance_amount }}; finalPaymentModal = true" class="w-full bg-indigo-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">Settle Balance</button>
                                            @endif
                                        @endif
                                        <a href="{{ route('admin.events.invoice', $booking) }}" target="_blank" class="w-full bg-white text-gray-900 border-2 border-gray-100 py-5 rounded-2xl text-[10px] font-black uppercase text-center leading-none flex items-center justify-center gap-2 group/btn transition-all hover:bg-gray-50 hover:border-gray-200">
                                            <svg class="w-4 h-4 text-gray-300 group-hover/btn:text-rose-gold transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Invoice
                                        </a>

                                        @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                                            <div x-data="{ open: false }" class="w-full">
                                                <button @click="open = true" 
                                                        class="w-full bg-rose-50 text-rose-600 border border-rose-100 px-6 py-4 rounded-2xl text-[9px] font-black uppercase tracking-[0.2em] transition-all hover:bg-rose-100 text-center active:scale-95 leading-none flex items-center justify-center gap-2">
                                                    Manage Data
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
                                                                        <h4 class="text-lg font-black text-gray-900 uppercase tracking-tight leading-none">Event Operations</h4>
                                                                        <p class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] mt-1.5 leading-none">Advanced Administrative Terminal</p>
                                                                    </div>
                                                                </div>
                                                                <button @click="open = false" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                                                                    <svg class="w-5 h-5 text-gray-400 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>

                                                            <div class="p-8 space-y-8">
                                                                {{-- Operational Reset --}}
                                                                <form action="{{ route('admin.event-front-desk.reset', $booking) }}" method="POST" class="space-y-4">
                                                                    @csrf
                                                                    <div class="space-y-2.5">
                                                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Safe Reset (In/Out/Pay)</label>
                                                                        <input type="password" name="password" required placeholder="Verify Identity" 
                                                                               class="w-full border-gray-100 rounded-2xl text-[13px] bg-gray-50/50 py-4 px-6 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold transition-all placeholder:text-gray-300">
                                                                    </div>
                                                                    <button type="submit" 
                                                                            onclick="return confirm('Clear all operations for this event? The booking stays approved.')"
                                                                            class="w-full bg-rose-50 text-rose-600 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-100 transition-all active:scale-95 text-center">
                                                                        Full Operational Reset
                                                                    </button>
                                                                </form>

                                                                <div class="relative flex items-center justify-center">
                                                                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
                                                                    <span class="relative bg-white px-4 text-[9px] font-black text-gray-300 uppercase tracking-widest text-center">OR DESTROY RECORD</span>
                                                                </div>

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
                                                                            class="w-full bg-red-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-red-100 active:scale-95 text-center">
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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Advance Modal --}}
        <div x-show="advanceModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/95" @click="advanceModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <div class="inline-block overflow-hidden transition-all transform bg-white text-left align-middle shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] sm:max-w-xl sm:w-full rounded-[3.5rem] border border-gray-100 p-10"
                     x-show="advanceModal">
                    
                    <form :action="'/admin/event-front-desk/' + currentRes?.id + '/advance'" method="POST">
                        @csrf
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-3xl font-black text-gray-900 tracking-tight">Record Event Advance</h3>
                                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Advance Payment Details</p>
                            </div>
                            <button type="button" @click="advanceModal = false" class="p-3 bg-gray-50 rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-8">
                            {{-- Payment Method Tabs --}}
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="advance_payment_method" value="bank" x-model="paymentMethod" class="hidden">
                                    <div class="py-4 rounded-2xl border-2 text-center text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-300" 
                                         :class="paymentMethod === 'bank' ? 'border-indigo-600 bg-indigo-50 text-indigo-900 shadow-lg shadow-indigo-100' : 'border-gray-100 bg-gray-50/50 text-gray-400 hover:border-gray-200'">
                                        Bank Transfer
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="advance_payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div class="py-4 rounded-2xl border-2 text-center text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-300" 
                                         :class="paymentMethod === 'cash' ? 'border-emerald-600 bg-emerald-50 text-emerald-900 shadow-lg shadow-emerald-100' : 'border-gray-100 bg-gray-50/50 text-gray-400 hover:border-gray-200'">
                                        Cash Payment
                                    </div>
                                </label>
                            </div>
    
                            {{-- Content Box --}}
                            <div class="bg-gray-50 rounded-[2.5rem] space-y-5 border border-gray-100">
                                <div class="space-y-4">
                                    <input type="text" name="advance_guest_name" x-bind:value="currentRes?.customer_name" required placeholder="Guest Name" 
                                           class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                                    
                                    <input type="text" name="advance_nic_no" required placeholder="NIC NUMBER" 
                                           class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all uppercase tracking-widest">
                                    
                                    <div class="relative">
                                        <input type="number" name="advance_amount" x-model="advanceAmount" step="0.01" required placeholder="Amount (LKR)" 
                                               class="w-full bg-white border-transparent rounded-[1.25rem] text-2xl font-black py-5 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all tabular-nums">
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-400 uppercase tracking-widest">LKR</div>
                                    </div>
                                    
                                    <template x-if="paymentMethod === 'bank'">
                                        <div class="space-y-4 animate-fade-in-down">
                                            <div class="relative">
                                                <select name="advance_bank_name" required 
                                                        class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                                    <option value="">Select Bank...</option>
                                                    <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
                                                    <option value="People’s Bank">People’s Bank</option>
                                                    <option value="Commercial Bank of Ceylon PLC">Commercial Bank of Ceylon PLC</option>
                                                    <option value="Hatton National Bank PLC (HNB)">Hatton National Bank PLC (HNB)</option>
                                                    <option value="Sampath Bank PLC">Sampath Bank PLC</option>
                                                </select>
                                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                </div>
                                            </div>
                                            <input type="text" name="advance_bank_branch" required placeholder="Branch Name" 
                                                   class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
    
                        <button type="submit" class="w-full mt-10 bg-[#111827] text-white py-6 rounded-[1.5rem] font-black uppercase tracking-[0.3em] shadow-2xl shadow-gray-200 hover:bg-black hover:-translate-y-1 transition-all duration-300 active:scale-95">Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Final Modal --}}
        <div x-show="finalPaymentModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/95" @click="finalPaymentModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <div class="inline-block overflow-hidden transition-all transform bg-white text-left align-middle shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] sm:max-w-xl sm:w-full rounded-[3.5rem] border border-gray-100 p-10"
                     x-show="finalPaymentModal">
                    
                    <form :action="'/admin/event-front-desk/' + currentRes?.id + '/final-payment'" method="POST">
                        @csrf
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-3xl font-black text-gray-900 tracking-tight">Event Final Settlement</h3>
                                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mt-1 italic">Total Outstanding Balance Collection</p>
                            </div>
                            <button type="button" @click="finalPaymentModal = false" class="p-3 bg-gray-50 rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
    
                        <div class="space-y-8">
                            {{-- Balance Summary Card --}}
                            <div class="bg-indigo-900 text-white p-8 rounded-[2.5rem] flex items-center justify-between shadow-2xl shadow-indigo-200 overflow-hidden relative group">
                                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                                <div class="relative">
                                    <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.2em] mb-1 leading-none">Total Outstanding</p>
                                    <p class="text-4xl font-black tracking-tighter tabular-nums leading-none">LKR <span x-text="remainingBalance.toLocaleString()"></span></p>
                                </div>
                                <div class="relative w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                                    <svg class="w-7 h-7 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                            </div>

                            {{-- Payment Method Tabs --}}
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_payment_method" value="bank" x-model="paymentMethod" class="hidden">
                                    <div class="py-4 rounded-2xl border-2 text-center text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-300" 
                                         :class="paymentMethod === 'bank' ? 'border-indigo-600 bg-indigo-50 text-indigo-900 shadow-lg shadow-indigo-100' : 'border-gray-100 bg-gray-50/50 text-gray-400 hover:border-gray-200'">
                                        Bank Transfer
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div class="py-4 rounded-2xl border-2 text-center text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-300" 
                                         :class="paymentMethod === 'cash' ? 'border-emerald-600 bg-emerald-50 text-emerald-900 shadow-lg shadow-emerald-100' : 'border-gray-100 bg-gray-50/50 text-gray-400 hover:border-gray-200'">
                                        Cash Payment
                                    </div>
                                </label>
                            </div>
    
                            {{-- Content Box --}}
                            <div class="bg-gray-50 p-8 rounded-[2.5rem] space-y-5 border border-gray-100 shadow-inner">
                                <div class="space-y-4">
                                    <input type="text" name="final_guest_name" x-bind:value="currentRes?.customer_name" required placeholder="Guest Name" 
                                           class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                                    
                                    <input type="text" name="final_nic_no" x-bind:value="currentRes?.advance_nic_no" required placeholder="NIC NUMBER" 
                                           class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all uppercase tracking-widest">
                                    
                                    <div class="relative">
                                        <input type="number" name="final_payment_amount" step="0.01" x-bind:value="remainingBalance" required placeholder="Amount (LKR)" 
                                               class="w-full bg-white border-transparent rounded-[1.25rem] text-2xl font-black py-5 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all tabular-nums">
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-400 uppercase tracking-widest">LKR</div>
                                    </div>
                                    
                                    <template x-if="paymentMethod === 'bank'">
                                        <div class="space-y-4 animate-fade-in-down">
                                            <div class="relative">
                                                <select name="final_bank_name" required 
                                                        class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                                    <option value="">Select Bank...</option>
                                                    <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
                                                    <option value="People’s Bank">People’s Bank</option>
                                                    <option value="Commercial Bank of Ceylon PLC">Commercial Bank of Ceylon PLC</option>
                                                    <option value="Hatton National Bank PLC (HNB)">Hatton National Bank PLC (HNB)</option>
                                                    <option value="Sampath Bank PLC">Sampath Bank PLC</option>
                                                </select>
                                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                </div>
                                            </div>
                                            <input type="text" name="final_bank_branch" required placeholder="Branch Name" 
                                                   class="w-full bg-white border-transparent rounded-[1.25rem] font-bold text-sm py-4 px-6 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
    
                        <button type="submit" class="w-full mt-10 bg-indigo-600 text-white py-6 rounded-[1.5rem] font-black uppercase tracking-[0.3em] shadow-2xl shadow-indigo-100 hover:bg-black hover:-translate-y-1 transition-all duration-300 active:scale-95">Clear Balance & Finalize</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
