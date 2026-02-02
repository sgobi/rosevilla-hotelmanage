<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Front Desk Operations</h2>
                <p class="text-[10px] font-black text-rose-gold uppercase tracking-[0.3em] mt-1 italic">Property Management & Guest Logistics</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white/50 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                <div class="h-10 w-10 rounded-xl bg-gray-900 text-white flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-left">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Current Shift</p>
                    <p class="text-sm font-black text-gray-900 leading-none tabular-nums">{{ now()->format('D, M d • H:i') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ 
        advanceModal: false, 
        finalPaymentModal: false,
        currentRes: null,
        paymentMethod: 'bank',
        remainingBalance: 0
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

            {{-- Summary Key Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Arrivals --}}
                <div class="group relative bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative flex flex-col gap-4">
                        <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100 ring-4 ring-indigo-50 group-hover:rotate-6 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Arrivals Today</p>
                            <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $arrivingToday->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- departures --}}
                <div class="group relative bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-amber-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative flex flex-col gap-4">
                        <div class="w-14 h-14 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-100 ring-4 ring-amber-50 group-hover:rotate-6 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Departures Today</p>
                            <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $departingToday->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- In House --}}
                <div class="group relative bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative flex flex-col gap-4">
                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100 ring-4 ring-emerald-50 group-hover:rotate-6 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">In House Guests</p>
                            <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $activeReservations->whereNotNull('checked_in_at')->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Search & Quick Filter --}}
                <div class="flex flex-col gap-4">
                    <form method="GET" action="{{ route('admin.front-desk.index') }}" class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search Guest Terminal..." 
                               class="w-full pl-12 pr-4 py-6 bg-gray-900 text-white border-transparent rounded-[2rem] text-sm focus:ring-4 focus:ring-indigo-500/20 focus:bg-black focus:border-indigo-500 transition-all placeholder:text-gray-500 font-bold tracking-tight">
                        <svg class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        @if(request('search'))
                            <a href="{{ route('admin.front-desk.index') }}" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </form>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reservations.index') }}" class="flex-1 bg-white border border-gray-100 py-4 px-6 rounded-2xl text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:bg-gray-50 hover:text-gray-900 transition-all text-center">Master Grid</a>
                        <a href="{{ route('admin.front-desk.index') }}" class="flex-1 bg-rose-gold text-white py-4 px-6 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:opacity-90 transition-all shadow-lg shadow-rose-gold/20 text-center">Refresh</a>
                    </div>
                </div>
            </div>

            {{-- Main Operational Grid --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
                
                {{-- Column 1: Priority Shifts --}}
                <div class="space-y-10">
                    {{-- ARRIVALS CARD --}}
                    <div class="bg-indigo-50/30 rounded-[3rem] p-8 border border-white/50 backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-8 px-2">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-indigo-900 uppercase tracking-[0.3em]">Expected Arrivals</h3>
                            </div>
                            <span class="px-5 py-1.5 bg-indigo-600 text-white rounded-full text-[10px] font-black tracking-widest shadow-lg shadow-indigo-100">{{ $arrivingToday->count() }} PENDING</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($arrivingToday as $res)
                                <div class="bg-white p-6 rounded-[2.5rem] border border-white shadow-[0_10px_30px_-10px_rgba(79,70,229,0.1)] transition-all hover:shadow-[0_20px_40px_-5px_rgba(79,70,229,0.15)] flex items-center justify-between group">
                                    <div class="flex items-center gap-6">
                                        <div class="relative">
                                            <div class="h-16 w-16 rounded-[1.5rem] bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-2xl uppercase shadow-inner border border-indigo-100">
                                                {{ substr($res->guest_name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 h-6 w-6 bg-white rounded-lg shadow-md border border-gray-50 flex items-center justify-center text-indigo-500">
                                                @if($res->advance_paid_at)
                                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-900 text-xl tracking-tight leading-none group-hover:text-indigo-600 transition-colors">{{ $res->guest_name }}</h4>
                                            <p class="text-xs font-black text-indigo-400 uppercase tracking-widest mt-2">{{ $res->room->title ?? 'Heritage Room' }} • {{ $res->guests }} Guests</p>
                                            <div class="flex items-center mt-3 gap-3 text-[10px] font-bold text-gray-400">
                                                @if($res->advance_paid_at)
                                                    <div class="flex items-center gap-1.5 text-emerald-600 font-black"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ADVANCE PAID</div>
                                                @else
                                                    <div class="flex items-center gap-1.5 text-rose-500 font-black"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ADVANCE REQUIRED</div>
                                                @endif
                                                <div class="h-1 w-1 bg-gray-200 rounded-full"></div>
                                                <div class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $res->check_in->format('M d') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($res->advance_paid_at)
                                        <form method="POST" action="{{ route('admin.front-desk.check-in', $res) }}">
                                            @csrf
                                            <button class="bg-gray-900 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-black hover:shadow-xl active:scale-95">Check In</button>
                                        </form>
                                    @else
                                        <button @click="currentRes = {{ json_encode($res) }}; advanceModal = true; paymentMethod = 'bank'" class="bg-indigo-600 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-indigo-700 hover:shadow-xl active:scale-95">Record Advance</button>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white/40 border border-dashed border-gray-200/50 p-12 rounded-[2.5rem] flex flex-col items-center justify-center text-center opacity-70">
                                    <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-gray-300 mb-4 shadow-sm">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No scheduled arrivals for today</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- DEPARTURES CARD --}}
                    <div class="bg-amber-50/30 rounded-[3rem] p-8 border border-white/50 backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-8 px-2">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                </div>
                                <h3 class="text-xs font-black text-amber-900 uppercase tracking-[0.3em]">Expected Departures</h3>
                            </div>
                            <span class="px-5 py-1.5 bg-amber-500 text-white rounded-full text-[10px] font-black tracking-widest shadow-lg shadow-amber-100">{{ $departingToday->count() }} PENDING</span>
                        </div>

                        <div class="space-y-4">
                            @forelse($departingToday as $res)
                                <div class="bg-white p-6 rounded-[2.5rem] border border-white shadow-[0_10px_30px_-10px_rgba(245,158,11,0.1)] transition-all hover:shadow-[0_20px_40px_-5px_rgba(245,158,11,0.15)] flex items-center justify-between group">
                                    <div class="flex items-center gap-6">
                                        <div class="relative">
                                            <div class="h-16 w-16 rounded-[1.5rem] bg-amber-50 text-amber-600 flex items-center justify-center font-black text-2xl uppercase shadow-inner border border-amber-100">
                                                {{ substr($res->guest_name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 h-6 w-6 bg-emerald-500 rounded-lg shadow-md border border-white flex items-center justify-center text-white">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-900 text-xl tracking-tight leading-none group-hover:text-amber-600 transition-colors">{{ $res->guest_name }}</h4>
                                            <p class="text-xs font-black text-emerald-500 uppercase tracking-widest mt-2">In House (since {{ $res->checked_in_at->format('M d') }})</p>
                                            <div class="flex items-center mt-3 gap-3 text-[10px] font-bold text-gray-400">
                                                <div class="flex items-center gap-1.5 font-black text-amber-600">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg> 
                                                    Balance: LKR {{ number_format($res->final_price - $res->advance_amount, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($res->final_payment_at)
                                        <form method="POST" action="{{ route('admin.front-desk.check-out', $res) }}">
                                            @csrf
                                            <button class="bg-rose-gold text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:opacity-90 hover:shadow-xl active:scale-95 shadow-lg shadow-rose-gold/10">Check Out</button>
                                        </form>
                                    @else
                                        <button @click="currentRes = {{ json_encode($res) }}; remainingBalance = {{ $res->final_price - $res->advance_amount }}; finalPaymentModal = true; paymentMethod = 'bank'" class="bg-amber-500 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-amber-600 hover:shadow-xl active:scale-95 shadow-lg shadow-amber-100">Collect Balance</button>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white/40 border border-dashed border-gray-200/50 p-12 rounded-[2.5rem] flex flex-col items-center justify-center text-center opacity-70">
                                    <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-gray-300 mb-4 shadow-sm">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Clear schedule for departures today</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Column 2: Master Guest Terminal --}}
                <div class="bg-gray-50/50 rounded-[3rem] p-8 border border-gray-200/50">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-xs font-black text-emerald-900 uppercase tracking-[0.3em]">{{ request('search') ? 'Filtered Results' : 'Overall Property Occupancy' }}</h3>
                        </div>
                        <span class="px-5 py-1.5 bg-white border border-gray-200 text-gray-500 rounded-full text-[10px] font-black tracking-widest">{{ $activeReservations->count() }} TOTAL</span>
                    </div>

                    <div class="space-y-5">
                        @forelse($activeReservations as $res)
                            <div class="bg-white p-7 rounded-[3rem] border border-gray-100 shadow-sm transition-all hover:shadow-xl hover:border-emerald-100 group relative overflow-hidden">
                                @if($res->checked_in_at)
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 -mr-16 -mt-16 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
                                @endif
                                
                                <div class="flex flex-col md:flex-row gap-6">
                                    {{-- Left Side: Guest Info --}}
                                    <div class="flex-1 space-y-6">
                                        <div class="flex items-center gap-5">
                                            <div class="h-14 w-14 rounded-2xl {{ $res->checked_in_at ? 'bg-emerald-600 text-white' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center font-black text-xl shadow-lg transition-colors">
                                                {{ substr($res->guest_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-3">
                                                    <h4 class="font-black text-gray-900 text-xl leading-none">{{ $res->guest_name }}</h4>
                                                    @if($res->checked_in_at)
                                                        <span class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest ring-1 ring-emerald-500/20">
                                                            <span class="h-1.5 w-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                                            In-House
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 rounded-lg text-[9px] font-black uppercase tracking-widest ring-1 ring-gray-200">Pending</span>
                                                    @endif

                                                    @if($res->advance_paid_at)
                                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100">Advance Paid</span>
                                                    @endif

                                                    @if($res->final_payment_at)
                                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">Fully Paid</span>
                                                    @endif
                                                </div>
                                                <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.1em] mt-2 italic">{{ $res->room->title ?? 'Heritage Room' }} ({{ $res->guests }} Adults)</p>
                                            </div>
                                        </div>

                                        {{-- Boarding Pass Style Dates --}}
                                        <div class="grid grid-cols-2 gap-px bg-gray-100 p-px rounded-3xloverflow-hidden rounded-[1.5rem] border border-gray-100">
                                            <div class="bg-white p-5">
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 leading-none">Arrival Gate</p>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm font-black text-gray-900 leading-none">{{ $res->check_in->format('D, M d') }}</p>
                                                    @if($res->checked_in_at)
                                                       <p class="text-[10px] font-bold text-emerald-500 leading-none bg-emerald-50 px-1.5 py-0.5 rounded ml-auto">@ {{ $res->checked_in_at->format('H:i') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="bg-white p-5">
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 leading-none">Departure Gate</p>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm font-black text-gray-900 leading-none">{{ $res->check_out->format('D, M d') }}</p>
                                                    @if($res->checked_out_at)
                                                       <p class="text-[10px] font-bold text-gray-500 leading-none bg-gray-50 px-1.5 py-0.5 rounded ml-auto">@ {{ $res->checked_out_at->format('H:i') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Contact & Payment info --}}
                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-xl text-[10px] font-bold text-gray-500 border border-gray-100">
                                                <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                {{ $res->email }}
                                            </div>
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-xl text-[10px] font-bold text-gray-500 border border-gray-100">
                                                <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $res->phone }}
                                            </div>
                                            @if($res->advance_paid_at)
                                                <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 rounded-xl text-[10px] font-black text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                                    Deposit: LKR {{ number_format($res->advance_amount, 0) }}
                                                </div>
                                            @endif
                                            @if($res->final_payment_at)
                                                <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 rounded-xl text-[10px] font-black text-indigo-600 border border-indigo-100 uppercase tracking-widest">
                                                    Settled: LKR {{ number_format($res->final_payment_amount, 0) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Right Side: Active Terminal Actions --}}
                                    <div class="w-full md:w-48 flex flex-col gap-3 justify-center">
                                        @if(!$res->checked_in_at)
                                            @if($res->advance_paid_at)
                                                <form method="POST" action="{{ route('admin.front-desk.check-in', $res) }}" class="w-full">
                                                    @csrf
                                                    <button class="w-full bg-indigo-600 text-white px-6 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-black hover:shadow-xl active:scale-95 shadow-lg shadow-indigo-100">Check In</button>
                                                </form>
                                            @else
                                                <button @click="currentRes = {{ json_encode($res) }}; advanceModal = true; paymentMethod = 'bank'" class="w-full bg-rose-gold text-white px-6 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-black hover:shadow-xl active:scale-95 shadow-lg shadow-rose-gold/20 leading-tight">Pay Advance</button>
                                            @endif
                                        @elseif(!$res->checked_out_at)
                                            @if($res->final_payment_at)
                                                <form method="POST" action="{{ route('admin.front-desk.check-out', $res) }}" class="w-full">
                                                    @csrf
                                                    <button class="w-full bg-rose-gold text-white px-6 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:opacity-90 hover:shadow-xl active:scale-95 shadow-lg shadow-rose-gold/10">Check Out</button>
                                                </form>
                                            @else
                                                <button @click="currentRes = {{ json_encode($res) }}; remainingBalance = {{ $res->final_price - $res->advance_amount }}; finalPaymentModal = true; paymentMethod = 'bank'" class="w-full bg-amber-500 text-white px-6 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-black hover:shadow-xl active:scale-95 shadow-lg shadow-amber-100 leading-tight">Pay Balance<br><span class="text-[8px] opacity-70">Final Payment</span></button>
                                            @endif
                                        @endif
                                        
                                        <a href="{{ route('admin.invoices.show', $res) }}" target="_blank" 
                                           class="w-full bg-white text-gray-900 border-2 border-gray-100 px-6 py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:bg-gray-50 hover:border-gray-200 text-center active:scale-95 leading-none flex items-center justify-center gap-2 group/btn">
                                            <svg class="w-4 h-4 text-gray-300 group-hover/btn:text-rose-gold transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Bill Info
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white border border-dashed border-gray-200 p-20 rounded-[3rem] text-center">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">System scan complete.<br>No active reservations found 00:00:00</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ADVANCE PAYMENT MODAL --}}
        <div x-show="advanceModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/90 backdrop-blur-sm" @click="advanceModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <div class="inline-block overflow-hidden transition-all transform bg-white text-left align-middle shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] sm:max-w-xl sm:w-full rounded-[3rem] border border-gray-100"
                     x-show="advanceModal">
                    
                    <form :action="'/admin/front-desk/' + currentRes?.id + '/advance'" method="POST" class="p-10">
                        @csrf
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Record Advance Payment</h3>
                                <p class="text-[10px] font-black text-rose-gold uppercase tracking-widest mt-1 italic">Security Transaction Layer</p>
                            </div>
                            <button type="button" @click="advanceModal = false" class="p-3 bg-gray-50 rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        {{-- (Same fields as advance modal) --}}
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="advance_payment_method" value="bank" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 transition-all flex flex-col items-center gap-3" :class="paymentMethod === 'bank' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-100'">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Bank</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="advance_payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 transition-all flex flex-col items-center gap-3" :class="paymentMethod === 'cash' ? 'border-emerald-600 bg-emerald-50/50' : 'border-gray-100'">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Cash</span>
                                    </div>
                                </label>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-[2rem] space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="advance_guest_name" x-bind:value="currentRes?.guest_name" required placeholder="Guest Name" class="bg-white border-gray-200 rounded-xl">
                                    <input type="text" name="advance_nic_no" required placeholder="NIC NUMBER" class="bg-white border-gray-200 rounded-xl uppercase">
                                </div>
                                <input type="number" name="advance_amount" step="0.01" required placeholder="Amount (LKR)" class="w-full bg-white border-gray-200 rounded-xl text-lg font-black">
                                <template x-if="paymentMethod === 'bank'">
                                    <div class="space-y-4">
                                        <select name="advance_bank_name" required class="w-full bg-white border-gray-200 rounded-xl">
                                            <option value="">Select Bank...</option>
                                            <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
                                            <option value="People’s Bank">People’s Bank</option>
                                            <option value="Commercial Bank of Ceylon PLC">Commercial Bank of Ceylon PLC</option>
                                            <option value="Hatton National Bank PLC (HNB)">Hatton National Bank PLC (HNB)</option>
                                            <option value="Sampath Bank PLC">Sampath Bank PLC</option>
                                        </select>
                                        <input type="text" name="advance_bank_branch" required placeholder="Branch Name" class="w-full bg-white border-gray-200 rounded-xl">
                                    </div>
                                </template>
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-8 bg-gray-900 text-white py-5 rounded-2xl font-black uppercase tracking-widest">Post Advance Payment</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- FINAL PAYMENT MODAL --}}
        <div x-show="finalPaymentModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/95 backdrop-blur-md" @click="finalPaymentModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <div class="inline-block overflow-hidden transition-all transform bg-white text-left align-middle shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] sm:max-w-xl sm:w-full rounded-[3rem] border border-gray-100"
                     x-show="finalPaymentModal">
                    
                    <form :action="'/admin/front-desk/' + currentRes?.id + '/final-payment'" method="POST" class="p-10">
                        @csrf
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Final Settlement</h3>
                                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mt-1 italic">Total Outstanding Balance Collection</p>
                            </div>
                            <button type="button" @click="finalPaymentModal = false" class="p-3 bg-gray-50 rounded-2xl text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-indigo-900 text-white p-8 rounded-[2rem] flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.2em] mb-1">Total Outstanding</p>
                                    <p class="text-3xl font-black tracking-tighter tabular-nums">LKR <span x-text="remainingBalance.toLocaleString()"></span></p>
                                </div>
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_payment_method" value="bank" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 transition-all flex flex-col items-center gap-3" :class="paymentMethod === 'bank' ? 'border-indigo-600 bg-indigo-50/50' : 'border-gray-100'">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Bank</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="final_payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 transition-all flex flex-col items-center gap-3" :class="paymentMethod === 'cash' ? 'border-emerald-600 bg-emerald-50/50' : 'border-gray-100'">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Cash</span>
                                    </div>
                                </label>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-[2rem] space-y-4 shadow-inner border border-gray-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="final_guest_name" x-bind:value="currentRes?.guest_name" required placeholder="Guest Name" class="bg-white border-gray-200 rounded-xl font-bold text-sm">
                                    <input type="text" name="final_nic_no" x-bind:value="currentRes?.advance_nic_no" required placeholder="NIC NUMBER" class="bg-white border-gray-200 rounded-xl uppercase font-bold text-sm">
                                </div>
                                <input type="number" name="final_payment_amount" step="0.01" x-bind:value="remainingBalance" required placeholder="Amount (LKR)" class="w-full bg-white border-gray-200 rounded-xl text-xl font-black">
                                <template x-if="paymentMethod === 'bank'">
                                    <div class="space-y-4">
                                        <select name="final_bank_name" required class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
                                            <option value="">Select Bank...</option>
                                            <option value="Bank of Ceylon (BOC)">Bank of Ceylon (BOC)</option>
                                            <option value="People’s Bank">People’s Bank</option>
                                            <option value="Commercial Bank of Ceylon PLC">Commercial Bank of Ceylon PLC</option>
                                            <option value="Hatton National Bank PLC (HNB)">Hatton National Bank PLC (HNB)</option>
                                            <option value="Sampath Bank PLC">Sampath Bank PLC</option>
                                        </select>
                                        <input type="text" name="final_bank_branch" required placeholder="Branch Name" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
                                    </div>
                                </template>
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-8 bg-indigo-600 text-white py-6 rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-black transition-all">Clear Balance & Authorize Departure</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
