<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @php $favicon = \App\Models\ContentSetting::getValue('favicon_path'); @endphp
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    <title>{{ \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage Homes') }}</title>
    <meta name="description" content="{{ \App\Models\ContentSetting::getValue('site_description', 'Experience the best of Jaffna heritage at Rose Villa Heritage Homes. Luxury stay, authentic cuisine, and colonial charm in Jaffna, Sri Lanka.') }}">
    <meta name="keywords" content="Heritage Hotel Jaffna, Boutique Hotel Jaffna, Luxury Stay Jaffna, Colonial Villa Jaffna, Best Hotel in Jaffna, Jaffna Accommodation, Hotels in Jaffna, Where to stay in Jaffna, Jaffna Heritage Homes, Hotels near Jaffna Fort, Hotels near Nallur Temple, Northern Province Hotels, Sri Lanka Heritage Hotel, Boutique Hotels Sri Lanka, Jaffna Tourism, Wedding Venue Jaffna, Colonial Architecture Jaffna, Tamil Cuisine Jaffna, Jaffna Cultural Experience, Heritage Tours Jaffna">
    <meta name="geo.region" content="LK-41">
    <meta name="geo.placename" content="Jaffna">
    <meta name="geo.position" content="9.6615;80.0255">
    <meta name="ICBM" content="9.6615, 80.0255">


    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage Homes') }}">
    <meta property="og:description" content="{{ \App\Models\ContentSetting::getValue('site_description', 'Experience the best of Jaffna heritage at Rose Villa Heritage Homes. Luxury stay, authentic cuisine, and colonial charm in Jaffna, Sri Lanka.') }}">
    <meta property="og:image" content="{{ asset('images/rosevilla front view.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage Homes') }}">
    <meta property="twitter:description" content="{{ \App\Models\ContentSetting::getValue('site_description', 'Experience the best of Jaffna heritage at Rose Villa Heritage Homes.') }}">
    <meta property="twitter:image" content="{{ asset('images/rosevilla front view.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .page-fade-in { opacity: 0; transition: opacity 0.8s ease-out; }
        .page-fade-in.ready { opacity: 1; }
    </style>
</head>
<body class="font-sans text-rose-text antialiased bg-white page-fade-in" x-data="{ ready: false }" x-init="setTimeout(() => ready = true, 100)" :class="{ 'ready': ready }">
    @php
        $heroTitle = $content['hero_title'] ?? 'Rose Villa';
        $heroSubtitle = $content['hero_subtitle'] ?? 'Experience the Extraordinary in Jaffna';
        $heroImage = asset('images/rosevilla front view.png'); 
    @endphp

    <!-- Header -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 50)"
            :class="{ 'bg-[#1a1c1e] shadow-xl py-3': scrolled, 'bg-gradient-to-b from-black/70 to-transparent py-4 lg:py-6': !scrolled }"
            class="fixed top-0 left-0 w-full z-50 transition-all duration-500 border-b border-white/5 py-4 lg:py-6" style="transform: translateZ(0);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-white">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block transition-all duration-500 hover:brightness-110 active:scale-95">
                         <img src="{{ asset('images/logo.png') }}" 
                              alt="Rose Villa Logo" 
                              class="h-12 lg:h-16 transition-all duration-700 filter drop-shadow-md"
                              :class="{ 'h-10': scrolled, 'h-12 lg:h-16': !scrolled }"
                              loading="eager">
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden lg:flex space-x-6 xl:space-x-8 items-center">
                    @foreach(['About' => '#about', 'Rooms' => '#rooms', 'Gallery' => '#gallery', 'Experiences' => '#experiences', 'Events' => '#events', 'FAQ' => route('faq'), 'Contact' => '#contact'] as $label => $link)
                        <a href="{{ $link }}" class="relative text-xs tracking-widest font-black uppercase transition-all duration-300 hover:text-rose-gold group" aria-label="{{ $label }}">
                            {{ __($label) }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-rose-gold transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    @endforeach
                    
                    <!-- Currency Switcher -->
                    <div class="relative group ml-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-white hover:text-rose-gold text-[0.65rem] font-black uppercase transition border border-white/20 px-3.5 py-2 rounded-full bg-white/20">
                            <span class="opacity-100">
                                {{ session('currency', 'LKR') }}
                            </span>
                            <svg class="w-3 h-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-4 w-40 bg-white rounded-2xl shadow-2xl overflow-hidden py-2 z-50 border border-gray-100">
                            @foreach(['LKR' => 'Sri Lankan Rupee', 'USD' => 'US Dollar', 'EUR' => 'Euro', 'CAD' => 'Canadian Dollar', 'INR' => 'Indian Rupee'] as $code => $name)
                                <a href="{{ route('currency.switch', $code) }}" class="block px-5 py-3 text-[10px] font-black text-gray-800 hover:bg-rose-50 hover:text-rose-primary transition uppercase tracking-widest {{ session('currency', 'LKR') == $code ? 'text-rose-gold border-r-4 border-rose-gold' : '' }}">{{ $name }} ({{ $code }})</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Language Switcher -->
                    <div class="relative group ml-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-white hover:text-rose-gold text-[0.65rem] font-black uppercase transition border border-white/20 px-3.5 py-2 rounded-full bg-white/20">
                            <span class="opacity-100 uppercase">
                                {{ app()->getLocale() }}
                            </span>
                            <svg class="w-3 h-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-4 w-40 bg-white rounded-2xl shadow-2xl overflow-hidden py-2 z-50 border border-gray-100">
                            @foreach(['en' => 'English', 'fr' => 'Français', 'hi' => 'हिन्दी', 'si' => 'සිංහල', 'ta' => 'தமிழ்'] as $code => $name)
                                <a href="{{ route('lang.switch', $code) }}" class="block px-5 py-3 text-[10px] font-black text-gray-800 hover:bg-rose-50 hover:text-rose-primary transition uppercase tracking-widest {{ app()->getLocale() == $code ? 'text-rose-gold border-r-4 border-rose-gold' : '' }}">{{ $name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    <a href="#reservation" class="ml-6 bg-rose-gold hover:bg-white hover:text-rose-primary text-white text-[0.7rem] font-black uppercase px-8 py-4 tracking-[0.2em] transition-all duration-500 shadow-[0_10px_30px_-10px_rgba(179,142,93,0.5)] hover:shadow-xl active:scale-95 rounded-2xl">
                        {{ __('Reserve Now') }}
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="ml-4 bg-white/10 hover:bg-white hover:text-gray-900 text-white text-[0.6rem] font-black uppercase px-6 py-3.5 tracking-[0.2em] transition-all duration-500 border border-white/20 rounded-2xl flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ __('Staff Portal') }}
                        </a>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="p-3 rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 active:scale-90 transition-all">
                            <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </a>
                    @endauth
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-white/10 p-3 rounded-xl border border-white/10 text-white hover:text-rose-gold transition-all">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="mobileMenuOpen ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="mobileMenuOpen ? 'inline-flex' : 'hidden'" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Container -->
        <template x-teleport="body">
            <div x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-500" 
                 x-transition:enter-start="opacity-0 translate-y-[-20px]" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-[-20px]"
                 class="fixed inset-0 z-[200] bg-[#0d0d0d] flex flex-col">
                
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between p-6 border-b border-white/5 bg-[#121212]">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                        <div class="flex flex-col">
                            <span class="text-white text-[11px] font-black uppercase tracking-[0.2em] leading-none mb-1">Rose Villa</span>
                            <span class="text-rose-gold text-[7px] font-black uppercase tracking-[0.4em] leading-none">Heritage Homes</span>
                        </div>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-3 rounded-2xl bg-white/5 border border-white/10 text-white hover:text-rose-gold transition-all active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Mobile Menu Body -->
                <div class="flex-grow overflow-y-auto bg-gradient-to-b from-[#0d0d0d] to-[#121212] px-6 py-8">
                    <div class="grid grid-cols-1 gap-4">
                        @php
                            $menuItems = [
                                ['label' => 'About', 'link' => '#about', 'sub' => 'Our Heritage', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['label' => 'Rooms', 'link' => '#rooms', 'sub' => 'Luxury Stay', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                ['label' => 'Gallery', 'link' => '#gallery', 'sub' => 'Visual Tour', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                ['label' => 'Experiences', 'link' => '#experiences', 'sub' => 'Unique Moments', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0L4 10.172V17a1 1 0 001 1h14a1 1 0 001-1v-6.828l-5.172 4.656z'],
                                ['label' => 'Events', 'link' => '#events', 'sub' => 'Celebrations', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z'],
                                ['label' => 'Contact', 'link' => '#contact', 'sub' => 'Get in Touch', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ];
                        @endphp

                        @foreach($menuItems as $item)
                            <a href="{{ $item['link'] }}" @click="mobileMenuOpen = false" class="group flex items-center justify-between p-5 rounded-[1.5rem] bg-white/5 border border-white/5 hover:bg-white/10 hover:border-rose-gold/20 transition-all duration-300">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-[#1a1a1a] flex items-center justify-center text-rose-gold group-hover:bg-rose-gold group-hover:text-white transition-all duration-300 shadow-xl border border-white/5 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-serif text-white group-hover:text-rose-gold transition-colors">{{ __($item['label']) }}</h3>
                                        <p class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] mt-1">{{ __($item['sub']) }}</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-white/10 group-hover:text-rose-gold group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endforeach

                        @auth
                            <div class="mt-4 pt-4 border-t border-white/5">
                                <a href="{{ route('dashboard') }}" class="flex items-center justify-between p-5 rounded-[1.5rem] bg-emerald-500/10 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 shrink-0">
                                            <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-black text-white uppercase tracking-wider">Management</h3>
                                            <p class="text-[8px] font-black text-emerald-400 uppercase tracking-[0.2em] mt-1 italic">Administrative Portal</p>
                                        </div>
                                    </div>
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Locales & Currency (Mobile) -->
                    <div class="mt-8 space-y-6 bg-white/5 rounded-[2rem] p-6 border border-white/5">
                        <div class="space-y-4 text-center">
                            <p class="text-[8px] font-black text-white/30 uppercase tracking-[0.4em]">Language</p>
                            <div class="flex flex-wrap justify-center gap-3">
                                @foreach(['en' => 'EN', 'fr' => 'FR', 'hi' => 'HI', 'si' => 'සිං', 'ta' => 'தம'] as $code => $label)
                                    <a href="{{ route('lang.switch', $code) }}" class="px-4 py-2.5 rounded-xl transition-all font-black text-[10px] uppercase tracking-widest {{ app()->getLocale() == $code ? 'bg-rose-gold text-white shadow-lg' : 'text-white/60 hover:text-white bg-white/5' }}">{{ $label }}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-white/5 text-center">
                            <p class="text-[8px] font-black text-white/30 uppercase tracking-[0.4em]">Currency</p>
                            <div class="flex flex-wrap justify-center gap-3">
                                @foreach(['LKR', 'USD', 'EUR', 'CAD', 'INR'] as $code)
                                    <a href="{{ route('currency.switch', $code) }}" class="px-4 py-2.5 rounded-xl transition-all font-black text-[9px] uppercase tracking-widest {{ session('currency', 'LKR') == $code ? 'bg-white text-gray-900' : 'text-white/60 hover:text-white bg-white/5' }}">{{ $code }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center pb-8">
                         <p class="text-[9px] text-white/20 uppercase tracking-[0.6em] font-black italic">Rose Villa Heritage Homes</p>
                    </div>
                </div>
            </div>
        </template>
    </header>

    <!-- Hero Section -->
    <div class="relative h-[100dvh] flex items-center justify-center overflow-hidden bg-black">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 scale-105 animate-ken-burns" style="will-change: transform; transform: translateZ(0);">
            <img src="{{ $heroImage }}" alt="Rose Villa Heritage Home" class="w-full h-full object-cover opacity-100">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-1 text-center px-4 max-w-6xl mx-auto mt-20">
            <span class="inline-block py-2 px-4 bg-black/40 border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.5em] mb-8 rounded-full opacity-0 animate-fade-in-up" style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                {{ __('Heritage Sanctuary in Jaffna') }}
            </span>
            <h1 class="font-serif text-6xl md:text-9xl text-white mb-8 drop-shadow-[0_10px_35px_rgba(0,0,0,0.8)] tracking-tighter uppercase leading-[0.85] opacity-0 animate-fade-in-up" 
                style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                {{ __($heroTitle) }}
            </h1>
            <div class="w-32 h-1.5 bg-rose-gold mx-auto mb-10 rounded-full opacity-0 animate-fade-in-up" style="animation-delay: 0.6s; animation-fill-mode: forwards;"></div>
            <p class="text-white/90 text-lg md:text-2xl font-light tracking-wide mb-12 max-w-2xl mx-auto opacity-0 animate-fade-in-up" 
               style="animation-delay: 0.8s; animation-fill-mode: forwards;">
                {{ __($heroSubtitle) }}
            </p>
            <div class="opacity-0 animate-fade-in-up" style="animation-delay: 1s; animation-fill-mode: forwards;">
                <a href="#rooms" class="group relative inline-flex items-center justify-center px-12 py-5 text-sm font-black text-white uppercase tracking-[0.3em] transition-all duration-500 bg-white/10 border border-white/30 hover:border-white hover:bg-white hover:text-black overflow-hidden active:scale-95 shadow-2xl">
                    <span class="absolute inset-0 w-full h-full bg-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-500"></span>
                    <span class="relative z-10 group-hover:text-black">{{ __('Explore Collection') }}</span>
                </a>
            </div>

            <!-- Booking Widget -->
            <div class="mt-20 bg-black/40 p-3 rounded-[2rem] border border-white/20 shadow-[0_40px_100px_-15px_rgba(0,0,0,0.6)] hidden md:block opacity-0 animate-fade-in-up max-w-5xl mx-auto" 
                 style="animation-delay: 1.2s; animation-fill-mode: forwards; transform: translateZ(0);">
                <form action="#reservation" method="GET" class="flex items-center gap-3">
                    <div class="flex-1 grid grid-cols-3 gap-3 p-1">
                        <div class="relative group">
                            <label class="absolute top-3 left-6 text-[10px] font-black text-rose-gold uppercase tracking-[0.2em] transition-all group-focus-within:text-white">{{ __('Check In') }}</label>
                            <input type="date" name="check_in" class="w-full bg-white/5 border-0 pt-9 pb-4 px-6 text-white text-sm font-bold focus:ring-1 focus:ring-rose-gold/50 rounded-2xl transition-all cursor-pointer hover:bg-white/10 outline-none">
                        </div>
                        <div class="relative group border-l border-white/10">
                            <label class="absolute top-3 left-6 text-[10px] font-black text-rose-gold uppercase tracking-[0.2em] transition-all group-focus-within:text-white">{{ __('Check Out') }}</label>
                            <input type="date" name="check_out" class="w-full bg-white/5 border-0 pt-9 pb-4 px-6 text-white text-sm font-bold focus:ring-1 focus:ring-rose-gold/50 rounded-2xl transition-all cursor-pointer hover:bg-white/10 outline-none">
                        </div>
                        <div class="relative group border-l border-white/10">
                            <label class="absolute top-3 left-6 text-[10px] font-black text-rose-gold uppercase tracking-[0.2em] transition-all group-focus-within:text-white">{{ __('Guests') }}</label>
                            <select name="guests" class="w-full bg-white/5 border-0 pt-9 pb-4 px-6 text-white text-sm font-bold focus:ring-1 focus:ring-rose-gold/50 rounded-2xl transition-all cursor-pointer appearance-none hover:bg-white/10 outline-none px-6">
                                <option value="1" class="bg-rose-dark">1 {{ __('Guest') }}</option>
                                <option value="2" class="bg-rose-dark">2 {{ __('Guests') }}</option>
                                <option value="3" class="bg-rose-dark">3 {{ __('Guests') }}</option>
                                <option value="4" class="bg-rose-dark">4+ {{ __('Guests') }}</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="group/btn relative bg-rose-gold hover:bg-white text-white hover:text-rose-dark text-[11px] font-black uppercase px-14 py-8 tracking-[0.3em] transition-all duration-700 rounded-2xl shadow-2xl active:scale-95 flex items-center gap-4 overflow-hidden">
                        <span class="absolute inset-0 bg-white transform translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500"></span>
                        <span class="relative z-10">{{ __('Check Availability') }}</span>
                        <svg class="relative z-10 w-5 h-5 transform group-hover/btn:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="text-white/70 hover:text-rose-gold transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 md:py-40 bg-rose-primary relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-24 bg-gradient-to-b from-black/20 to-transparent"></div>
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-rose-gold/5 rounded-full"></div>
        <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-rose-accent/5 rounded-full"></div>

        <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
            <span class="text-rose-gold text-xs font-bold tracking-[0.4em] uppercase block mb-6 px-10">{{ __('Our Heritage') }}</span>
            <h2 class="font-serif text-4xl md:text-6xl text-white mb-10 uppercase tracking-tight px-12">
                {{ __('Wander & Explore') }}
            </h2>
            <div class="w-24 h-1.5 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-12 rounded-full"></div>
            <p class="text-xl leading-relaxed text-white mb-20 font-normal max-w-3xl mx-auto px-6">
                {{ $content['about_text'] ?? __("Nestled in the heart of Jaffna, Rose Villa is more than just a place to stay—it's a journey back in time. Our heritage home blends colonial charm with modern luxury, offering a tranquil sanctuary for travelers seeking authenticity and elegance.") }}
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mt-16 text-[10px] font-black uppercase tracking-[0.3em] text-rose-gold/80">
                <div class="flex flex-col items-center group">
                    <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-rose-gold group-hover:border-rose-gold group-hover:text-white group-hover:rotate-12 transition-all duration-700 text-rose-gold shadow-2xl">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="group-hover:text-white transition-colors">{{ __('Heritage Living') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-rose-gold group-hover:border-rose-gold group-hover:text-white group-hover:-rotate-12 transition-all duration-700 text-rose-gold shadow-2xl">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="group-hover:text-white transition-colors">{{ __('Authentic Cuisine') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-rose-gold group-hover:border-rose-gold group-hover:text-white group-hover:rotate-12 transition-all duration-700 text-rose-gold shadow-2xl">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <span class="group-hover:text-white transition-colors">{{ __('Lush Gardens') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-rose-gold group-hover:border-rose-gold group-hover:text-white group-hover:-rotate-12 transition-all duration-700 text-rose-gold shadow-2xl">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="group-hover:text-white transition-colors">{{ __('Curated Tours') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-24 bg-[#f8f5f2] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-rose-gold text-xs font-bold tracking-[0.2em] uppercase block mb-3">{{ __('Sanctuary') }}</span>
                <h2 class="font-serif text-4xl md:text-5xl text-rose-accent mb-6 uppercase tracking-wide">{{ __('Our Rooms') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto mb-6"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto">{{ __('Experience comfort in our historically preserved chambers, where every detail tells a story of the past.') }}</p>
            </div>

            <div class="space-y-32">
                @foreach($rooms as $room)
                    <div class="group relative bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] hover:shadow-[0_40px_80px_rgba(0,0,0,0.12)] transition-all duration-1000 overflow-hidden rounded-[2.5rem] border border-gray-100">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                            <!-- Image Column -->
                            <div class="relative h-[28rem] lg:h-auto overflow-hidden {{ $loop->even ? 'lg:order-2' : '' }}">
                                <img src="{{ str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image) }}" 
                                     alt="{{ $room->title }}" 
                                     class="w-full h-full object-cover transform scale-105 group-hover:scale-110 group-hover:rotate-1 transition-all duration-1000 ease-out">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-all duration-700"></div>
                                
                                <div class="absolute top-8 {{ $loop->even ? 'right-8' : 'left-8' }} flex flex-col items-center z-20">
                                    <div class="px-8 py-5 rounded-3xl bg-white shadow-[0_20px_40px_rgba(0,0,0,0.15)] flex flex-col items-center justify-center border border-white transition-all duration-500 hover:scale-105">
                                         <span class="text-[11px] font-black text-rose-gold uppercase tracking-[0.2em] mb-2.5">{{ __('Starting from') }}</span>
                                         <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-serif text-rose-accent uppercase">
                                                {{ \App\Helpers\CurrencyHelper::format($room->price_per_night) }}
                                            </span>
                                         </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content Column -->
                            <div class="p-10 md:p-20 flex flex-col justify-center relative {{ $loop->even ? 'lg:order-1' : '' }}">
                                <!-- Decorative Elements -->
                                <div class="absolute top-10 {{ $loop->even ? 'right-20' : 'left-20' }} text-[12rem] text-gray-50/50 font-serif -z-10 select-none leading-none">
                                    0{{ $loop->iteration }}
                                </div>

                                <div class="mb-10">
                                    <div class="flex items-center gap-4 mb-6">
                                        <span class="h-px w-10 bg-rose-gold"></span>
                                        <span class="text-xs font-black text-rose-gold uppercase tracking-[0.3em]">
                                            {{ __('Living Sanctuary') }}
                                        </span>
                                    </div>
                                    <h3 class="font-serif text-4xl md:text-6xl text-rose-accent uppercase mb-4 leading-tight tracking-tighter group-hover:translate-x-2 transition-transform duration-700 delay-100">{{ __($room->title) }}</h3>
                                    <div class="flex items-center gap-5">
                                        <span class="text-xs text-gray-400 uppercase tracking-widest font-bold">{{ __($room->bed_type) }}</span>
                                        <span class="w-2 h-2 rounded-full bg-rose-gold/40"></span>
                                        <span class="text-xs text-gray-400 uppercase tracking-widest font-bold">{{ __('Sleeps') }} {{ $room->capacity }}</span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 text-[15px] leading-relaxed font-normal mb-10 lg:pr-12 italic">
                                    "{{ __(Str::limit($room->description, 180)) }}"
                                </p>
                                
                                <div class="flex items-center gap-8 pt-8 border-t border-gray-100">
                                    <a href="#reservation" onclick="document.getElementById('room_id').value='{{ $room->id }}'" 
                                       class="group/btn relative inline-flex items-center gap-4 px-10 py-5 bg-rose-accent text-white rounded-full overflow-hidden transition-all duration-500 hover:shadow-[0_20px_40px_rgba(145,108,82,0.3)] active:scale-95">
                                        <span class="absolute inset-0 w-full h-full bg-rose-gold transform -translate-x-full group-hover/btn:translate-x-0 transition-transform duration-500"></span>
                                        <span class="relative text-sm font-black uppercase tracking-[0.2em] z-10">{{ __('Reserve Room') }}</span>
                                        <svg class="relative w-6 h-6 group-hover/btn:translate-x-1 transition-transform z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                    
                                    <div class="hidden sm:flex items-center gap-4">
                                        @foreach(collect($room->amenities)->take(2) as $amenity)
                                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400" title="{{ $amenity }}">
                                                @if(Str::contains(Str::lower($amenity), 'wi-fi')) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8.111 16.404a5.503 5.503 0 017.778 0M5.636 13.929a9 9 0 0112.728 0M12 20h.01m-9.091-9.091a13.5 13.5 0 0118.182 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                                @elseif(Str::contains(Str::lower($amenity), 'air')) <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 13h1m4 0h1m4 0h1m4 0h1m4 0h1M5 9c0 1.5 2 1.5 2 3s2 1.5 2 3M9 9c0 1.5 2 1.5 2 3s2 1.5 2 3m4-6c0 1.5 2 1.5 2 3s2 1.5 2 3m4-6c0 1.5 2 1.5 2 3s2 1.5 2 3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                                @else <span class="text-[10px] font-bold">{{ substr($amenity, 0, 1) }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Smooth Transition Spacer -->
    <div class="w-full bg-gradient-to-b from-[#f8f5f2] to-white" style="height: 12rem;"></div>

    <!-- Events Section -->
    <section id="events" class="pb-24 bg-white relative z-10" style="padding-top: 3rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-5xl text-rose-accent mb-6 uppercase tracking-widest leading-tight">
                    {!! $content['events_title'] ?? __('Celebrate <span class="text-rose-gold italic lowercase normal-case">in</span> Style') !!}
                </h2>
                <div class="w-24 h-1 bg-rose-gold mx-auto mb-8"></div>
                <p class="max-w-3xl mx-auto text-lg text-gray-700 font-normal leading-relaxed">
                    {{ $content['events_description'] ?? __('From intimate heritage weddings to executive retreats, let the timeless charm of Rose Villa be the backdrop for your most cherished moments.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @foreach($homeEvents as $event)
                    <div class="bg-white shadow-[0_15px_45px_rgba(0,0,0,0.05)] rounded-[2.5rem] group hover:-translate-y-3 transition-all duration-700 relative overflow-hidden border border-gray-50">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-rose-gold via-rose-accent to-rose-gold opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        
                        <!-- Image -->
                        <div class="relative h-72 overflow-hidden bg-rose-gold/5">
                            @if($event->image_path)
                                <img src="{{ str_starts_with($event->image_path, 'http') ? $event->image_path : (file_exists(public_path($event->image_path)) ? asset($event->image_path) : asset('storage/' . $event->image_path)) }}" 
                                     alt="{{ $event->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition duration-1000">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-rose-gold/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-rose-accent/40 to-transparent opacity-60"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-12">
                            <div class="text-rose-gold mb-8 transform group-hover:scale-110 group-hover:-rotate-3 transition duration-700">
                                @if($event->icon == 'heart')
                                    <div class="w-16 h-16 rounded-2xl bg-rose-gold/5 flex items-center justify-center mx-auto text-rose-gold"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></div>
                                @elseif($event->icon == 'building')
                                    <div class="w-16 h-16 rounded-2xl bg-rose-gold/5 flex items-center justify-center mx-auto text-rose-gold"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                                @elseif($event->icon == 'cake')
                                    <div class="w-16 h-16 rounded-2xl bg-rose-gold/5 flex items-center justify-center mx-auto text-rose-gold"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-17v1a1 1 0 01-1 1h-2a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1z"/></svg></div>
                                @endif
                            </div>
                            <h3 class="font-serif text-3xl text-rose-accent uppercase tracking-tight mb-6 text-center group-hover:text-rose-gold transition-colors duration-500">{{ __($event->title) }}</h3>
                            <p class="text-sm text-gray-500 font-medium leading-relaxed text-center italic group-hover:text-gray-700 transition-colors">
                                "{{ __($event->description) }}"
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="#contact" class="inline-flex items-center gap-4 bg-rose-accent text-white hover:bg-rose-dark px-12 py-5 rounded-full text-xs font-black uppercase tracking-[0.3em] transition-all duration-500 shadow-2xl hover:shadow-rose-accent/40 active:scale-95">
                    {{ __('Plan Your Event') }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Preview Section -->
    <section id="gallery" class="py-20 bg-[#f8f5f2]">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-rose-gold text-xs font-black tracking-[0.4em] uppercase block mb-4">{{ __('Gallery') }}</span>
                <h2 class="font-serif text-3xl md:text-5xl text-rose-accent mb-6 uppercase tracking-tight">{{ __('Glimpses of Rose Villa') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-8 rounded-full"></div>
            </div>
            <div class="columns-2 md:columns-4 gap-6 space-y-6">
                @foreach($gallery->take(8) as $image)
                    <div class="relative overflow-hidden group rounded-[2rem] shadow-xl hover:shadow-2xl transition-all duration-700 break-inside-avoid">
                        <img src="{{ str_starts_with($image->image_url, 'http') ? $image->image_url : asset('storage/' . $image->image_url) }}" alt="{{ $image->title }}" 
                             class="w-full h-auto object-cover transform group-hover:scale-110 group-hover:rotate-1 transition duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-rose-accent/80 via-rose-accent/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 flex flex-col justify-end p-8">
                            <span class="text-white uppercase tracking-[0.3em] text-[10px] font-black mb-2 translate-y-4 group-hover:translate-y-0 transition-transform duration-700">Heritage Frame</span>
                            <span class="text-white uppercase tracking-widest text-lg font-serif translate-y-4 group-hover:translate-y-0 transition-transform duration-700 delay-100">{{ __($image->title) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
         </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="py-20 bg-[#f9f9f9]">
        <div class="max-w-6xl mx-auto px-6">
             <div class="text-center mb-20">
                <span class="text-rose-gold text-xs font-black tracking-[0.4em] uppercase block mb-4">{{ __('Testimonials') }}</span>
                <h2 class="font-serif text-3xl md:text-5xl text-rose-accent mb-6 uppercase tracking-tight">{{ __('Guest Stories') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-8 rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white p-12 rounded-[3rem] shadow-[0_20px_60px_rgba(0,0,0,0.03)] border border-gray-50 relative group hover:-translate-y-3 transition-all duration-700">
                        <div class="absolute -top-8 left-12 flex">
                             <div class="bg-rose-gold text-white w-16 h-16 flex items-center justify-center rounded-2xl text-4xl font-serif shadow-2xl shadow-rose-gold/30 transform group-hover:rotate-6 transition-transform">“</div>
                        </div>
                        <p class="text-gray-600 text-base leading-relaxed font-medium italic mb-10 pt-8">
                            {{ Str::limit($review->comment, 180) }}
                        </p>
                        <div class="flex items-center gap-5 pt-8 border-t border-gray-50">
                            <div class="w-12 h-12 rounded-full bg-rose-gold/10 flex items-center justify-center font-serif text-rose-gold font-bold">
                                {{ substr($review->guest_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-serif text-rose-accent uppercase tracking-wider text-sm">{{ $review->guest_name }}</p>
                                <div class="flex gap-1 text-rose-gold text-[10px] mt-1">
                                    @for($i = 0; $i < $review->rating; $i++) <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservation" class="py-28 bg-[#fdfaf8] overflow-hidden relative">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 left-0 w-64 h-64 bg-rose-gold/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-rose-accent/5 rounded-full translate-x-1/3 translate-y-1/3"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-rose-gold text-xs font-bold tracking-[0.4em] uppercase block mb-4">{{ __('Booking Request') }}</span>
                <h2 class="font-serif text-4xl md:text-6xl text-rose-accent mb-6 uppercase tracking-tight">{{ __('Reserve Your Sanctuary') }}</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-8 rounded-full"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto leading-relaxed">
                    {{ __('Begin your journey to timeless elegance. Share your preferred dates and details, and our concierge will curate your perfect heritage experience.') }}
                </p>
            </div>

            @if(session('success'))
                <div class="mb-10 max-w-2xl mx-auto bg-white border-l-4 border-emerald-500 shadow-xl p-8 rounded-2xl flex items-center gap-6 animate-fade-in-up">
                    <div class="shrink-0 w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 uppercase tracking-wider text-sm">{{ __('Inquiry Received') }}</h4>
                        <p class="text-gray-500 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-[0_40px_120px_-20px_rgba(0,0,0,0.15)] rounded-[3rem] border border-gray-100 p-8 md:p-20 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-gold/5 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                
                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-16" 
                      x-data="{ 
                        checkIn: '', 
                        checkOut: '', 
                        roomId: '',
                        guests: 1,
                        taxRate: {{ \App\Models\ContentSetting::getValue('tax_percentage', 0) }},
                        exchangeRate: {{ \App\Helpers\CurrencyHelper::convert(1) }},
                        currencySymbol: '{{ \App\Helpers\CurrencyHelper::getCurrencySymbol() }}',
                        currencyCode: '{{ session('currency', 'LKR') }}',
                        rooms: {{ $rooms->mapWithKeys(fn($r) => [$r->id => ['price' => $r->price_per_night, 'title' => $r->title]])->toJson() }},
                        init() {
                            const params = new URLSearchParams(window.location.search);
                            if (params.get('check_in')) this.checkIn = params.get('check_in');
                            if (params.get('check_out')) this.checkOut = params.get('check_out');
                            if (params.get('guests')) this.guests = params.get('guests');
                        },
                        get nights() {
                            if (!this.checkIn || !this.checkOut) return 0;
                            const start = new Date(this.checkIn);
                            const end = new Date(this.checkOut);
                            if (isNaN(start) || isNaN(end)) return 0;
                            const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                            return diff > 0 ? diff : 0;
                        },
                        get estimatedTotal() {
                            if (!this.roomId || this.nights === 0) return 0;
                            const subtotal = this.rooms[this.roomId].price * this.nights;
                            const totalLkr = subtotal + (subtotal * this.taxRate / 100);
                            return (totalLkr * this.exchangeRate).toLocaleString(undefined, {
                                minimumFractionDigits: this.currencyCode === 'LKR' ? 0 : 2,
                                maximumFractionDigits: this.currencyCode === 'LKR' ? 0 : 2
                            });
                        },
                        specialReq: '',
                        additionalNotes: ''
                      }"
                      @set-room.window="roomId = $event.detail.id; $nextTick(() => document.getElementById('reservation').scrollIntoView({behavior: 'smooth'}))">
                    @csrf
                    
                    {{-- Section 1: Personal Details --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                        <div class="lg:col-span-4">
                            <div class="sticky top-32">
                                <span class="w-14 h-14 rounded-2xl bg-rose-gold text-white flex items-center justify-center font-black text-xl mb-6 shadow-2xl shadow-rose-gold/40 border-b-4 border-rose-accent/20">01</span>
                                <h3 class="text-2xl font-serif text-gray-900 uppercase tracking-tight mb-3">{{ __('Guest Identity') }}</h3>
                                <p class="text-xs text-gray-600 font-bold uppercase tracking-widest leading-relaxed">{{ __('Provide your credentials for a personalized welcome.') }}</p>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Full Name') }} <span class="text-rose-gold">*</span></label>
                                <input type="text" name="guest_name" required placeholder="John Doe" 
                                       class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 placeholder-gray-300">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Email Address') }} <span class="text-rose-gold">*</span></label>
                                <input type="email" name="email" required placeholder="john@example.com" 
                                       class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 placeholder-gray-300">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Contact Number') }}</label>
                                <input type="text" name="phone" placeholder="+94 ..." 
                                       class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 placeholder-gray-300">
                            </div>

                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Permanent Address') }}</label>
                                <input type="text" name="address" placeholder="123 Street, City" 
                                       class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 placeholder-gray-300">
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Stay Details --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pt-16 border-t border-gray-50">
                        <div class="lg:col-span-4">
                            <div class="sticky top-32">
                                <span class="w-14 h-14 rounded-2xl bg-rose-gold text-white flex items-center justify-center font-black text-xl mb-6 shadow-2xl shadow-rose-gold/40 border-b-4 border-rose-accent/20">02</span>
                                <h3 class="text-2xl font-serif text-gray-900 uppercase tracking-tight mb-3">{{ __('Your Sanctuary') }}</h3>
                                <p class="text-xs text-gray-600 font-bold uppercase tracking-widest leading-relaxed">{{ __('Choose your timing and preferred experience.') }}</p>
                            </div>
                        </div>

                        <div class="lg:col-span-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                                <div class="space-y-3">
                                    <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Check-In') }} <span class="text-rose-gold">*</span></label>
                                    <input type="date" name="check_in" x-model="checkIn" required 
                                           :min="new Date().toISOString().split('T')[0]"
                                           class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900">
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Check-Out') }} <span class="text-rose-gold">*</span></label>
                                    <input type="date" name="check_out" x-model="checkOut" required 
                                           :min="checkIn || new Date().toISOString().split('T')[0]"
                                           class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900">
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Room Type') }}</label>
                                    <select name="room_id" id="room_id" x-model="roomId" 
                                            class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 appearance-none">
                                        <option value="" class="bg-white">{{ __('Any Collection') }}</option>
                                        @foreach($rooms as $r)
                                            <option value="{{ $r->id }}" class="bg-white">{{ $r->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Guest Count') }}</label>
                                    <select name="guests" x-model="guests" required 
                                            class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 appearance-none">
                                        @foreach(range(1, 8) as $i)
                                            <option value="{{ $i }}" class="bg-white">{{ $i }} {{ $i > 1 ? 'People' : 'Person' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-3 md:col-span-2">
                                    <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Special Requirements') }}</label>
                                    <textarea name="special_requirements" x-model="specialReq" placeholder="{{ __('Do you have any dietary preferences or heritage site tour requests?') }}" 
                                              class="w-full px-8 py-6 bg-white border-2 border-gray-100 rounded-[2rem] focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 outline-none text-sm font-bold text-gray-900 placeholder-gray-300 min-h-[120px] resize-none"></textarea>
                                </div>
                            </div>

                            <div x-show="nights > 0 && roomId" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8"
                                 class="p-10 bg-gradient-to-br from-[#fafafa] to-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden relative">
                                <div class="absolute -right-12 -top-12 w-64 h-64 bg-rose-gold/5 rounded-full blur-3xl"></div>
                                <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-rose-accent/5 rounded-full blur-2xl"></div>
                                
                                <div class="flex flex-col gap-8 relative z-10">
                                    <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                                        <div class="flex items-center gap-6">
                                            <div class="w-1 h-16 bg-rose-gold rounded-full hidden md:block"></div>
                                            <div class="text-left">
                                                <p class="text-[9px] uppercase font-black text-rose-gold tracking-[0.4em] mb-1 opacity-70">Luxury Selection</p>
                                                <h4 class="font-serif text-3xl text-rose-accent uppercase leading-tight" x-text="rooms[roomId].title"></h4>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-12">
                                            <div class="text-center">
                                                <p class="text-[9px] uppercase font-black text-gray-400 tracking-[0.3em] mb-2">Duration</p>
                                                <p class="text-4xl font-serif text-rose-accent flex items-baseline gap-1">
                                                    <span x-text="nights"></span> 
                                                    <span class="text-[10px] uppercase font-black text-rose-gold tracking-widest" x-text="nights === 1 ? 'Night' : 'Nights'"></span>
                                                </p>
                                            </div>

                                            <div class="text-center bg-white px-10 py-6 rounded-3xl shadow-xl shadow-gray-100 border border-rose-gold/20 transform hover:scale-105 transition-transform duration-500">
                                                <p class="text-[9px] uppercase font-black text-rose-gold tracking-[0.3em] mb-2">Estimate Worth</p>
                                                <div class="flex items-baseline gap-2">
                                                    <span class="text-xs font-black text-rose-accent opacity-60" x-text="currencyCode"></span>
                                                    <span class="text-3xl font-serif text-rose-accent font-bold"><span x-text="currencySymbol"></span> <span x-text="estimatedTotal"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Live Preview of Notes --}}
                                    <div x-show="specialReq || additionalNotes" class="pt-6 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div x-show="specialReq">
                                            <p class="text-[9px] uppercase font-black text-rose-gold tracking-[0.3em] mb-2">Special Requirements</p>
                                            <p class="text-xs text-gray-600 italic leading-relaxed line-clamp-2" x-text="specialReq"></p>
                                        </div>
                                        <div x-show="additionalNotes">
                                            <p class="text-[9px] uppercase font-black text-rose-gold tracking-[0.3em] mb-2">Additional Notes</p>
                                            <p class="text-xs text-gray-600 italic leading-relaxed line-clamp-2" x-text="additionalNotes"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Final Touches --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pt-16 border-t border-gray-50">
                         <div class="lg:col-span-4">
                            <div class="sticky top-32">
                                <span class="w-14 h-14 rounded-2xl bg-rose-gold text-white flex items-center justify-center font-black text-xl mb-6 shadow-2xl shadow-rose-gold/40 border-b-4 border-rose-accent/20">03</span>
                                <h3 class="text-2xl font-serif text-gray-900 uppercase tracking-tight mb-3">{{ __('Special Rituals') }}</h3>
                                <p class="text-xs text-gray-600 font-bold uppercase tracking-widest leading-relaxed">{{ __('Tailor your stay with specific requirements or requests.') }}</p>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-8 space-y-12">
                            <div class="space-y-4">
                                <label class="block text-[11px] font-black text-gray-900 uppercase tracking-[0.2em] ml-2">{{ __('Additional Requests & Notes') }}</label>
                                <textarea name="additional_notes" x-model="additionalNotes" rows="5" placeholder="Special dietary needs, preferred arrival rituals, anniversary highlights..." 
                                          class="w-full bg-white border-2 border-gray-100 rounded-3xl focus:border-rose-gold focus:ring-4 focus:ring-rose-gold/5 transition-all duration-500 p-8 text-gray-900 font-bold placeholder-gray-300 italic text-sm leading-relaxed"></textarea>
                            </div>

                            <div class="flex flex-col items-center pt-8" x-show="roomId" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                                <button type="submit" class="group relative w-full inline-flex items-center justify-center px-16 py-8 rounded-[2rem] overflow-hidden shadow-2xl transition-all duration-700 active:scale-95 disabled:cursor-not-allowed group"
                                        :class="(!checkIn || !checkOut || nights < 1) ? 'bg-gray-100 text-gray-400 opacity-60' : 'bg-rose-accent text-white hover:bg-rose-dark hover:shadow-rose-accent/50'"
                                        :disabled="!checkIn || !checkOut || nights < 1">
                                    <div class="absolute inset-0 bg-gradient-to-r from-rose-accent via-rose-gold to-rose-accent opacity-0 group-hover:opacity-100 transition-opacity duration-700 blur-xl"></div>
                                    <span class="relative font-black uppercase tracking-[0.5em] text-sm z-10">{{ __('Inquire Reservation') }}</span>
                                    <svg class="relative w-6 h-6 ml-6 transform group-hover:translate-x-3 transition-transform duration-700 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </button>
                                <p class="mt-8 text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] flex items-center gap-4">
                                    <span class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> PRIVACY PROTECTED</span>
                                    <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                                    <span class="flex items-center gap-2"><svg class="w-4 h-4 text-rose-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg> RAPID CONCIERGE RESPONSE</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Nearest Places Section -->
    @if(isset($landmarks) && $landmarks->count() > 0)
    <section id="experiences" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                 <span class="text-rose-gold text-xs font-black tracking-[0.4em] uppercase block mb-4">{{ __('Explore') }}</span>
                <h2 class="font-serif text-4xl md:text-6xl text-rose-accent mb-6 uppercase tracking-tight leading-tight">{{ __('Nearest Places') }}</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-8 rounded-full"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto leading-relaxed">{{ __('Discover the rich heritage and vibrant culture of Jaffna, just moments from our doorstep.') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($landmarks as $landmark)
                    <a href="{{ $landmark->map_link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="group relative h-[28rem] overflow-hidden rounded-[2.5rem] shadow-lg cursor-pointer block hover:shadow-2xl transition-all duration-700">
                        @if($landmark->image_url)
                            <img src="{{ str_starts_with($landmark->image_url, 'http') ? $landmark->image_url : asset('storage/' . $landmark->image_url) }}" 
                                 alt="{{ $landmark->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000 ease-in-out">
                        @else
                            <div class="w-full h-full bg-rose-gold/10 flex items-center justify-center">
                                <svg class="w-20 h-20 text-rose-gold/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent transition-opacity duration-300">
                             <div class="absolute bottom-6 left-6 text-left">
                                <span class="inline-block px-2 py-1 border border-white/30 text-white/80 text-[10px] uppercase tracking-widest mb-2 bg-black/20">
                                    {{ $landmark->distance ?? 'Nearby' }}
                                </span>
                                <h3 class="font-serif text-xl text-white uppercase tracking-widest group-hover:text-rose-gold transition-colors">{{ __($landmark->title) }}</h3>
                                @if($landmark->description)
                                    <p class="text-gray-300 text-xs mt-2 line-clamp-2">{{ __($landmark->description) }}</p>
                                @endif
                                
                                <!-- Map Icon Indicator -->
                                @if($landmark->map_link)
                                    <div class="mt-3 flex items-center gap-2 text-rose-gold text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="uppercase tracking-wider">View on Map</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @else
        <!-- Fallback if no landmarks -->
        <div class="hidden"></div>
    @endif

    <!-- Location Section -->
    <section id="location" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-rose-gold text-xs font-black tracking-[0.4em] uppercase block mb-4">{{ __('Map') }}</span>
                <h2 class="font-serif text-4xl md:text-6xl text-rose-accent mb-6 uppercase tracking-tight leading-tight">{{ __('Find Us') }}</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent mx-auto mb-8 rounded-full"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto leading-relaxed">{{ __('Discover our sanctuary in the heart of Jaffna') }}</p>
            </div>
            
            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200 h-[500px]">
                <iframe src="{{ $content['map_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7864.813244882406!2d80.00654078217246!3d9.73158141202129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5498b86410df%3A0xd820147055601788!2sRose%20Villa%20Heritage%20Homes%20(pvt)%20Ltd!5e0!3m2!1sen!2snl!4v1769480636437!5m2!1sen!2snl' }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Contact & Footer -->
    <footer id="contact" class="bg-[#1a1a1a] text-white pt-24 pb-12 border-t border-rose-gold/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
                <!-- Brand -->
                <div class="space-y-6">
                    <h3 class="font-serif text-3xl text-white uppercase tracking-widest">Rose Villa</h3>
                    <p class="text-gray-300 text-sm leading-relaxed font-normal">
                        A sanctuary of heritage and luxury in the heart of Jaffna. Experience the timeless charm of our colonial home.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white transition duration-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white transition duration-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.225-.149-4.771-1.664-4.919-4.919-.059-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" title="TripAdvisor" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white transition duration-300">
                             <span class="text-[10px] font-bold">TA</span>
                        </a>
                    </div>
                    
                    <div class="pt-6">
                        <p class="text-[9px] uppercase font-black text-rose-gold tracking-[0.3em] mb-4">Currency</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['LKR', 'USD', 'EUR', 'CAD', 'INR'] as $code)
                                <a href="{{ route('currency.switch', $code) }}" class="text-[10px] font-black tracking-widest px-3 py-1.5 border border-white/10 rounded-lg hover:border-rose-gold transition {{ session('currency', 'LKR') == $code ? 'bg-rose-gold text-white border-rose-gold' : 'text-gray-400' }}">{{ $code }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                     <h4 class="font-serif text-sm text-rose-gold mb-8 uppercase tracking-widest">{{ __('Explore') }}</h4>
                     <ul class="space-y-4 text-sm text-gray-300 font-normal">
                        <li><a href="#about" class="hover:text-rose-gold transition duration-300 flex items-center gap-2"><span class="w-1.5 h-1.5 bg-rose-gold rounded-full"></span> {{ __('About Us') }}</a></li>
                        <li><a href="#rooms" class="hover:text-rose-gold transition duration-300 flex items-center gap-2"><span class="w-1.5 h-1.5 bg-rose-gold rounded-full"></span> {{ __('Our Rooms') }}</a></li>
                        <li><a href="#experiences" class="hover:text-rose-gold transition duration-300 flex items-center gap-2"><span class="w-1.5 h-1.5 bg-rose-gold rounded-full"></span> {{ __('Experiences') }}</a></li>
                        <li><a href="#gallery" class="hover:text-rose-gold transition duration-300 flex items-center gap-2"><span class="w-1.5 h-1.5 bg-rose-gold rounded-full"></span> {{ __('Gallery') }}</a></li>
                     </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-serif text-sm text-rose-gold mb-8 uppercase tracking-widest">Contact</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-light">
                        <li class="flex items-start gap-3">
                            <span class="text-rose-gold mt-1">📍</span>
                            <span>{{ $content['contact_address'] ?? '123 Heritage Lane, Jaffna' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-rose-gold">📞</span>
                            <span>{{ $content['contact_phone'] ?? '+94 77 123 4567' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-rose-gold">✉️</span>
                            <span>{{ $content['contact_email'] ?? 'info@rosevilla.com' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-serif text-sm text-rose-gold mb-8 uppercase tracking-widest">{{ __('Newsletter') }}</h4>
                    <p class="text-gray-400 text-sm mb-6 font-light">{{ __('Subscribe to receive exclusive offers and news from Rose Villa.') }}</p>
                    <form action="#" class="space-y-3">
                        <input type="email" placeholder="{{ __('Your Email Address') }}" class="w-full bg-white/5 border border-white/10 text-white text-sm px-4 py-3 focus:outline-none focus:border-rose-gold focus:ring-1 focus:ring-rose-gold transition">
                        <button type="submit" class="w-full bg-rose-gold text-white text-xs uppercase font-bold tracking-widest px-4 py-3 hover:bg-white hover:text-rose-primary transition duration-300">
                            {{ __('Subscribe') }}
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-500 uppercase tracking-widest">
                <div class="text-center md:text-left">
                    <p>&copy; {{ date('Y') }} Rose Villa Heritage Homes. {{ __('All Rights Reserved') }}.</p>
                    <p class="mt-3 normal-case text-xs font-medium text-gray-300">Powered by Gobikrishna Subramaniyam (BEng (Hons)) | Mobile: <a href="tel:+94766383402" class="text-rose-gold hover:text-white transition">+94 76 638 3402</a></p>
                </div>
                <div class="flex space-x-8 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Terms & Conditions') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Sitemap') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 bg-black/98 z-[200] hidden flex-col transition-opacity duration-300">
        <!-- Lightbox Header -->
        <div class="flex items-center justify-between p-6 md:p-10 z-10 bg-gradient-to-b from-black/80 to-transparent">
            <div class="flex flex-col">
                <h4 id="lightboxTitle" class="text-white font-serif text-xl md:text-2xl uppercase tracking-[0.2em]">Rooms</h4>
                <p id="lightboxCounter" class="text-rose-gold text-[10px] font-black uppercase tracking-[0.4em] mt-2">1 / 5</p>
            </div>
            <button onclick="closeLightbox()" class="p-4 rounded-2xl bg-white/5 border border-white/10 text-white hover:bg-white hover:text-black transition-all duration-500 group">
                <svg class="w-6 h-6 transform group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Main Display -->
        <div class="flex-grow flex items-center justify-center p-4 relative">
            <!-- Navigation -->
            <button onclick="navigateLightbox(-1)" class="absolute left-6 md:left-12 top-1/2 -translate-y-1/2 w-14 h-14 md:w-20 md:h-20 rounded-full border border-white/10 bg-white/5 text-white flex items-center justify-center hover:bg-white hover:text-black transition-all duration-500 z-20 group">
                <svg class="w-6 h-6 md:w-8 md:h-8 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="navigateLightbox(1)" class="absolute right-6 md:right-12 top-1/2 -translate-y-1/2 w-14 h-14 md:w-20 md:h-20 rounded-full border border-white/10 bg-white/5 text-white flex items-center justify-center hover:bg-white hover:text-black transition-all duration-500 z-20 group">
                <svg class="w-6 h-6 md:w-8 md:h-8 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Image -->
            <div class="w-full h-full flex items-center justify-center">
                <img id="lightboxImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain shadow-[0_50px_100px_rgba(0,0,0,0.5)] rounded-2xl border border-white/5">
            </div>
        </div>

        <!-- Lightbox Footer -->
        <div class="p-8 text-center bg-gradient-to-t from-black/50 to-transparent">
            <span class="text-[9px] font-black text-rose-gold uppercase tracking-[0.5em] opacity-50">Rose Villa Heritage Preview</span>
        </div>
    </div>

    <script>
        // Gallery data structure
        const galleryData = {
            @foreach($rooms as $room)
                '{{ $room->id }}': {
                    title: '{{ $room->title }}',
                    images: [
                        @foreach($room->gallery_urls ?? [] as $gurl)
                            '{{ str_starts_with($gurl, "http") ? $gurl : asset("storage/" . $gurl) }}',
                        @endforeach
                    ]
                },
            @endforeach
        };

        let currentRoomId = null;
        let currentImageIndex = 0;

        function openLightbox(roomId, imageIndex) {
            currentRoomId = roomId;
            currentImageIndex = imageIndex;
            updateLightboxImage();
            
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Fade in animation
            setTimeout(() => {
                lightbox.style.opacity = '1';
            }, 10);
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.style.opacity = '0';
            
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function navigateLightbox(direction) {
            if (!currentRoomId) return;
            
            const images = galleryData[currentRoomId].images;
            currentImageIndex = (currentImageIndex + direction + images.length) % images.length;
            updateLightboxImage();
        }

        function updateLightboxImage() {
            if (!currentRoomId) return;
            
            const roomData = galleryData[currentRoomId];
            const images = roomData.images;
            
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxCounter = document.getElementById('lightboxCounter');
            const lightboxTitle = document.getElementById('lightboxTitle');
            
            // Fade out
            lightboxImage.style.opacity = '0';
            
            setTimeout(() => {
                lightboxImage.src = images[currentImageIndex];
                lightboxCounter.textContent = `${currentImageIndex + 1} / ${images.length}`;
                lightboxTitle.textContent = roomData.title;
                
                // Fade in
                lightboxImage.style.opacity = '1';
            }, 150);
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('lightbox');
            if (!lightbox.classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox(1);
                }
            }
        });

        // Click outside to close
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Smooth image transitions
        document.getElementById('lightboxImage').style.transition = 'opacity 0.15s ease-in-out';
    </script>
</body>
</html>
