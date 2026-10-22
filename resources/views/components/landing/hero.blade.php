@props([
    'content' => [],
    'title' => null,
    'subtitle' => null,
    'image' => null,
    'ratingBadge' => '4.8 ★ Northern Sri Lankan Hospitality',
    'primaryCtaText' => 'Reserve Your Stay',
    'primaryCtaLink' => '#reserve',
    'secondaryCtaText' => 'Explore Rooms',
    'secondaryCtaLink' => '#rooms',
])

@php
    // Prioritize explicit props, then real database CMS content, then approved fallbacks
    $heroTitle = $title 
        ?? ($content['hero_title'] ?? null) 
        ?? 'Experience the Extraordinary in Jaffna';

    $heroSubtitle = $subtitle 
        ?? ($content['hero_subtitle'] ?? null) 
        ?? 'A boutique heritage villa with soulful hospitality, lush courtyards, and authentic northern flavors.';

    $heroImage = $image;
    if (!$heroImage) {
        if (!empty($content['hero_image_path'])) {
            $heroImage = asset('storage/' . $content['hero_image_path']);
        } elseif (file_exists(public_path('images/rosevilla front view.png'))) {
            $heroImage = asset('images/rosevilla front view.png');
        } else {
            $heroImage = 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=1920';
        }
    }
@endphp

<!-- 2. EDITORIAL HERO SECTION -->
<header class="relative min-h-screen flex flex-col justify-between pt-32 pb-12 px-6 lg:px-12 bg-heritageGreen text-white overflow-hidden">
    <!-- Hero Background Image (Eager loaded for LCP performance, not lazy-loaded) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroImage }}" 
             alt="Rose Villa Heritage Home front view in Jaffna, Sri Lanka" 
             fetchpriority="high"
             loading="eager"
             class="w-full h-full object-cover opacity-35 mix-blend-overlay">
        <div class="absolute inset-0 bg-gradient-to-t from-heritageGreen via-heritageGreen/50 to-transparent"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto text-center my-auto py-10">
        <!-- Rating Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-medium tracking-wider mb-6 border border-white/20 shadow-lg">
            <span class="text-antiqueGold" aria-hidden="true"><i class="fa-solid fa-star"></i></span>
            <span>{{ $ratingBadge }}</span>
        </div>

        <!-- Main Heading -->
        <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight mb-6 leading-tight text-white drop-shadow-sm">
            {{ $heroTitle }}
        </h1>

        <!-- Subtitle -->
        <p class="text-lg sm:text-xl text-creamBg/90 max-w-2xl mx-auto mb-10 font-light leading-relaxed">
            {{ $heroSubtitle }}
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $primaryCtaLink }}" 
               class="w-full sm:w-auto bg-antiqueGold hover:bg-goldHover focus:ring-4 focus:ring-antiqueGold/40 focus:outline-none text-white font-semibold px-8 py-4 rounded-2xl shadow-xl transition-all transform hover:-translate-y-0.5 text-center">
                {{ $primaryCtaText }}
            </a>
            <a href="{{ $secondaryCtaLink }}" 
               class="w-full sm:w-auto border-2 border-white/80 hover:bg-white/10 focus:ring-4 focus:ring-white/40 focus:outline-none text-white font-semibold px-8 py-3.5 rounded-2xl transition-all text-center backdrop-blur-sm">
                {{ $secondaryCtaText }}
            </a>
        </div>
    </div>

    <!-- Sleek Floating Availability Bar (Interactions powered purely by Alpine.js) -->
    <div class="relative z-10 max-w-5xl mx-auto w-full bg-white/95 backdrop-blur-xl rounded-3xl p-5 sm:p-7 shadow-2xl text-darkText border border-white/40"
         x-data="{
            checkIn: '',
            checkOut: '',
            guests: '2 Guests',
            today: new Date().toISOString().split('T')[0],

            checkAvailability() {
                // Sync values to the main reservation form
                const targetCheckin = document.getElementById('booking-checkin');
                const targetCheckout = document.getElementById('booking-checkout');
                const targetGuests = document.querySelector('select[name=guests]');

                if (targetCheckin && this.checkIn) targetCheckin.value = this.checkIn;
                if (targetCheckout && this.checkOut) targetCheckout.value = this.checkOut;
                if (targetGuests && this.guests) {
                    const guestVal = parseInt(this.guests) || 2;
                    targetGuests.value = guestVal;
                }

                // Smooth scroll to the reservation section
                const reserveSection = document.getElementById('reserve');
                if (reserveSection) {
                    reserveSection.scrollIntoView({ behavior: 'smooth' });
                }
            }
         }">
        <form @submit.prevent="checkAvailability()" 
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-center"
              aria-label="Quick availability check">
            
            <!-- Check-in Date -->
            <div class="flex flex-col">
                <label for="hero-checkin" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    Check-in Date
                </label>
                <input type="date" 
                       id="hero-checkin" 
                       name="hero_checkin"
                       x-model="checkIn"
                       :min="today"
                       aria-label="Check-in Date"
                       class="bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText">
            </div>

            <!-- Check-out Date -->
            <div class="flex flex-col">
                <label for="hero-checkout" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    Check-out Date
                </label>
                <input type="date" 
                       id="hero-checkout" 
                       name="hero_checkout"
                       x-model="checkOut"
                       :min="checkIn || today"
                       aria-label="Check-out Date"
                       class="bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText">
            </div>

            <!-- Guests -->
            <div class="flex flex-col">
                <label for="hero-guests" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    Guests
                </label>
                <select id="hero-guests" 
                        name="hero_guests"
                        x-model="guests"
                        aria-label="Number of Guests"
                        class="bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText cursor-pointer">
                    <option value="1 Guest">1 Guest</option>
                    <option value="2 Guests" selected>2 Guests</option>
                    <option value="3 - 4 Guests">3 - 4 Guests</option>
                    <option value="Family / Group (5+)">Family / Group (5+)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end pt-2 sm:pt-0">
                <button type="submit" 
                        class="w-full bg-heritageGreen hover:bg-heritageGreen/90 focus:ring-4 focus:ring-heritageGreen/30 focus:outline-none text-white font-semibold py-3.5 rounded-xl transition-all shadow-md text-sm flex items-center justify-center gap-2">
                    <span>Check Availability</span>
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</header>
