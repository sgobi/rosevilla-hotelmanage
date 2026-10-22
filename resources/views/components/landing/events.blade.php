@props(['garden' => null])

<!-- 6. RESERVE THE GARDEN & EVENTS -->
<section id="events" class="py-16 px-6 lg:px-12 max-w-7xl mx-auto">
    <div class="relative rounded-3xl overflow-hidden bg-heritageGreen text-white shadow-2xl">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/wedding_event_rosevilla.png') }}" 
                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=80&w=1200';" 
                 alt="Garden Sanctuary" 
                 class="w-full h-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-r from-heritageGreen via-heritageGreen/90 to-transparent"></div>
        </div>
        <div class="relative z-10 p-8 sm:p-12 lg:p-16 max-w-2xl space-y-6">
            <span class="bg-roseRed text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider inline-block">Outdoor Venue</span>
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">Reserve the Garden Sanctuary</h2>
            <p class="text-creamBg/90 text-sm sm:text-base leading-relaxed">
                Host your intimate outdoor gatherings, family get-togethers, and celebrations under the canopy of ancient palm trees and starry Jaffna skies.
            </p>
            <div class="flex flex-wrap items-center gap-6 pt-2">
                <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20">
                    <span class="text-xs text-creamBg/80 block">Capacity</span>
                    <span class="font-bold text-sm">Up to 150 Guests</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20">
                    <span class="text-xs text-creamBg/80 block">Starting Fee</span>
                    <span class="font-bold text-sm price-tag" data-lkr="45,000" data-usd="150">From LKR 45,000</span>
                </div>
            </div>
            <div class="pt-4">
                <a href="#reserve" onclick="selectStayType('Garden Event')" class="inline-block bg-antiqueGold hover:bg-goldHover text-white font-semibold px-8 py-3.5 rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 text-sm">
                    Reserve Garden Venue
                </a>
            </div>
        </div>
    </div>
</section>
