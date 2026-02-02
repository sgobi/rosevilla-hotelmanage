<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Event Front Desk</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Event Logistics & Financial Settlement</p>
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

            {{-- Summary Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Events Today</p>
                        <p class="text-2xl font-black text-gray-900">{{ $startingToday->count() }}</p>
                    </div>
                </div>

                <div class="bg-white p-7 rounded-[2.5rem] border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
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
                                                    <span class="text-rose-500 font-black tracking-widest uppercase">● Advance Required</span>
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
                                        <button @click="currentRes = {{ json_encode($booking) }}; advanceModal = true" class="bg-amber-500 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-600 transition-all">Collect Advance</button>
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
                                            <button @click="currentRes = {{ json_encode($booking) }}; advanceModal = true" class="w-full bg-amber-500 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-amber-100">Record Advance</button>
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
                                        <a href="{{ route('admin.events.invoice', $booking) }}" target="_blank" class="w-full bg-white text-gray-900 border-2 border-gray-100 py-5 rounded-2xl text-[10px] font-black uppercase text-center">Invoice</a>
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
        <div x-show="advanceModal" class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm" @click="advanceModal = false"></div>
                <div class="relative bg-white rounded-[3rem] max-w-xl w-full p-10 shadow-2xl overflow-hidden">
                    <form :action="'/admin/event-front-desk/' + currentRes?.id + '/advance'" method="POST">
                        @csrf
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-8">Record Event Advance</h3>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="advance_payment_method" value="bank" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 text-center text-[10px] font-black uppercase tracking-widest" :class="paymentMethod === 'bank' ? 'border-indigo-600 bg-indigo-50 text-indigo-900' : 'border-gray-100 text-gray-400'">Bank Transfer</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="advance_payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div class="p-5 rounded-3xl border-2 text-center text-[10px] font-black uppercase tracking-widest" :class="paymentMethod === 'cash' ? 'border-emerald-600 bg-emerald-50 text-emerald-900' : 'border-gray-100 text-gray-400'">Cash Payment</div>
                                </label>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-[2rem] space-y-4">
                                <input type="text" name="advance_guest_name" x-bind:value="currentRes?.customer_name" required placeholder="Payer Name" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
                                <input type="text" name="advance_nic_no" required placeholder="NIC NUMBER" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm uppercase">
                                <input type="number" name="advance_amount" step="0.01" required placeholder="Amount (LKR)" class="w-full bg-white border-gray-200 rounded-xl text-xl font-black">
                                
                                <template x-if="paymentMethod === 'bank'">
                                    <div class="space-y-4">
                                        <select name="advance_bank_name" required class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
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

                        <button type="submit" class="w-full mt-10 bg-gray-900 text-white py-6 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-gray-200">Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Final Modal --}}
        <div x-show="finalPaymentModal" class="fixed inset-0 z-[150] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm" @click="finalPaymentModal = false"></div>
                <div class="relative bg-white rounded-[3rem] max-w-xl w-full p-10 shadow-2xl overflow-hidden">
                    <form :action="'/admin/event-front-desk/' + currentRes?.id + '/final-payment'" method="POST">
                        @csrf
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight mb-2">Event Final Settlement</h3>
                        <p class="text-xs font-bold text-indigo-600 mb-8 uppercase tracking-widest">Post-Event Balance Collection</p>
                        
                        <div class="space-y-6">
                            <div class="bg-indigo-900 text-white p-6 rounded-2xl flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest opacity-50">Balance Due</span>
                                <span class="text-2xl font-black tabular-nums">LKR <span x-text="remainingBalance.toLocaleString()"></span></span>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-[2rem] space-y-4">
                                <input type="text" name="final_guest_name" x-bind:value="currentRes?.customer_name" required placeholder="Payer Name" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
                                <input type="text" name="final_nic_no" x-bind:value="currentRes?.advance_nic_no" required placeholder="NIC NUMBER" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm uppercase">
                                <input type="number" name="final_payment_amount" step="0.01" x-bind:value="remainingBalance" required class="w-full bg-white border-gray-200 rounded-xl text-xl font-black">
                                
                                <select name="final_payment_method" x-model="paymentMethod" class="w-full bg-white border-gray-200 rounded-xl font-bold text-sm">
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash Payment</option>
                                </select>

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
                                        <input type="text" name="final_bank_branch" required placeholder="Branch Name" class="w-full bg-white border-gray-200 rounded-xl">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-10 bg-indigo-600 text-white py-6 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100">Clear Balance & Finalize</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
