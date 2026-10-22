<x-landing-layout>
    <!-- 2. Hero Section -->
    <x-landing.hero :content="$content" />

    <!-- 3. The Heritage & Courtyard Story -->
    <x-landing.about :content="$content" />

    <!-- 4. Sanctuary Stays (Rooms & Villas) -->
    <x-landing.rooms :rooms="$rooms" />

    <!-- 5. Flavors of Jaffna (Culinary Spotlight) -->
    <x-landing.culinary />

    <!-- 6. Reserve the Garden & Events -->
    <x-landing.events :garden="$garden" />

    <!-- 7. Gallery -->
    <x-landing.gallery :gallery="$gallery" />

    <!-- 8. Testimonials (Guest Stories) -->
    <x-landing.testimonials :reviews="$reviews" />

    <!-- 9. Booking Form -->
    <x-landing.booking :rooms="$rooms" />

    <!-- 10. Find Us & Map -->
    <x-landing.find-us />
</x-landing-layout>
