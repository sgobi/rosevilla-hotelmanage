<x-landing-layout>
    <!-- 2. Hero Section -->
    <x-landing.hero :content="$content" :rooms="$rooms" />

    <!-- 3. The Heritage & Courtyard Story -->
    <x-landing.about :content="$content" />

    <!-- 3b. Our Story (Villa History) -->
    <x-landing.our-story :content="$content" />

    <!-- 4. Sanctuary Stays (Rooms & Villas) -->
    <x-landing.rooms :rooms="$rooms" />

    <!-- 4b. Essential Villa Amenities -->
    <x-landing.amenities :content="$content" />

    <!-- 5. Flavors of Jaffna (Culinary Spotlight) -->
    <x-landing.culinary />

    <!-- 5b. Things to Do Near Rose Villa -->
    <x-landing.things-to-do />

    <!-- 6. Reserve the Garden & Events -->
    <x-landing.events :garden="$garden" :content="$content" />

    <!-- 7. Gallery -->
    <x-landing.gallery :gallery="$gallery" />

    <!-- 8. Testimonials (Guest Stories) -->
    <x-landing.testimonials :reviews="$reviews" />

    <!-- 8b. Guest Policies & Terms Accordion -->
    <x-landing.policies />

    <!-- 9. Booking Form -->
    <x-landing.booking :rooms="$rooms" :bookedDatesByRoom="$bookedDatesByRoom" :bookedDatesGarden="$bookedDatesGarden" />

    <!-- 10. Find Us & Map -->
    <x-landing.find-us :content="$content" />
</x-landing-layout>
