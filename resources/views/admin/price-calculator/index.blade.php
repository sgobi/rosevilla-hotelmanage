<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Price Calculator</h2>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mt-1 italic">Quotation Engine & Financial Projections</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3 bg-gray-900 px-5 py-2.5 rounded-2xl border border-gray-800 shadow-sm">
                    <div class="h-10 w-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/50 uppercase tracking-widest leading-none mb-1 text-left">Engine Status</p>
                        <p class="text-xs font-black text-white uppercase tabular-nums">Online</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="priceCalculator()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 print:hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Calculator Type Selection -->
                <div class="md:col-span-1 space-y-4">
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm space-y-6">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Select Module</label>
                            <div class="grid grid-cols-1 gap-2">
                                <button @click="type = 'room'" :class="type === 'room' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100' : 'bg-gray-50 text-gray-500 hover:bg-gray-100'" class="flex items-center gap-4 p-4 rounded-2xl transition-all group">
                                    <div :class="type === 'room' ? 'bg-white/20' : 'bg-white'" class="h-10 w-10 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <span class="text-xs font-black uppercase tracking-widest">Rooms</span>
                                </button>
                                <button @click="type = 'garden'" :class="type === 'garden' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-100' : 'bg-gray-50 text-gray-500 hover:bg-gray-100'" class="flex items-center gap-4 p-4 rounded-2xl transition-all group">
                                    <div :class="type === 'garden' ? 'bg-white/20' : 'bg-white'" class="h-10 w-10 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path></svg>
                                    </div>
                                    <span class="text-xs font-black uppercase tracking-widest">Garden</span>
                                </button>
                                <button @click="type = 'event'" :class="type === 'event' ? 'bg-amber-600 text-white shadow-xl shadow-amber-100' : 'bg-gray-50 text-gray-500 hover:bg-gray-100'" class="flex items-center gap-4 p-4 rounded-2xl transition-all group">
                                    <div :class="type === 'event' ? 'bg-white/20' : 'bg-white'" class="h-10 w-10 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c.533-1.295.796-2.134.796-2.546 0-1.657-1.343-3-3-3m-9 0H3m0 0a3 3 0 013-3h12a3 3 0 013 3m-12 0L9 14h6l.75-4.5M6 10H3a2 2 0 01-2-2V5a2 2 0 012-2h18a2 2 0 012 2v3a2 2 0 01-2 2h-3"></path></svg>
                                    </div>
                                    <span class="text-xs font-black uppercase tracking-widest">Event</span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 space-y-4">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Discount Protocol</label>
                            <div class="relative">
                                <input type="number" x-model="discountPercentage" min="0" max="100" class="w-full border-gray-100 rounded-2xl text-[13px] bg-gray-50 py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold transition-all tabular-nums" placeholder="Percentage %">
                                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-300 tracking-widest">%</span>
                            </div>
                            <p class="text-[9px] text-gray-400 italic px-1 leading-relaxed">Adjustments will be applied to the net total before tax calculation.</p>
                        </div>
                    </div>
                </div>

                <!-- Calculator Body -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm min-h-[500px] flex flex-col">
                        <!-- Type Headers -->
                        <div class="mb-8">
                            <template x-if="type === 'room'">
                                <div>
                                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Room Valuation</h3>
                                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-1">Multi-Room & Duration Aggregator</p>
                                </div>
                            </template>
                            <template x-if="type === 'garden'">
                                <div>
                                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Garden Valuation</h3>
                                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mt-1">Ground Rental & Land Usage Calculation</p>
                                </div>
                            </template>
                            <template x-if="type === 'event'">
                                <div>
                                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Event Valuation</h3>
                                    <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mt-1">Custom Event Scoping & Base Pricing</p>
                                </div>
                            </template>
                        </div>

                        <!-- Form Content -->
                        <div class="flex-1 space-y-10">
                            <!-- Date Inputs (for all types) -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Check In</label>
                                        <input type="date" x-model="checkIn" class="w-full border-gray-100 rounded-2xl text-[13px] bg-gray-50 py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold transition-all uppercase">
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Check Out</label>
                                        <input type="date" x-model="checkOut" class="w-full border-gray-100 rounded-2xl text-[13px] bg-gray-50 py-4 px-6 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-bold transition-all uppercase">
                                    </div>
                                </div>

                            <!-- Room Specific (Now available for all types) -->
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Asset Allocation (Rooms)</label>
                                    <div class="grid grid-cols-1 gap-2 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($rooms as $room)
                                            <label class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all cursor-pointer group"
                                                   :class="roomIds.includes('{{ $room->id }}') ? 'border-indigo-500 bg-indigo-50/30' : 'border-gray-50 bg-gray-50/50 hover:border-gray-200'">
                                                <div class="flex items-center gap-4">
                                                    <input type="checkbox" value="{{ $room->id }}" x-model="roomIds" class="hidden">
                                                    <div :class="roomIds.includes('{{ $room->id }}') ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-200 text-transparent'" class="h-6 w-6 rounded-lg border-2 flex items-center justify-center transition-all">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-black text-gray-900 uppercase">{{ $room->title }}</p>
                                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">{{ $room->subtitle ?? 'Room' }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xs font-black text-indigo-600 tabular-nums">LKR {{ number_format($room->price_per_night, 0) }}</p>
                                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-tighter">Per Night</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                            <!-- Event Specific -->
                            <template x-if="type === 'event'">
                                <div class="space-y-6">
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-amber-600 uppercase tracking-widest px-1">Space Allocation Mode</label>
                                        <label class="flex items-center justify-between p-4 rounded-2xl border-2 transition-all cursor-pointer group"
                                               :class="includeGarden ? 'border-amber-500 bg-amber-50/30' : 'border-gray-50 bg-gray-50/50 hover:border-gray-200'">
                                            <div class="flex items-center gap-4">
                                                <input type="checkbox" x-model="includeGarden" class="hidden">
                                                <div :class="includeGarden ? 'bg-amber-600 border-amber-600 text-white' : 'bg-white border-gray-200 text-transparent'" class="h-6 w-6 rounded-lg border-2 flex items-center justify-center transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-black text-gray-900 uppercase">Include Garden Area</p>
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Automated Garden Pricing Override</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs font-black text-amber-600 tabular-nums">LKR {{ number_format($gardenRate, 0) }}</p>
                                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-tighter">Per Day</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Base Valuation Input</label>
                                        <div class="relative">
                                            <input type="number" x-model="basePrice" class="w-full border-gray-100 rounded-2xl text-2xl bg-gray-50 py-6 px-8 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 font-black transition-all tabular-nums" placeholder="0.00">
                                            <span class="absolute right-8 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-300 tracking-widest uppercase">LKR</span>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex items-start gap-4 italic text-gray-400 text-xs leading-relaxed">
                                        <svg class="w-5 h-5 flex-shrink-0 text-amber-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p>Manual base price entry for modular event packages. Tax and discounts will be automatically computed based on this input.</p>
                                    </div>
                                    
                                    <div class="space-y-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center justify-between">
                                            <label class="text-[10px] font-black text-amber-600 uppercase tracking-widest px-1">Additional Services</label>
                                            <button @click="addService()" class="text-[10px] font-bold text-amber-600 bg-amber-50 hover:bg-amber-100 px-3 py-1 rounded-xl transition-colors uppercase tracking-widest">+ Add</button>
                                        </div>
                                        <div class="space-y-3">
                                            <template x-for="(service, index) in additionalServices" :key="index">
                                                <div class="flex items-center gap-3">
                                                    <input type="text" x-model="service.type" @change="calculate()" placeholder="Service Type (e.g. Catering)" class="w-full border-gray-100 rounded-xl text-xs bg-gray-50 py-3 px-4 focus:ring-2 focus:ring-amber-500/10 focus:border-amber-500 font-bold transition-all">
                                                    <div class="relative w-48 shrink-0">
                                                        <input type="number" x-model="service.price" @change="calculate()" placeholder="Price" class="w-full border-gray-100 rounded-xl text-xs bg-gray-50 py-3 px-4 focus:ring-2 focus:ring-amber-500/10 focus:border-amber-500 font-bold transition-all tabular-nums text-right">
                                                    </div>
                                                    <button @click="removeService(index)" class="shrink-0 p-3 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </template>
                                            <template x-if="additionalServices.length === 0">
                                                <p class="text-[10px] text-gray-400 italic px-2">No additional services added yet. Press add.</p>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Real-time Financial Display -->
                        <div class="mt-12 pt-10 border-t-2 border-dashed border-gray-100 space-y-4">
                            <div class="flex justify-between items-center px-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Net Assets Total</span>
                                <span class="text-xs font-black text-gray-900 tabular-nums" x-text="formatCurrency(results.total_price)">LKR 0.00</span>
                            </div>
                            <template x-if="results.discount_amount > 0">
                                <div class="flex justify-between items-center px-2">
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] flex items-center gap-2">
                                        Discount Correction
                                        <span class="px-1.5 py-0.5 bg-emerald-100 rounded text-[8px]" x-text="'-' + discountPercentage + '%'"></span>
                                    </span>
                                    <span class="text-xs font-black text-emerald-600 tabular-nums" x-text="'- ' + formatCurrency(results.discount_amount)">LKR 0.00</span>
                                </div>
                            </template>
                            <div class="flex justify-between items-center px-2">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]" x-text="'Service Tax (' + results.tax_rate + '%)'">Service Tax</span>
                                <span class="text-xs font-black text-gray-900 tabular-nums" x-text="'+ ' + formatCurrency(results.tax_amount)">LKR 0.00</span>
                            </div>
                            
                            <div class="bg-gray-900 rounded-[2rem] p-8 mt-6 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl relative overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="relative">
                                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.4em] leading-none mb-2">Final Quotation Value</p>
                                    <p class="text-xs text-white/40 italic">Aggregated terminal projection</p>
                                </div>
                                <div class="relative text-right">
                                    <p class="text-3xl font-black text-white tracking-tighter tabular-nums" x-text="formatCurrency(results.final_price)">LKR 0.00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Details Log -->
                        <template x-if="results.details && results.details.length > 0">
                            <div class="mt-8 space-y-3">
                                <label class="text-[10px] font-black text-gray-300 uppercase tracking-widest px-2">Computation Log</label>
                                <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100 space-y-1">
                                    <template x-for="detail in results.details">
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest tabular-nums flex items-center gap-2">
                                            <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                            <span x-text="detail"></span>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Print Trigger Button -->
            <div class="mt-8 flex justify-center print:hidden">
                <button @click="window.print()" class="bg-indigo-600 border-4 border-indigo-200 text-white px-8 py-4 rounded-3xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all flex items-center gap-3 shadow-[0_20px_40px_-15px_rgba(79,70,229,0.5)] group">
                    <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Quotation Document
                </button>
            </div>
        </div>

        <!-- Print Area -->
        <div id="print-area" class="hidden font-sans w-full max-w-4xl mx-auto p-0 bg-white text-black">
            <!-- Printing Header -->
            <div class="border-b-4 border-black pb-8 mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-4xl font-black uppercase tracking-tighter">Rosevilla</h1>
                    <h2 class="text-2xl font-bold uppercase tracking-widest text-gray-500">Official Quotation</h2>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest" x-text="'Date: ' + new Date().toLocaleDateString()"></p>
                    <p class="text-xs font-bold text-gray-500 mt-1 uppercase tracking-widest" x-text="'Module: ' + type"></p>
                </div>
            </div>

            <!-- Parameters -->
            <div class="mb-8">
                <h3 class="text-sm font-black uppercase tracking-widest border-b-2 border-gray-200 pb-2 mb-4 text-gray-400">Calculation Parameters</h3>
                <div class="grid grid-cols-1 gap-4 text-sm font-bold">
                    <p><span class="text-gray-500 uppercase tracking-widest text-[10px] block mb-1">Duration Window:</span> <span class="text-base" x-text="checkIn + '  to  ' + checkOut"></span></p>
                </div>
            </div>

            <!-- Breakdown -->
            <div class="mb-8">
                <h3 class="text-sm font-black uppercase tracking-widest border-b-2 border-gray-200 pb-2 mb-4 text-gray-400">Cost Breakdown Details</h3>
                <ul class="space-y-4 font-mono text-sm leading-relaxed tracking-tight break-all text-gray-800">
                    <template x-for="detail in results.details">
                        <li class="flex gap-4">
                            <span class="text-indigo-500 opacity-50">►</span>
                            <span x-text="detail"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <!-- Financial Summary -->
            <div class="border-t-4 border-black pt-8 break-inside-avoid">
                <div class="space-y-3 text-right font-mono text-sm tracking-tight mb-8">
                    <p><span class="inline-block w-48 text-gray-500 uppercase font-sans font-bold text-[10px] tracking-widest">Net Asset Total:</span> <span class="inline-block w-32 font-black" x-text="formatCurrency(results.total_price)"></span></p>
                    <template x-if="results.discount_amount > 0">
                        <p><span class="inline-block w-48 text-gray-500 uppercase font-sans font-bold text-[10px] tracking-widest" x-text="'Discount (' + discountPercentage + '%):'"></span> <span class="inline-block w-32 text-red-600 font-bold" x-text="'- ' + formatCurrency(results.discount_amount)"></span></p>
                    </template>
                    <p><span class="inline-block w-48 text-gray-500 uppercase font-sans font-bold text-[10px] tracking-widest" x-text="'Service Tax (' + results.tax_rate + '%):'"></span> <span class="inline-block w-32 font-bold" x-text="'+ ' + formatCurrency(results.tax_amount)"></span></p>
                </div>

                <div class="bg-gray-100 p-8 rounded-3xl flex justify-between items-center print-final break-inside-avoid">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 mb-1">Final Agreed</p>
                        <p class="text-xl font-black uppercase tracking-tighter text-gray-900">Total Quotation Value</p>
                    </div>
                    <p class="text-3xl font-black tabular-nums tracking-tighter" x-text="formatCurrency(results.final_price)"></p>
                </div>
            </div>
            
            <div class="mt-8 text-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 border-t-2 border-dashed border-gray-200 pt-8 break-inside-avoid">
                <p>Eligible within 5 days. After that, this quotation will vary.</p>
            </div>
        </div>
    </div>

    <script>
        function priceCalculator() {
            return {
                type: 'room',
                checkIn: new Date().toISOString().split('T')[0],
                checkOut: new Date().toISOString().split('T')[0],
                roomIds: [],
                basePrice: 0,
                discountPercentage: 0,
                includeGarden: false,
                additionalServices: [],
                results: {
                    total_price: 0,
                    discount_amount: 0,
                    taxable_amount: 0,
                    tax_amount: 0,
                    final_price: 0,
                    details: [],
                    tax_rate: {{ $taxRate }}
                },

                init() {
                    this.$watch('type', () => this.calculate());
                    this.$watch('checkIn', () => this.calculate());
                    this.$watch('checkOut', () => this.calculate());
                    this.$watch('roomIds', () => this.calculate());
                    this.$watch('basePrice', () => this.calculate());
                    this.$watch('discountPercentage', () => this.calculate());
                    this.$watch('includeGarden', () => this.calculate());
                    
                    // We watch changes on individual elements via @change in inputs for deep objects
                    
                    this.calculate();
                },

                addService() {
                    this.additionalServices.push({ type: '', price: '' });
                },

                removeService(index) {
                    this.additionalServices.splice(index, 1);
                    this.calculate();
                },

                async calculate() {
                    try {
                        const response = await fetch('{{ route("admin.price-calculator.calculate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: this.type,
                                check_in: this.checkIn,
                                check_out: this.checkOut,
                                room_ids: this.roomIds,
                                include_garden: this.includeGarden,
                                base_price: this.basePrice,
                                discount_percentage: this.discountPercentage,
                                additional_services: this.additionalServices
                            })
                        });
                        if (response.ok) {
                            this.results = await response.json();
                        }
                    } catch (error) {
                        console.error('Calculation error:', error);
                    }
                },

                formatCurrency(value) {
                    return new Intl.NumberFormat('en-LK', {
                        style: 'currency',
                        currency: 'LKR',
                        minimumFractionDigits: 2
                    }).format(value);
                }
            }
        }
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
                padding: 1cm 2cm !important;
            }
            .print-final {
                background-color: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            @page { margin: 0; }
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</x-app-layout>
