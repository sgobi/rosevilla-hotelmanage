<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @php
        $favicon = \App\Models\ContentSetting::getValue('favicon_path');
        $siteTitle = \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage Homes | Jaffna, Sri Lanka');
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

    <title>{{ $siteTitle }}</title>
    <meta name="description" content="{{ $siteDescription }}">
    <meta name="keywords" content="Heritage Home Jaffna, Accommodation Jaffna, Boutique Hotel Jaffna, Colonial Villa Jaffna, Best Accommodation in Jaffna, Where to stay in Jaffna, Jaffna Heritage Homes, Near Nallur Temple, Sri Lanka Heritage Home, Jaffna Cultural Tourism">
    <meta name="geo.region" content="LK-41">
    <meta name="geo.placename" content="Jaffna">
    <meta name="geo.position" content="9.6615;80.0255">
    <meta name="ICBM" content="9.6615, 80.0255">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $siteTitle }}">
    <meta property="og:description" content="{{ $siteDescription }}">
    <meta property="og:image" content="{{ $heroImage }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $siteTitle }}">
    <meta property="twitter:description" content="{{ $siteDescription }}">
    <meta property="twitter:image" content="{{ $heroImage }}">

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

        // Currency Switcher Display Handler (works in tandem with backend session)
        function updateCurrency(curr) {
            const priceTags = document.querySelectorAll('.price-tag');
            priceTags.forEach(tag => {
                if (curr === 'USD') {
                    tag.textContent = 'From USD ' + tag.getAttribute('data-usd') + ' / night';
                } else {
                    tag.textContent = 'From LKR ' + tag.getAttribute('data-lkr') + ' / night';
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
