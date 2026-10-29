@props(['content' => null])

@php
    $amenities = [
        [
            'icon' => 'fa-solid fa-wifi',
            'title' => __('High-Speed Wi-Fi'),
            'desc' => __('Seamless wireless internet coverage throughout the villa and courtyard gardens.'),
        ],
        [
            'icon' => 'fa-solid fa-snowflake',
            'title' => __('Air-Conditioning or Fan'),
            'desc' => __('Climate-controlled comfort with quiet split AC and ceiling fans in every room.'),
        ],
        [
            'icon' => 'fa-solid fa-square-parking',
            'title' => __('Free Parking'),
            'desc' => __('Complimentary secure on-site vehicle and van parking for staying guests.'),
        ],
        [
            'icon' => 'fa-solid fa-plane-arrival',
            'title' => __('Airport & Travel Transfers'),
            'desc' => __('Dedicated transfers to/from Jaffna, Colombo International Airport, Jaffna Bus Stand or Jaffna Railway Station'),
        ],
        [
            'icon' => 'fa-solid fa-utensils',
            'title' => __('Traditional Breakfast Included'),
            'desc' => __('Freshly prepared Jaffna hoppers, coconut sambol, local fruit, and Ceylon tea/coffee.'),
        ],
    ];
@endphp

<!-- AMENITIES & CONVENIENCES -->
<section id="amenities" class="py-20 px-6 lg:px-12 bg-creamBg scroll-mt-20 border-b border-stoneBeige/50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">
                {{ __('Comfort & Hospitality') }}
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">
                {{ __('Essential Villa Amenities') }}
            </h2>
            <p class="text-darkText/70 text-sm leading-relaxed">
                {{ __('Thoughtfully curated services designed to combine historic character with modern, effortless comfort.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($amenities as $item)
                <div class="bg-stoneBeige/40 rounded-3xl p-6 border border-stoneBeige/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-heritageGreen/10 group-hover:bg-heritageGreen group-hover:text-white text-heritageGreen flex items-center justify-center text-xl mb-4 transition-colors duration-300 shadow-inner">
                            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-serif font-bold text-base text-heritageGreen mb-2 group-hover:text-darkText transition-colors">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-xs text-darkText/70 leading-relaxed">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach

            <!-- Bespoke Requests Card -->
            <div class="bg-gradient-to-br from-heritageGreen to-heritageGreen/90 text-white rounded-3xl p-6 shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center text-xl mb-4 backdrop-blur-md">
                        <i class="fa-solid fa-bell-concierge" aria-hidden="true"></i>
                    </div>
                    <h3 class="font-serif font-bold text-base text-white mb-2">
                        {{ __('Personal Concierge') }}
                    </h3>
                    <p class="text-xs text-creamBg/80 leading-relaxed">
                        {{ __('Need a customized tour, bicycle rental, or specific dietary arrangement? Our host team is happy to assist.') }}
                    </p>
                </div>
                <div class="pt-4 mt-2 border-t border-white/20">
                    <a href="https://wa.me/{{ config('rosevilla.whatsapp_number', '94765692476') }}" 
                       target="_blank" 
                       class="text-xs font-semibold text-antiqueGold hover:text-white inline-flex items-center gap-1.5 transition-colors">
                        <span>{{ __('Inquire on WhatsApp') }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

