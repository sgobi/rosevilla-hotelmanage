<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="p-2 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition-all shadow-sm group">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Console</a>
                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('admin.events.index') }}" class="hover:text-indigo-600 transition-colors">Bookings</a>
                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-indigo-600">Reference #{{ str_pad($event->id, 5, '0', STR_PAD_LEFT) }}</span>
                </nav>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none uppercase">Booking Details</h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto pb-24 pt-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="relative overflow-hidden bg-slate-900 rounded-[3rem] p-8 sm:p-12 mb-8 shadow-2xl shadow-slate-200 border border-white/10 animate-in fade-in zoom-in duration-700">
            <!-- Abstract Background -->
            <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 bg-indigo-500/10 blur-[100px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-64 h-64 bg-emerald-500/10 blur-[80px] rounded-full"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full border border-white/5 shadow-inner">
                        <span class="h-1.5 w-1.5 rounded-full 
                            @if($event->status === 'approved') bg-emerald-400
                            @elseif($event->status === 'cancelled' || $event->status === 'rejected') bg-rose-400
                            @else bg-amber-400 animate-pulse @endif"></span>
                        <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ $event->status }} Booking</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight uppercase leading-none">
                        {{ $event->customer_name }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-sm font-bold">{{ $event->address ?? 'No address provided' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if($event->status === 'approved')
                        <a href="{{ route('admin.events.invoice', $event) }}" target="_blank" class="flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/20 active:scale-95 border-2 border-transparent hover:border-indigo-600">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Proforma
                        </a>
                    @endif
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = true" class="p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 transition-colors group">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                        <!-- Small Menu -->
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 animate-in fade-in slide-in-from-top-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="flex items-center gap-3 px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-colors border-b border-slate-50">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Modify Record
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-2 sm:px-0">
            <!-- Left Side: Core Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Event Scheduling -->
                <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100/50 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Schedule & Timing</h3>
                                <p class="text-[9px] font-black text-indigo-500 uppercase tracking-[0.2em] mt-1">Calendar Assignment</p>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest border border-indigo-100/50">
                            {{ $event->event_type }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 relative z-10">
                        <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100/50 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Event Date Period</label>
                            <div class="flex items-center gap-3">
                                <span class="text-xl font-black text-slate-800">{{ optional($event->event_date)->format('M d, Y') }}</span>
                                @if($event->check_out && $event->event_date && $event->check_out->ne($event->event_date))
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="text-xl font-black text-slate-800">{{ $event->check_out->format('M d, Y') }}</span>
                                @endif
                            </div>
                            <p class="text-[10px] font-bold text-slate-500 italic">{{ $event->duration }} Day(s) Reservation</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100/50 space-y-2 text-center">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Start</label>
                                <span class="text-sm font-black text-slate-800 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                            </div>
                            <div class="p-6 bg-rose-50/30 rounded-3xl border border-rose-100/30 space-y-2 text-center">
                                <label class="text-[10px] font-black text-rose-400 uppercase tracking-widest block">End</label>
                                <span class="text-sm font-black text-slate-800 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between p-6 bg-slate-900 rounded-[2rem] text-white">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/5">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest leading-none mb-1">Guest Occupancy</p>
                                <span class="text-lg font-black tracking-tight leading-none">{{ $event->guests }} ATTENDEES</span>
                            </div>
                        </div>
                        @if($event->arrival_time)
                            <div class="text-right">
                                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest leading-none mb-1">Host Arrival</p>
                                <span class="text-lg font-black tracking-tight leading-none uppercase">{{ \Carbon\Carbon::parse($event->arrival_time)->format('h:i A') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Venue Selection Section -->
                <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100/50 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Venue Assignment</h3>
                            <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mt-1">Property Distribution</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if($event->garden_selection)
                            <div class="group flex items-center justify-between p-6 bg-emerald-50/50 rounded-3xl border border-emerald-100/50 transition-all hover:border-emerald-200">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl bg-white text-emerald-600 flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-800 uppercase tracking-tight">Garden & Grounds</h4>
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Outdoor Event Space</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-emerald-600 uppercase tracking-widest bg-white px-3 py-1 rounded-lg border border-emerald-100">LKR {{ number_format($event->garden_price_per_day, 2) }} /Day</span>
                                </div>
                            </div>
                        @endif

                        @forelse($event->rooms_list as $room)
                            <div class="group flex items-center justify-between p-6 bg-slate-50/50 rounded-3xl border border-slate-100 transition-all hover:border-indigo-100">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl bg-white text-indigo-600 flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-800 uppercase tracking-tight">{{ $room->title }}</h4>
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Indoor Accommodation</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest bg-white px-3 py-1 rounded-lg border border-indigo-100">LKR {{ number_format($room->price_per_night, 2) }} /Night</span>
                                </div>
                            </div>
                        @empty
                            @if(!$event->garden_selection)
                                <div class="p-10 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                    <p class="text-xs font-black text-slate-300 uppercase tracking-[0.2em]">No specific venue areas assigned</p>
                                </div>
                            @endif
                        @endforelse
                    </div>
                </div>

                <!-- Additional Services -->
                @if(!empty($event->additional_services))
                    <div class="bg-indigo-600 rounded-[2.5rem] p-8 sm:p-10 shadow-xl shadow-indigo-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/5 blur-3xl rounded-full"></div>
                        
                        <div class="flex items-center gap-4 mb-8 relative z-10">
                            <div class="h-12 w-12 rounded-2xl bg-white/10 text-white flex items-center justify-center border border-white/20 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-white uppercase tracking-tight">Ancillary Services</h3>
                                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-[0.2em] mt-1">Requested Extras</p>
                            </div>
                        </div>

                        <div class="space-y-3 relative z-10">
                            @foreach($event->additional_services as $service)
                                <div class="flex items-center justify-between p-5 bg-white/10 backdrop-blur-md rounded-2xl border border-white/5 transition-all hover:bg-white/15">
                                    <span class="text-xs font-black text-white uppercase tracking-widest">{{ $service['type'] }}</span>
                                    <span class="text-xs font-black text-white bg-slate-900/40 px-3 py-1.5 rounded-xl border border-white/10 tabular-nums">LKR {{ number_format($service['price'], 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Notes Section -->
                @if($event->message)
                    <div class="bg-slate-50 border border-slate-100 rounded-[2.5rem] p-8 sm:p-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Customer Provisions & Notes</h4>
                        </div>
                        <div class="text-sm font-bold text-slate-600 leading-relaxed italic border-l-4 border-indigo-500/20 pl-6 py-2 bg-white rounded-r-3xl rounded-l-md pr-8">
                            "{{ $event->message }}"
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Side: Contact & Billing -->
            <div class="space-y-8">
                <!-- Contact Card -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 -mr-16 -mt-16 rounded-full"></div>
                    
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8 relative z-10">Point of Contact</h3>
                    
                    <div class="space-y-6 relative z-10">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mt-0.5 border border-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Electronic</p>
                                <p class="text-sm font-black text-slate-800 truncate">{{ $event->customer_email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mt-0.5 border border-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tele-Communication</p>
                                <p class="text-sm font-black text-slate-800 tracking-wider">{{ $event->customer_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Ledger -->
                <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200 border border-white/10">
                    <h3 class="text-xs font-black text-white/30 uppercase tracking-[0.2em] mb-8">Financial Ledger</h3>
                    
                    <div class="space-y-4 mb-8 text-xs font-bold text-slate-300">
                        <div class="flex justify-between items-center group">
                            <span class="text-slate-500 group-hover:text-slate-400 transition-colors uppercase tracking-widest text-[10px]">Venue Selection Subtotal</span>
                            <span class="text-white">LKR {{ number_format($event->venue_total_price, 2) }}</span>
                        </div>

                        @if($event->total_price > 0)
                            <div class="flex justify-between items-center group">
                                <span class="text-slate-500 group-hover:text-slate-400 transition-colors uppercase tracking-widest text-[10px]">Additional Quoted Rate</span>
                                <span class="text-white">LKR {{ number_format($event->total_price, 2) }}</span>
                            </div>
                        @endif

                        @if(!empty($event->additional_services))
                            <div class="flex justify-between items-center group">
                                <span class="text-slate-500 group-hover:text-slate-400 transition-colors uppercase tracking-widest text-[10px]">Service Total</span>
                                <span class="text-white">LKR {{ number_format($event->additional_services_total_price, 2) }}</span>
                            </div>
                        @endif

                        @if($event->discount_amount > 0)
                            <div class="flex justify-between items-center text-emerald-400">
                                <span class="uppercase tracking-widest text-[10px]">Applied Rebate ({{ number_format($event->discount_percentage, 1) }}%)</span>
                                <span>- LKR {{ number_format($event->discount_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center border-t border-white/5 pt-4 mt-4">
                            <span class="text-slate-500 uppercase tracking-widest text-[10px]">Tax Allocation ({{ number_format($event->tax_percentage, 1) }}%)</span>
                            <span class="text-white">+ LKR {{ number_format($event->tax_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="bg-indigo-600 rounded-3xl p-6 text-center space-y-1 shadow-lg shadow-indigo-600/30">
                        <p class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.2em]">Grand Settled Total</p>
                        <p class="text-2xl font-black text-white leading-none">LKR {{ number_format($event->final_price, 2) }}</p>
                    </div>
                    
                    @if($event->advance_amount > 0)
                        <div class="mt-6 p-6 bg-white/5 rounded-3xl border border-white/10 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Initial Deposit</span>
                                <span class="text-sm font-black text-emerald-400">- LKR {{ number_format($event->advance_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-white/5 pt-4">
                                <span class="text-[10px] font-black text-white uppercase tracking-widest">Balance Payable</span>
                                <span class="text-lg font-black text-amber-400">LKR {{ number_format($event->final_price - $event->advance_amount, 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Operations Panel --}}
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Operations Panel</h3>

                    {{-- Status Override --}}
                    @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && !in_array($event->status, ['approved', 'cancelled'])))
                        <div x-data="{ status: '{{ $event->status }}' }" class="space-y-3">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Override Status</label>
                            <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-3">
                                @csrf @method('PATCH')
                                <select x-model="status" name="status" class="w-full border-slate-100 rounded-2xl text-xs bg-slate-50 py-3 px-4 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-bold transition-all">
                                    @foreach(['pending','approved','rejected','cancelled'] as $s)
                                        <option value="{{ $s }}" @selected($event->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <div x-show="status === 'cancelled'" x-transition>
                                    <textarea name="cancellation_reason" rows="2" class="w-full border-slate-100 rounded-2xl text-xs bg-rose-50/30 py-3 px-4 focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 font-bold transition-all placeholder:text-rose-200" placeholder="Reason for cancellation..."></textarea>
                                </div>
                                <button class="w-full bg-slate-900 text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all active:scale-95">
                                    Apply Status
                                </button>
                            </form>
                        </div>
                        <div class="border-t border-slate-50"></div>
                    @endif

                    {{-- Cancellation Reason --}}
                    @if($event->status === 'cancelled' && $event->cancellation_reason)
                        <div class="p-5 bg-rose-50 rounded-2xl border border-rose-100 space-y-2">
                            <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest">Cancellation Reason</p>
                            <p class="text-xs font-bold text-rose-700 italic leading-relaxed">{{ $event->cancellation_reason }}</p>
                        </div>
                        <div class="border-t border-slate-50"></div>
                    @endif

                    {{-- Conflict Note --}}
                    @if($event->conflict_status && $event->conflict_status !== 'none' && $event->conflict_note)
                        <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100 space-y-2">
                            <p class="text-[9px] font-black text-amber-500 uppercase tracking-widest">Conflict Override Note</p>
                            <p class="text-xs font-bold text-amber-700 italic leading-relaxed">{{ $event->conflict_note }}</p>
                        </div>
                        <div class="border-t border-slate-50"></div>
                    @endif

                    {{-- Invoice Actions --}}
                    @if($event->status === 'approved')
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Invoice Actions</label>
                            @php
                                $canPrint = auth()->user()->isAdmin() || ($event->invoice_print_count == 0 || $event->invoice_reprint_status === 'approved');
                            @endphp
                            @if($canPrint)
                                <a href="{{ route('admin.events.invoice', $event) }}" target="_blank"
                                   class="flex items-center gap-3 w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Print Invoice
                                </a>
                            @endif
                            <a href="{{ route('admin.events.proforma', $event) }}" target="_blank"
                               class="flex items-center gap-3 w-full px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Proforma Invoice
                            </a>
                        </div>
                        <div class="border-t border-slate-50"></div>
                    @endif

                    {{-- Advance Payment --}}
                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full {{ $event->advance_paid_at ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                            Advance Payment
                        </label>
                        @if($event->advance_paid_at)
                            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 space-y-2 text-xs">
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Amount</span>
                                    <span class="text-emerald-700 font-black">LKR {{ number_format($event->advance_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Method</span>
                                    <span class="text-slate-700 uppercase">{{ $event->advance_payment_method }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Guest</span>
                                    <span class="text-slate-700">{{ $event->advance_guest_name }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">NIC</span>
                                    <span class="text-slate-700">{{ $event->advance_nic_no }}</span>
                                </div>
                                @if($event->advance_bank_name)
                                    <div class="flex justify-between font-bold">
                                        <span class="text-slate-500">Bank</span>
                                        <span class="text-slate-700">{{ $event->advance_bank_name }} @if($event->advance_bank_branch)/ {{ $event->advance_bank_branch }}@endif</span>
                                    </div>
                                @endif
                                <div class="pt-1 border-t border-emerald-100 text-[10px] text-emerald-600 font-bold">
                                    Paid: {{ $event->advance_paid_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        @else
                            <p class="text-[10px] text-slate-400 font-bold italic px-1">No advance payment recorded.</p>
                        @endif
                    </div>

                    {{-- Final Payment --}}
                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full {{ $event->final_payment_at ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                            Final Payment
                        </label>
                        @if($event->final_payment_at)
                            <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 space-y-2 text-xs">
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Amount</span>
                                    <span class="text-emerald-700 font-black">LKR {{ number_format($event->final_payment_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Method</span>
                                    <span class="text-slate-700 uppercase">{{ $event->final_payment_method }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">Guest</span>
                                    <span class="text-slate-700">{{ $event->final_guest_name }}</span>
                                </div>
                                <div class="flex justify-between font-bold">
                                    <span class="text-slate-500">NIC</span>
                                    <span class="text-slate-700">{{ $event->final_nic_no }}</span>
                                </div>
                                @if($event->final_bank_name)
                                    <div class="flex justify-between font-bold">
                                        <span class="text-slate-500">Bank</span>
                                        <span class="text-slate-700">{{ $event->final_bank_name }} @if($event->final_bank_branch)/ {{ $event->final_bank_branch }}@endif</span>
                                    </div>
                                @endif
                                <div class="pt-1 border-t border-emerald-100 text-[10px] text-emerald-600 font-bold">
                                    Paid: {{ $event->final_payment_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        @else
                            <p class="text-[10px] text-slate-400 font-bold italic px-1">No final payment recorded.</p>
                        @endif
                    </div>

                    {{-- Check-in / Check-out Timestamps --}}
                    <div class="border-t border-slate-50 pt-6 space-y-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Event Lifecycle</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-4 {{ $event->checked_in_at ? 'bg-indigo-50 border-indigo-100' : 'bg-slate-50 border-slate-100' }} rounded-2xl border text-center space-y-1">
                                <p class="text-[9px] font-black {{ $event->checked_in_at ? 'text-indigo-500' : 'text-slate-400' }} uppercase tracking-widest">Started</p>
                                @if($event->checked_in_at)
                                    <p class="text-[10px] font-black text-indigo-700 leading-tight">{{ $event->checked_in_at->format('M d') }}</p>
                                    <p class="text-[10px] font-bold text-indigo-600">{{ $event->checked_in_at->format('H:i') }}</p>
                                @else
                                    <p class="text-[10px] text-slate-300 font-bold italic">Pending</p>
                                @endif
                            </div>
                            <div class="p-4 {{ $event->checked_out_at ? 'bg-emerald-50 border-emerald-100' : 'bg-slate-50 border-slate-100' }} rounded-2xl border text-center space-y-1">
                                <p class="text-[9px] font-black {{ $event->checked_out_at ? 'text-emerald-500' : 'text-slate-400' }} uppercase tracking-widest">Completed</p>
                                @if($event->checked_out_at)
                                    <p class="text-[10px] font-black text-emerald-700 leading-tight">{{ $event->checked_out_at->format('M d') }}</p>
                                    <p class="text-[10px] font-bold text-emerald-600">{{ $event->checked_out_at->format('H:i') }}</p>
                                @else
                                    <p class="text-[10px] text-slate-300 font-bold italic">Pending</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terminal Info -->
                <div class="text-center space-y-3 px-8">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">System Authentication Integrity</p>
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                        <p class="text-[9px] font-bold text-slate-400 leading-none">Record Logged: {{ optional($event->created_at)->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
