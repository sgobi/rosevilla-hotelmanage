<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    @php
        $favicon = \App\Models\ContentSetting::getValue('favicon_path');
        $siteTitle = \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage Homes | Jaffna, Sri Lanka');
        $pageTitle = config('rosevilla.meta_title', 'Rose Villa Heritage Homes | Boutique Heritage Stay in Jaffna, Sri Lanka');
        $siteDescription = \App\Models\ContentSetting::getValue('site_description', 'Experience the best of Jaffna heritage at Rose Villa Heritage Homes. Timeless architecture, serene courtyard gardens, authentic Northern cuisine, and colonial charm in Jaffna, Sri Lanka.');
        $heroImage = \App\Models\ContentSetting::getValue('hero_image_path') 
            ? asset('storage/' . \App\Models\ContentSetting::getValue('hero_image_path')) 
            : asset('images/rosevilla front view.png');
    @endphp

    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $siteDescription }}">
    <meta name="keywords" content="Heritage Home Jaffna, Accommodation Jaffna, Boutique Hotel Jaffna, Colonial Villa Jaffna, Best Accommodation in Jaffna, Where to stay in Jaffna, Jaffna Heritage Homes, Near Nallur Temple, Sri Lanka Heritage Home, Jaffna Cultural Tourism">
    <meta name="geo.region" content="LK-41">
    <meta name="geo.placename" content="Jaffna">
    <meta name="geo.position" content="9.6615;80.0255">
    <meta name="ICBM" content="9.6615, 80.0255">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $siteDescription }}">
    <meta property="og:image" content="{{ $heroImage }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $pageTitle }}">
    <meta property="twitter:description" content="{{ $siteDescription }}">
    <meta property="twitter:image" content="{{ $heroImage }}">

    <!-- JSON-LD Structured Data: LodgingBusiness -->
    @php
        $lodgingSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => 'Rose Villa Heritage Homes',
            'alternateName' => 'Rose Villa Jaffna',
            'description' => $siteDescription,
            'url' => url('/'),
            'telephone' => '+94 76 569 2476',
            'email' => 'stay@rosevillaheritagehomes.com',
            'priceRange' => \App\Helpers\CurrencyHelper::getCurrentCurrency() === 'USD' ? '$25 - $100' : 'LKR 8,000 - 30,000',
            'currenciesAccepted' => 'LKR, USD',
            'paymentAccepted' => 'Cash, Bank Transfer, Credit Card',
            'checkinTime' => '14:00',
            'checkoutTime' => '11:00',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '[EDIT: Exact Street Address - e.g. Rose Villa Heritage Homes, Main Road, Uduvil / Jaffna]',
                'addressLocality' => 'Jaffna',
                'addressRegion' => 'Northern Province',
                'postalCode' => '[EDIT: Postal Code - e.g. 40000]',
                'addressCountry' => 'LK',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => 9.6615,
                'longitude' => 80.0255,
            ],
            'image' => [
                asset('images/rosevilla front view.png'),
                asset('images/wedding_event_rosevilla.png'),
                asset('images/jaffna_cuisine.jpg'),
            ],
            'amenityFeature' => [
                ['@type' => 'LocationFeatureSpecification', 'name' => 'High-Speed Wi-Fi', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Air Conditioning', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Free On-Site Parking', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Complimentary Breakfast', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Dedicated Airport & City Transfers', 'value' => true],
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '28',
                'bestRating' => '5',
                'worstRating' => '1',
            ],
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($lodgingSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <!-- Google Fonts with Preconnect & Multi-script Fallbacks -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Noto+Sans+Sinhala:wght@400;600;700&family=Noto+Sans+Tamil:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flatpickr (Calendar Datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-creamBg text-darkText font-sans antialiased selection:bg-heritageGreen selection:text-white"
      x-data="landingApp()">

    <!-- 1. STICKY NAVBAR -->
    <x-landing.navbar />

    <!-- MAIN PAGE CONTENT -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- 11. FOOTER -->
    <x-landing.footer />

    <!-- 12. LIGHTBOX MODAL -->
    <x-landing.lightbox />

    <!-- 13. FLOATING ACTIONS (WhatsApp & Mobile Bar) -->
    <x-landing.floating-actions />

    <!-- Global Interactive Scripts for Landing -->
    <script>
        function landingApp() {
            return {
                lightboxOpen: false,
                lightboxSrc: '',
                lightboxCaption: '',
                selectedRoom: 'Heritage Room',
                activeTab: 'all',

                openLightboxModal(src, caption) {
                    this.lightboxSrc = src;
                    this.lightboxCaption = caption;
                    this.lightboxOpen = true;
                },
                closeLightboxModal() {
                    this.lightboxOpen = false;
                    this.lightboxSrc = '';
                    this.lightboxCaption = '';
                }
            };
        }

        // Global Helper for Gallery thumbnail switching
        function changeImage(imgId, newSrc) {
            const img = document.getElementById(imgId);
            if (!img) return;
            img.style.opacity = '0.3';
            setTimeout(() => {
                img.src = newSrc;
                img.style.opacity = '1';
            }, 150);
        }

        // Currency Handler
        function updateCurrency(curr) {
            window.location.href = '/currency/' + encodeURIComponent(curr);
        }
    </script>

    @stack('scripts')
</body>
</html>
