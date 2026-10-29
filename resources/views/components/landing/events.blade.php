@props(['garden' => null, 'content' => null])

@php
    $content = $content ?? \App\Models\ContentSetting::pluck('value', 'key');
    $eventTitle = !empty($content['events_title']) 
        ? $content['events_title'] 
        : ($garden->title ?? 'Reserve the Garden Sanctuary');

    $eventDescription = !empty($content['events_description']) 
        ? $content['events_description'] 
        : ($garden->description ?? 'Host your intimate outdoor gatherings, family get-togethers, and celebrations under the canopy of ancient palm trees and starry Jaffna skies.');

    $eventCurrency = \App\Helpers\CurrencyHelper::getCurrentCurrency();
    $maxGuests = $garden->max_guests ?? 1000;
    $gardenPrice = $garden->price_per_day ?? 30000;
    $gardenDisplay = \App\Helpers\CurrencyHelper::format($gardenPrice, $eventCurrency);
@endphp

<!-- 6. RESERVE THE GARDEN & EVENTS -->
<section id="events" class="py-16 px-6 lg:px-12 max-w-7xl mx-auto">
    <div class="relative rounded-3xl overflow-hidden bg-heritageGreen text-white shadow-2xl">
        <div class="absolute inset-0 z-0">
            <img src="{{ !empty($garden->image_path) ? (str_starts_with($garden->image_path, 'http') ? $garden->image_path : asset('storage/' . $garden->image_path)) : asset('images/wedding_event_rosevilla.png') }}" 
                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=80&w=1200';" 
                 alt="{{ $eventTitle }} - Scenic Outdoor Event Lawn & Garden Venue at Rose Villa Heritage Homes" 
                 loading="lazy"
                 class="w-full h-full object-cover opacity-25">
            <div class="absolute inset-0 bg-gradient-to-r from-heritageGreen via-heritageGreen/90 to-transparent"></div>
        </div>
        <div class="relative z-10 p-8 sm:p-12 lg:p-16 max-w-2xl space-y-6">
            <span class="bg-roseRed text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider inline-block">Outdoor Venue</span>
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">{{ $eventTitle }}</h2>
            <p class="text-creamBg/90 text-sm sm:text-base leading-relaxed">
                {{ $eventDescription }}
            </p>
            <div class="flex flex-wrap items-center gap-6 pt-2">
                <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20">
                    <span class="text-xs text-creamBg/80 block">Capacity</span>
                    <span class="font-bold text-sm">Up to {{ $maxGuests }} Guests</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20">
                    <span class="text-xs text-creamBg/80 block">Starting Fee</span>
                    <span class="font-bold text-sm price-tag">From {{ $gardenDisplay }}</span>
                </div>
            </div>

            <!-- Starting fee inclusion helper text with editable placeholder -->
            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-4 border border-white/15 text-xs text-creamBg/90 leading-relaxed space-y-1">
                <span class="font-semibold text-antiqueGold flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
                    <i class="fa-solid fa-circle-info text-xs"></i> Starting Fee Inclusions
                </span>
                <p class="text-[11px] sm:text-xs">
                    [EDIT: Starting fee of {{ $gardenDisplay }} (approx. LKR 30,000 / $97) includes exclusive lawn access, ambient garden illumination, setup & breakdown coordination window, dedicated parking staff, and clean washroom facilities. Bespoke catering, stage canopy, acoustic sound systems, and special floral decorations are quoted separately.]
                </p>
            </div>

            <div class="pt-2">
                <a href="#reserve" onclick="selectStayType('Garden Event')" class="inline-block bg-antiqueGold hover:bg-goldHover text-white font-semibold px-8 py-3.5 rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5 text-sm">
                    Reserve Garden Venue
                </a>
            </div>
        </div>
    </div>
</section>
