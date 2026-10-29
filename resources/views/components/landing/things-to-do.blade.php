@php
    $whatsappNumber = config('rosevilla.whatsapp_number', '94765692476');
    $activities = [
        [
            'title' => __('Nallur Kandaswamy Temple'),
            'distance' => __('10 mins away'),
            'category' => __('Culture & Heritage'),
            'icon' => 'fa-solid fa-place-of-worship',
            'desc' => __('A revered 15th-century temple famed for its magnificent golden gopuram, sacred rituals, and spiritual atmosphere.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange a visit to Nallur Kandaswamy Temple during my stay.',
        ],
        [
            'title' => __('Jaffna Fort'),
            'distance' => __('12 mins away'),
            'category' => __('Colonial History'),
            'icon' => 'fa-solid fa-monument',
            'desc' => __('Historic 17th-century coastal fortress built by Portuguese and Dutch colonials with scenic lagoon views at sunset.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange a tour of Jaffna Fort during my stay.',
        ],
        [
            'title' => __('Keerimalai'),
            'distance' => __('30 mins away'),
            'category' => __('Sacred Springs'),
            'icon' => 'fa-solid fa-water',
            'desc' => __('Sacred coastal natural freshwater mineral springs known for historic therapeutic baths and ancient temple grounds.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange a trip to Keerimalai during my stay.',
        ],
        [
            'title' => __('Casuarina Beach'),
            'distance' => __('40 mins away'),
            'category' => __('Coastal Getaway'),
            'icon' => 'fa-solid fa-umbrella-beach',
            'desc' => __('Pristine white-sand beach on Karainagar island with calm shallow waters and shaded casuarina groves.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange transportation to Casuarina Beach during my stay.',
        ],
        [
            'title' => __('Delft Island'),
            'distance' => __('Ferry Excursion'),
            'category' => __('Island Adventure'),
            'icon' => 'fa-solid fa-ship',
            'desc' => __('A remote windswept island of coral-stone walls, roaming wild horses, ancient baobabs, and Dutch colonial ruins.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange an excursion to Delft Island during my stay.',
        ],
        [
            'title' => __('Nagadeepa'),
            'distance' => __('Boat Pilgrimage'),
            'category' => __('Spiritual Pilgrimage'),
            'icon' => 'fa-solid fa-dharmachakra',
            'desc' => __('Historic holy island venerated in Buddhist scriptures, alongside the sacred Nagapooshani Amman Kovil.'),
            'wa_msg' => 'Hello Rose Villa! I would like to arrange a visit to Nagadeepa during my stay.',
        ],
    ];
@endphp

<!-- 7. THINGS TO DO NEAR ROSE VILLA -->
<section id="things-to-do" class="py-24 px-6 lg:px-12 bg-creamBg scroll-mt-20">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">
                {{ __('Wander & Explore') }}
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">
                {{ __('Things to Do Near Rose Villa') }}
            </h2>
            <p class="text-darkText/70 text-sm leading-relaxed">
                {{ __('From ancient temple gopurams to sun-drenched islands, let our concierge curate unforgettable northern excursions for you.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activities as $act)
                @php
                    $waUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($act['wa_msg']);
                @endphp
                <div class="bg-stoneBeige/40 rounded-3xl p-7 border border-stoneBeige/80 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-block bg-heritageGreen/10 text-heritageGreen text-[11px] font-semibold px-3 py-1 rounded-full">
                                {{ $act['category'] }}
                            </span>
                            <span class="text-xs text-darkText/60 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-roseRed text-xs"></i>
                                {{ $act['distance'] }}
                            </span>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-creamBg border border-stoneBeige text-heritageGreen flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-transform shadow-inner">
                            <i class="{{ $act['icon'] }}" aria-hidden="true"></i>
                        </div>

                        <h3 class="font-serif font-bold text-xl text-heritageGreen mb-2 group-hover:text-darkText transition-colors">
                            {{ $act['title'] }}
                        </h3>

                        <p class="text-xs sm:text-sm text-darkText/75 leading-relaxed mb-6">
                            {{ $act['desc'] }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-stoneBeige/60">
                        <a href="{{ $waUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs py-3 px-4 rounded-xl shadow-sm transition-all">
                            <i class="fa-brands fa-whatsapp text-sm" aria-hidden="true"></i>
                            <span>{{ __('Ask us to arrange this') }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <p class="text-xs text-darkText/60">
                {{ __('Looking for a custom itinerary, bicycle rental, or a dedicated chauffeur vehicle?') }}
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Hello Rose Villa, I would like to discuss a custom Jaffna itinerary.') }}" 
                   target="_blank" 
                   class="text-heritageGreen font-bold hover:underline ml-1">
                    {{ __('Chat with our travel concierge') }} &rarr;
                </a>
            </p>
        </div>
    </div>
</section>

