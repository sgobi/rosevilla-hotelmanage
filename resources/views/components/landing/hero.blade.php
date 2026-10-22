@props([
    'content' => [],
    'rooms' => null,
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

    $roomList = ($rooms && count($rooms) > 0) ? $rooms : \App\Models\Room::where('is_active', true)->orderBy('price_per_night')->get();
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
    <div class="relative z-10 max-w-6xl mx-auto w-full bg-white/95 backdrop-blur-xl rounded-3xl p-5 sm:p-7 shadow-2xl text-darkText border border-white/40 mt-8"
         x-data="{
            stayType: 'Room',
            selectedRoom: '{{ $roomList->first()->id ?? 1 }}',
            checkIn: '',
            checkOut: '',
            guests: '2',
            today: new Date().toISOString().split('T')[0],

            handleCheckinChange() {
                if (this.checkIn) {
                    if (!this.checkOut || this.checkOut <= this.checkIn) {
                        const d = new Date(this.checkIn);
                        d.setDate(d.getDate() + 1);
                        this.checkOut = d.toISOString().split('T')[0];
                    }
                }
            },

            checkAvailability() {
                // 1. Sync Stay Type to Main Booking Form
                if (typeof window.setStayType === 'function') {
                    window.setStayType(this.stayType);
                }

                // 2. Sync Room Preference
                const targetRoomSelect = document.getElementById('room-type-select');
                if (targetRoomSelect && this.selectedRoom && this.stayType === 'Room') {
                    targetRoomSelect.value = this.selectedRoom;
                }

                // 3. Sync Dates to Booking Form & Flatpickr instances
                const targetCheckin = document.getElementById('booking-checkin');
                const targetCheckout = document.getElementById('booking-checkout');
                if (targetCheckin && this.checkIn) {
                    if (window.fpCheckIn) {
                        window.fpCheckIn.setDate(this.checkIn, true);
                    } else {
                        targetCheckin.value = this.checkIn;
                    }
                }
                if (targetCheckout && this.checkOut) {
                    if (window.fpCheckOut) {
                        window.fpCheckOut.setDate(this.checkOut, true);
                    } else {
                        targetCheckout.value = this.checkOut;
                    }
                }

                // 4. Sync Guests Count
                const targetGuests = document.querySelector('select[name=guests]');
                if (targetGuests && this.guests) {
                    targetGuests.value = this.guests;
                }

                // 5. Trigger live calculation and calendar redraw
                if (typeof window.refreshCalendarAvailability === 'function') {
                    window.refreshCalendarAvailability();
                } else if (typeof window.updatePriceCalculation === 'function') {
                    window.updatePriceCalculation();
                }

                // 6. Smooth scroll to reservation section
                const reserveSection = document.getElementById('reserve');
                if (reserveSection) {
                    reserveSection.scrollIntoView({ behavior: 'smooth' });
                }
            }
         }">
        
        <!-- Experience Tabs: Rooms / Villa vs Garden Event -->
        <div class="flex items-center gap-2 mb-4 border-b border-stoneBeige/50 pb-3">
            <button type="button" 
                    @click="stayType = 'Room'"
                    :class="stayType === 'Room' ? 'bg-heritageGreen text-white shadow-sm' : 'bg-stoneBeige/40 text-darkText/70 hover:text-darkText hover:bg-stoneBeige/70'"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2">
                <i class="fa-solid fa-bed text-xs"></i> Rooms / Villa
            </button>
            <button type="button" 
                    @click="stayType = 'Garden Event'"
                    :class="stayType === 'Garden Event' ? 'bg-heritageGreen text-white shadow-sm' : 'bg-stoneBeige/40 text-darkText/70 hover:text-darkText hover:bg-stoneBeige/70'"
                    class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2">
                <i class="fa-solid fa-champagne-glasses text-xs"></i> Garden Event
            </button>
        </div>

        <form @submit.prevent="checkAvailability()" 
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-center"
              aria-label="Quick availability check">
            
            <!-- Room / Venue Preference -->
            <div class="flex flex-col">
                <label class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    <span x-show="stayType === 'Room'">Room Type</span>
                    <span x-show="stayType === 'Garden Event'" x-cloak>Event Venue</span>
                </label>

                <!-- Room Select -->
                <div x-show="stayType === 'Room'">
                    <select id="hero-room" 
                            name="hero_room"
                            x-model="selectedRoom"
                            aria-label="Select Room"
                            class="w-full bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText cursor-pointer">
                        @foreach($roomList as $room)
                            <option value="{{ $room->id }}">{{ $room->title }} (LKR {{ number_format($room->price_per_night, 0) }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Garden Venue Indicator -->
                <div x-show="stayType === 'Garden Event'" x-cloak>
                    <div class="w-full bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm text-heritageGreen font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-tree text-xs text-roseRed"></i>
                        <span>Garden Lawn (LKR 30,000)</span>
                    </div>
                </div>
            </div>

            <!-- Check-in / Start Date -->
            <div class="flex flex-col">
                <label for="hero-checkin" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    <span x-show="stayType === 'Room'">Check-in Date</span>
                    <span x-show="stayType === 'Garden Event'" x-cloak>Event Start Date</span>
                </label>
                <input type="date" 
                       id="hero-checkin" 
                       name="hero_checkin"
                       x-model="checkIn"
                       @change="handleCheckinChange()"
                       :min="today"
                       aria-label="Check-in Date"
                       class="bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText">
            </div>

            <!-- Check-out / End Date -->
            <div class="flex flex-col">
                <label for="hero-checkout" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    <span x-show="stayType === 'Room'">Check-out Date</span>
                    <span x-show="stayType === 'Garden Event'" x-cloak>Event End Date</span>
                </label>
                <input type="date" 
                       id="hero-checkout" 
                       name="hero_checkout"
                       x-model="checkOut"
                       :min="checkIn || today"
                       aria-label="Check-out Date"
                       class="bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText">
            </div>

            <!-- Guests / Attendees -->
            <div class="flex flex-col">
                <label for="hero-guests" class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen mb-1">
                    <span x-show="stayType === 'Room'">Guests</span>
                    <span x-show="stayType === 'Garden Event'" x-cloak>Attendees</span>
                </label>

                <!-- Room Guests -->
                <div x-show="stayType === 'Room'">
                    <select id="hero-guests" 
                            name="hero_guests"
                            x-model="guests"
                            aria-label="Number of Guests"
                            class="w-full bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText cursor-pointer">
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 - 4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>

                <!-- Event Attendees -->
                <div x-show="stayType === 'Garden Event'" x-cloak>
                    <select id="hero-attendees" 
                            name="hero_attendees"
                            x-model="guests"
                            aria-label="Number of Attendees"
                            class="w-full bg-creamBg border border-stoneBeige rounded-xl px-3.5 py-3 text-sm focus:outline-none focus:border-heritageGreen focus:ring-2 focus:ring-heritageGreen/20 transition-all text-darkText cursor-pointer">
                        <option value="50">50 - 100 Attendees</option>
                        <option value="200">200 - 500 Attendees</option>
                        <option value="500">500+ Attendees</option>
                    </select>
                </div>
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
