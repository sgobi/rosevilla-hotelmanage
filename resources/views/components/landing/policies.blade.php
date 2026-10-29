<!-- POLICIES (ACCORDION) -->
<section id="policies" class="py-20 px-6 lg:px-12 bg-stoneBeige/30 border-y border-stoneBeige/60 scroll-mt-20">
    <div class="max-w-4xl mx-auto" x-data="{ activeAccordion: 1 }">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">
                {{ __('Stay Guidelines') }}
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">
                {{ __('Guest Policies & Booking Terms') }}
            </h2>
            <p class="text-darkText/70 text-sm leading-relaxed">
                {{ __('Transparent terms designed to ensure a tranquil, safe, and memorable stay for every guest at Rose Villa.') }}
            </p>
        </div>

        <div class="space-y-4">
            <!-- 1. Check-in & Check-out -->
            <div class="bg-creamBg rounded-2xl border border-stoneBeige overflow-hidden shadow-sm transition-all duration-200">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 1 ? null : 1" 
                        class="w-full px-6 py-4.5 text-left flex items-center justify-between font-serif font-bold text-base sm:text-lg text-heritageGreen hover:text-roseRed transition-colors focus:outline-none"
                        :aria-expanded="activeAccordion === 1">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-clock-rotate-left text-roseRed text-base"></i>
                        <span>{{ __('Check-in & Check-out Times') }}</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-darkText/50"
                       :class="{ 'rotate-180': activeAccordion === 1 }"></i>
                </button>
                <div x-show="activeAccordion === 1" 
                     x-cloak 
                     x-collapse 
                     class="px-6 pb-6 pt-1 text-sm text-darkText/80 leading-relaxed border-t border-stoneBeige/50 space-y-2">
                    <p>
                        <strong class="text-heritageGreen">{{ __('Standard Check-in:') }}</strong>
                        <span class="bg-amber-100 text-amber-900 px-2 py-0.5 rounded font-mono text-xs font-semibold">[EDIT: check-in time — e.g. 2:00 PM]</span>
                    </p>
                    <p>
                        <strong class="text-heritageGreen">{{ __('Standard Check-out:') }}</strong>
                        <span class="bg-amber-100 text-amber-900 px-2 py-0.5 rounded font-mono text-xs font-semibold">[EDIT: check-out time — e.g. 11:00 AM]</span>
                    </p>
                    <p class="text-xs text-darkText/70 pt-1">
                        {{ __('Early check-in and late check-out requests are subject to room availability. Please let us know your travel schedule so our front desk can prepare your welcome accordingly.') }}
                    </p>
                </div>
            </div>

            <!-- 2. Cancellation Policy -->
            <div class="bg-creamBg rounded-2xl border border-stoneBeige overflow-hidden shadow-sm transition-all duration-200">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 2 ? null : 2" 
                        class="w-full px-6 py-4.5 text-left flex items-center justify-between font-serif font-bold text-base sm:text-lg text-heritageGreen hover:text-roseRed transition-colors focus:outline-none"
                        :aria-expanded="activeAccordion === 2">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-calendar-xmark text-roseRed text-base"></i>
                        <span>{{ __('Cancellation & Refund Policy') }}</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-darkText/50"
                       :class="{ 'rotate-180': activeAccordion === 2 }"></i>
                </button>
                <div x-show="activeAccordion === 2" 
                     x-cloak 
                     x-collapse 
                     class="px-6 pb-6 pt-1 text-sm text-darkText/80 leading-relaxed border-t border-stoneBeige/50 space-y-3">
                    <div class="bg-amber-50/80 border border-amber-200/80 rounded-xl p-3 text-xs text-amber-900 font-mono">
                        [EDIT: cancellation policy — e.g. Free cancellation up to 48 hours prior to scheduled arrival date. Cancellations made within 48 hours of check-in, or failure to arrive (no-show), may incur a fee equal to the first night's rate. For whole-villa or garden event bookings, cancellation terms will be detailed in your confirmation invoice.]
                    </div>
                    <p class="text-xs text-darkText/70">
                        {{ __('To request a cancellation or change of booking dates, please reach out to our concierge via WhatsApp or email with your reservation reference number.') }}
                    </p>
                </div>
            </div>

            <!-- 3. Payment & Deposit -->
            <div class="bg-creamBg rounded-2xl border border-stoneBeige overflow-hidden shadow-sm transition-all duration-200">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 3 ? null : 3" 
                        class="w-full px-6 py-4.5 text-left flex items-center justify-between font-serif font-bold text-base sm:text-lg text-heritageGreen hover:text-roseRed transition-colors focus:outline-none"
                        :aria-expanded="activeAccordion === 3">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-credit-card text-roseRed text-base"></i>
                        <span>{{ __('Payment & Deposit Terms') }}</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-darkText/50"
                       :class="{ 'rotate-180': activeAccordion === 3 }"></i>
                </button>
                <div x-show="activeAccordion === 3" 
                     x-cloak 
                     x-collapse 
                     class="px-6 pb-6 pt-1 text-sm text-darkText/80 leading-relaxed border-t border-stoneBeige/50 space-y-3">
                    <div class="bg-amber-50/80 border border-amber-200/80 rounded-xl p-3 text-xs text-amber-900 font-mono">
                        [EDIT: payment and deposit — e.g. A 30% advance deposit is required to confirm reservation dates. The remaining balance can be settled upon check-in via Cash (LKR, USD, EUR, GBP) or local bank transfer. Official proforma receipts and tax invoices are provided upon request.]
                    </div>
                    <p class="text-xs text-darkText/70">
                        {{ __('Accepted payment methods include bank wire transfer, online payment links, and cash settlement at front desk.') }}
                    </p>
                </div>
            </div>

            <!-- 4. Rates Include / Exclude Taxes -->
            <div class="bg-creamBg rounded-2xl border border-stoneBeige overflow-hidden shadow-sm transition-all duration-200">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 4 ? null : 4" 
                        class="w-full px-6 py-4.5 text-left flex items-center justify-between font-serif font-bold text-base sm:text-lg text-heritageGreen hover:text-roseRed transition-colors focus:outline-none"
                        :aria-expanded="activeAccordion === 4">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-receipt text-roseRed text-base"></i>
                        <span>{{ __('Rates Include / Exclude Taxes') }}</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 text-darkText/50"
                       :class="{ 'rotate-180': activeAccordion === 4 }"></i>
                </button>
                <div x-show="activeAccordion === 4" 
                     x-cloak 
                     x-collapse 
                     class="px-6 pb-6 pt-1 text-sm text-darkText/80 leading-relaxed border-t border-stoneBeige/50 space-y-3">
                    <div class="bg-amber-50/80 border border-amber-200/80 rounded-xl p-3 text-xs text-amber-900 font-mono">
                        [EDIT: rates include/exclude taxes — e.g. All published rates on our website are inclusive of applicable local municipal charges and standard service fees. Daily traditional breakfast and Wi-Fi are fully included. Custom excursions, private van transfers, and bespoke banquet dinners are billed separately.]
                    </div>
                    <p class="text-xs text-darkText/70">
                        {{ __('Detailed breakdown of any additional services or requested customizations will always be itemized in advance on your booking proforma.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-darkText/60">
            <span>{{ __('Have a special request or inquiry regarding our policies?') }}</span>
            <a href="https://wa.me/{{ config('rosevilla.whatsapp_number', '94765692476') }}" 
               target="_blank" 
               class="text-heritageGreen font-semibold hover:underline ml-1">
                {{ __('Speak with our concierge on WhatsApp') }} &rarr;
            </a>
        </div>
    </div>
</section>

