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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-rose-text antialiased bg-white">
    @php
        $heroTitle = $content['hero_title'] ?? 'Rose Villa';
        $heroSubtitle = $content['hero_subtitle'] ?? 'Experience the Extraordinary in Jaffna';
        // Updated to use the live site's hero image
        $heroImage = 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/11/front-page.png'; 
    @endphp

    <!-- Header -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 50)"
            :class="{ 'bg-rose-primary shadow-lg py-4': scrolled, 'bg-gradient-to-b from-black/80 to-transparent py-6': !scrolled }"
            class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block">
                         <img src="https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Screenshot-2024-08-05-174751-removebg-preview1.png" 
                              alt="Rose Villa Logo" 
                              class="transition-all duration-300"
                              :class="scrolled ? 'h-12' : 'h-16'">
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-7 items-center">
                    <a href="#about" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('About') }}</a>
                    <a href="#rooms" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('Suites') }}</a>
                    <a href="#gallery" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('Gallery') }}</a>
                    <a href="#experiences" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('Experiences') }}</a>
                    <a href="#events" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('Events') }}</a>
                    <a href="#contact" class="text-white hover:text-rose-gold uppercase text-[0.7rem] tracking-[0.2em] font-bold transition">{{ __('Contact') }}</a>
                    
                    <!-- Language Switcher -->
                    <div class="relative group ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1.5 text-white hover:text-rose-gold text-[0.65rem] font-bold uppercase transition border border-white/20 px-3 py-1.5 rounded-sm bg-white/5">
                            <span class="opacity-70">
                                @if(app()->getLocale() == 'en') EN @elseif(app()->getLocale() == 'si') සිං @else தம @endif
                            </span>
                            <svg class="w-2.5 h-2.5 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-3 w-32 bg-white rounded shadow-2xl overflow-hidden py-1.5 z-50">
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-[10px] font-bold text-gray-700 hover:bg-rose-50 hover:text-rose-primary transition uppercase tracking-widest {{ app()->getLocale() == 'en' ? 'text-rose-gold' : '' }}">English</a>
                            <a href="{{ route('lang.switch', 'si') }}" class="block px-4 py-2 text-[10px] font-bold text-gray-700 hover:bg-rose-50 hover:text-rose-primary transition tracking-widest {{ app()->getLocale() == 'si' ? 'text-rose-gold' : '' }}">සිංහල</a>
                            <a href="{{ route('lang.switch', 'ta') }}" class="block px-4 py-2 text-[10px] font-bold text-gray-700 hover:bg-rose-50 hover:text-rose-primary transition tracking-widest {{ app()->getLocale() == 'ta' ? 'text-rose-gold' : '' }}">தமிழ்</a>
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    <a href="#reservation" class="ml-4 bg-rose-gold hover:bg-white hover:text-rose-primary text-white text-[0.65rem] font-bold uppercase px-6 py-3.5 tracking-[0.2em] transition duration-500 shadow-xl">
                        {{ __('Book Your Stay') }}
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-transparent p-2 text-white hover:text-rose-gold transition">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="mobileMenuOpen ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="mobileMenuOpen ? 'inline-flex' : 'hidden'" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Container -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-x-full" 
             x-transition:enter-end="opacity-100 translate-x-0" 
             style="display: none;"
             class="fixed inset-0 z-50 bg-rose-primary/95 backdrop-blur-xl flex flex-col">
            
            <div class="flex justify-between items-center px-6 py-6 border-b border-white/10">
                <span class="text-white font-serif text-xl uppercase tracking-widest">Menu</span>
                <button @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 px-6 py-12 flex flex-col justify-center space-y-6 text-center">
                <a href="#about" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('About') }}</a>
                <a href="#rooms" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('Suites') }}</a>
                <a href="#gallery" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('Gallery') }}</a>
                <a href="#experiences" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('Experiences') }}</a>
                <a href="#events" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('Events') }}</a>
                <a href="#contact" @click="mobileMenuOpen = false" class="text-white hover:text-rose-gold uppercase text-xl tracking-[0.2em] font-serif transition">{{ __('Contact') }}</a>
                
                <!-- Mobile Language switcher -->
                <div class="pt-8 border-t border-white/10 flex justify-center gap-6">
                    <a href="{{ route('lang.switch', 'en') }}" class="text-white hover:text-rose-gold text-sm font-bold uppercase tracking-widest {{ app()->getLocale() == 'en' ? 'border-b border-rose-gold' : '' }}">EN</a>
                    <a href="{{ route('lang.switch', 'si') }}" class="text-white hover:text-rose-gold text-sm font-bold uppercase tracking-widest {{ app()->getLocale() == 'si' ? 'border-b border-rose-gold' : '' }}">සිං</a>
                    <a href="{{ route('lang.switch', 'ta') }}" class="text-white hover:text-rose-gold text-sm font-bold uppercase tracking-widest {{ app()->getLocale() == 'ta' ? 'border-b border-rose-gold' : '' }}">தம</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="relative h-screen flex items-center justify-center overflow-hidden bg-black">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImage }}" alt="Rose Villa Heritage Home" class="w-full h-full object-cover opacity-100 animate-ken-burns">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-1 text-center px-4 max-w-5xl mx-auto mt-16">
            <h1 class="font-serif text-5xl md:text-8xl text-white mb-6 drop-shadow-2xl tracking-tight uppercase leading-none opacity-0 animate-fade-in-up" 
                style="animation-delay: 0.3s; animation-fill-mode: forwards;">
                {{ __($heroTitle) }}
            </h1>
            <div class="w-24 h-1 bg-rose-gold mx-auto mb-8 rounded-full opacity-0 animate-fade-in-up" style="animation-delay: 0.6s; animation-fill-mode: forwards;"></div>
            <p class="text-gray-100 text-lg md:text-2xl font-light tracking-wide mb-10 opacity-0 animate-fade-in-up" 
               style="animation-delay: 0.8s; animation-fill-mode: forwards;">
                {{ __($heroSubtitle) }}
            </p>
            <div class="opacity-0 animate-fade-in-up" style="animation-delay: 1s; animation-fill-mode: forwards;">
                <a href="#rooms" class="group relative inline-flex items-center justify-center px-8 py-4 text-sm font-bold text-white uppercase tracking-[0.2em] transition-all duration-300 border border-white hover:bg-white hover:text-rose-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-gold">
                    <span class="absolute inset-0 w-full h-full bg-white/10 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                    <span class="relative">{{ __('Explore Collection') }}</span>
                </a>
            </div>

            <!-- Booking Widget -->
            <div class="mt-16 bg-white/10 backdrop-blur-md p-6 rounded-lg border border-white/20 shadow-2xl hidden md:block opacity-0 animate-fade-in-up" 
                 style="animation-delay: 1.2s; animation-fill-mode: forwards;">
                <form action="#reservation" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 text-left">
                        <label class="block text-white text-[10px] uppercase tracking-wider mb-1">{{ __('Check In') }}</label>
                        <input type="date" class="w-full bg-white/90 border-0 text-gray-800 text-xs focus:ring-rose-gold rounded-sm h-10">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-[10px] uppercase tracking-wider mb-1">{{ __('Check Out') }}</label>
                        <input type="date" class="w-full bg-white/90 border-0 text-gray-800 text-xs focus:ring-rose-gold rounded-sm h-10">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-[10px] uppercase tracking-wider mb-1">{{ __('Guests') }}</label>
                        <select class="w-full bg-white/90 border-0 text-gray-800 text-xs focus:ring-rose-gold rounded-sm h-10">
                            <option>1 {{ __('Guest') }}</option>
                            <option>2 {{ __('Guests') }}</option>
                            <option>3 {{ __('Guests') }}</option>
                            <option>4+ {{ __('Guests') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-rose-gold hover:bg-white hover:text-rose-primary text-white text-xs font-bold uppercase px-8 h-10 tracking-widest transition duration-300 shadow-md">
                        {{ __('Search Availability') }}
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
    <section id="about" class="py-20 md:py-32 bg-rose-primary">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-serif text-3xl md:text-4xl text-white mb-8 uppercase tracking-wide">
                {{ __('Wander & Explore') }}
            </h2>
            <div class="w-24 h-1 bg-rose-gold mx-auto mb-10"></div>
            <p class="text-lg leading-relaxed text-white/90 mb-8 font-light">
                {{ $content['about_text'] ?? __("Nestled in the heart of Jaffna, Rose Villa is more than just a place to stay—it's a journey back in time. Our heritage home blends colonial charm with modern luxury, offering a tranquil sanctuary for travelers seeking authenticity and elegance.") }}
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 text-sm uppercase tracking-wider text-white">
                <div class="flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-full border border-rose-gold/30 flex items-center justify-center mb-4 group-hover:bg-rose-gold group-hover:text-white transition duration-500 text-rose-gold">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span>{{ __('Heritage Living') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-full border border-rose-gold/30 flex items-center justify-center mb-4 group-hover:bg-rose-gold group-hover:text-white transition duration-500 text-rose-gold">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span>{{ __('Authentic Cuisine') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-full border border-rose-gold/30 flex items-center justify-center mb-4 group-hover:bg-rose-gold group-hover:text-white transition duration-500 text-rose-gold">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <span>{{ __('Lush Gardens') }}</span>
                </div>
                <div class="flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-full border border-rose-gold/30 flex items-center justify-center mb-4 group-hover:bg-rose-gold group-hover:text-white transition duration-500 text-rose-gold">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span>{{ __('Curated Tours') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-24 bg-[#f8f5f2] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-rose-gold text-xs font-bold tracking-[0.2em] uppercase block mb-3">{{ __('Sanctuary') }}</span>
                <h2 class="font-serif text-4xl md:text-5xl text-rose-accent mb-6 uppercase tracking-wide">{{ __('Our Suites') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto mb-6"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto">{{ __('Experience comfort in our historically preserved chambers, where every detail tells a story of the past.') }}</p>
            </div>

            <div class="space-y-24">
                @foreach($rooms as $room)
                    <div class="group relative bg-white shadow-xl overflow-hidden round-sm">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                            <!-- Image Column -->
                            <div class="relative h-96 lg:h-auto overflow-hidden {{ $loop->even ? 'lg:order-2' : '' }}">
                                <img src="{{ str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image) }}" 
                                     alt="{{ $room->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000 ease-in-out">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-500"></div>
                            </div>
                            
                            <!-- Content Column -->
                            <div class="p-10 md:p-16 flex flex-col justify-center text-center lg:text-left relative {{ $loop->even ? 'lg:order-1' : '' }}">
                                <!-- Decorative Elements -->
                                <div class="hidden lg:block absolute top-10 {{ $loop->even ? 'right-10' : 'left-10' }} text-6xl text-gray-100 font-serif -z-10 select-none">
                                    0{{ $loop->iteration }}
                                </div>

                                <div class="mb-6">
                                    <span class="inline-block py-1 px-3 border border-rose-gold/30 text-rose-gold text-[10px] uppercase tracking-widest font-semibold mb-4">
                                        {{ __('Sleeps') }} {{ $room->capacity }}
                                    </span>
                                    <h3 class="font-serif text-3xl md:text-4xl text-rose-accent uppercase mb-2">{{ __($room->title) }}</h3>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">{{ __($room->bed_type) }}</p>
                                </div>
                                
                                <p class="text-gray-600 text-sm leading-8 font-light mb-8 lg:pr-8">
                                    {{ __(Str::limit($room->description, 200)) }}
                                </p>
                                
                                <div class="flex flex-col lg:flex-row items-center lg:items-center gap-6 mt-auto">
                                    <div class="text-center lg:text-left">
                                        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ __('Starting from') }}</p>
                                        <p class="text-2xl font-serif text-rose-accent">LKR {{ number_format($room->price_per_night, 0) }}</p>
                                    </div>
                                    
                                    <div class="flex-grow"></div>

                                    <a href="#reservation" onclick="document.getElementById('room_id').value='{{ $room->id }}'" 
                                       class="inline-block bg-rose-accent text-white border border-rose-accent px-8 py-3 text-xs uppercase tracking-[0.15em] hover:bg-white hover:text-rose-accent transition duration-300">
                                        {{ __('Book Now') }}
                                    </a>
                                </div>

                                <!-- Amenities Preview -->
                                <div class="mt-8 pt-8 border-t border-gray-100 flex flex-wrap justify-center lg:justify-start gap-4 text-gray-400 text-xs uppercase tracking-wider">
                                    @foreach(collect($room->amenities)->take(3) as $amenity)
                                        <span class="flex items-center gap-2">
                                            <span class="w-1 h-1 bg-rose-gold rounded-full"></span> {{ __($amenity) }}
                                        </span>
                                    @endforeach
                                    @if(count($room->amenities ?? []) > 3)
                                        <span class="text-rose-gold">+{{ count($room->amenities) - 3 }} {{ __('more') }}</span>
                                    @endif
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
                <p class="max-w-3xl mx-auto text-lg text-gray-600 font-light leading-relaxed">
                    {{ $content['events_description'] ?? __('From intimate heritage weddings to executive retreats, let the timeless charm of Rose Villa be the backdrop for your most cherished moments.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @foreach($homeEvents as $event)
                    <div class="bg-white shadow-xl border border-gray-100 group hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-rose-gold to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        
                        <!-- Image -->
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ str_starts_with($event->image_path, 'http') ? $event->image_path : (file_exists(public_path($event->image_path)) ? asset($event->image_path) : asset('storage/' . $event->image_path)) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-10">
                            <div class="text-rose-gold mb-6 text-center transform group-hover:scale-110 transition duration-500">
                                @if($event->icon == 'heart')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                @elseif($event->icon == 'building')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @elseif($event->icon == 'cake')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-17v1a1 1 0 01-1 1h-2a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1z"/></svg>
                                @elseif($event->icon == 'star')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                @elseif($event->icon == 'music')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                @elseif($event->icon == 'camera')
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @endif
                            </div>
                            <h3 class="font-serif text-2xl text-rose-accent uppercase tracking-widest mb-4 text-center">{{ __($event->title) }}</h3>
                            <p class="text-sm text-gray-500 font-light leading-relaxed text-center">
                                {{ __($event->description) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="#contact" class="inline-block bg-rose-accent text-white hover:bg-rose-primary px-10 py-4 text-sm font-bold uppercase tracking-widest transition duration-300 shadow-lg hover:shadow-xl">
                    {{ __('Plan Your Event') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Preview Section -->
    <section id="gallery" class="py-20 bg-[#f8f5f2]">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">{{ __('Glimpses of Rose Villa') }}</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($gallery->take(8) as $image)
                    <div class="relative h-64 overflow-hidden group">
                        <img src="{{ str_starts_with($image->image_url, 'http') ? $image->image_url : asset('storage/' . $image->image_url) }}" alt="{{ $image->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-500 flex items-center justify-center">
                            <span class="text-white uppercase tracking-widest text-xs font-semibold">{{ __($image->title) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
         </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="py-20 bg-[#f9f9f9]">
        <div class="max-w-6xl mx-auto px-6">
             <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">{{ __('Guest Stories') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                    <div class="bg-white p-8 shadow-sm border-t-4 border-rose-gold relative">
                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-rose-gold text-white w-10 h-10 flex items-center justify-center rounded-full text-xl font-serif">“</div>
                        <p class="text-gray-600 text-sm leading-relaxed italic mb-6 pt-4 text-center">
                            {{ Str::limit($review->comment, 150) }}
                        </p>
                        <div class="text-center">
                            <p class="font-serif text-rose-accent uppercase tracking-wide text-sm">{{ $review->guest_name }}</p>
                            <div class="text-rose-gold text-xs mt-1">
                                @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservation" class="py-24 bg-[#f8f5f2]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">{{ __('Reserve Your Sanctuary') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto mb-6"></div>
                <p class="text-gray-600 font-light">{{ __('Tell us your plans, and we will curate your perfect stay.') }}</p>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-2xl p-10 md:p-14 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rose-accent via-rose-gold to-rose-accent"></div>
                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Guest Details -->
                        <div class="col-span-1 md:col-span-2">
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Full Name') }}</label>
                             <input type="text" name="guest_name" required class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 placeholder-gray-300 font-light" placeholder="e.g. John Doe">
                             @error('guest_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Email Address') }}</label>
                             <input type="email" name="email" required class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 placeholder-gray-300 font-light" placeholder="john@example.com">
                             @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
 
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Phone Number') }}</label>
                             <input type="text" name="phone" class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 placeholder-gray-300 font-light" placeholder="+94 ...">
                        </div>
 
                        <!-- Stay Details -->
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Check-in Date') }}</label>
                             <input type="date" name="check_in" required class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 font-light text-gray-600">
                        </div>
 
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Check-out Date') }}</label>
                             <input type="date" name="check_out" required class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 font-light text-gray-600">
                        </div>
 
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Preferred Suite') }}</label>
                             <select name="room_id" id="room_id" class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 font-light text-gray-600">
                                 <option value="">-- {{ __('Select a Suite') }} --</option>
                                 @foreach($rooms as $r)
                                     <option value="{{ $r->id }}">{{ $r->title }} (LKR {{ number_format($r->price_per_night) }})</option>
                                 @endforeach
                             </select>
                        </div>
 
                        <div>
                             <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Guests') }}</label>
                             <select name="guests" required class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 font-light text-gray-600">
                                 @foreach(range(1, 8) as $i)
                                     <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? __('Guests') : __('Guest') }}</option>
                                 @endforeach
                             </select>
                        </div>
                    </div>
 
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2 font-bold">{{ __('Special Requests') }}</label>
                        <textarea name="message" rows="3" class="w-full border-b border-gray-300 focus:border-rose-gold outline-none ring-0 px-0 py-2 bg-transparent transition duration-300 placeholder-gray-300 font-light" placeholder="Dietary restrictions, arrival times, etc..."></textarea>
                    </div>

                    <div class="text-center pt-8">
                        <button type="submit" class="bg-rose-accent text-white hover:bg-white hover:text-rose-accent border border-rose-accent transition px-12 py-4 uppercase tracking-[0.2em] text-xs font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-300">
                            {{ __('Request Reservation') }}
                        </button>
                        <p class="mt-6 text-[10px] text-gray-400 uppercase tracking-widest">{{ __('Our Concierge will contact you to confirm') }}</p>
                    </div>
                </form>
            </div>
        </div>
    <!-- Nearest Places Section -->
    @if(isset($landmarks) && $landmarks->count() > 0)
    <section id="experiences" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                 <span class="text-rose-gold text-xs font-bold tracking-[0.2em] uppercase block mb-3">{{ __('Explore') }}</span>
                <h2 class="font-serif text-3xl md:text-5xl text-rose-accent mb-6 uppercase tracking-wide">{{ __('Nearest Places') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto mb-6"></div>
                <p class="text-gray-500 font-light max-w-2xl mx-auto">{{ __('Discover the rich heritage and vibrant culture of Jaffna, just moments from our doorstep.') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($landmarks as $landmark)
                    <a href="{{ $landmark->map_link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="group relative h-80 overflow-hidden rounded-sm shadow-lg cursor-pointer block hover:shadow-2xl transition-shadow duration-300">
                        <img src="{{ str_starts_with($landmark->image_url, 'http') ? $landmark->image_url : asset('storage/' . $landmark->image_url) }}" 
                             alt="{{ $landmark->title }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000 ease-in-out">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent transition-opacity duration-300">
                             <div class="absolute bottom-6 left-6 text-left">
                                <span class="inline-block px-2 py-1 border border-white/30 text-white/80 text-[10px] uppercase tracking-widest mb-2 backdrop-blur-sm">
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
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">{{ __('Find Us') }}</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto"></div>
                <p class="text-gray-500 font-light mt-4">{{ __('Discover our sanctuary in the heart of Jaffna') }}</p>
            </div>
            
            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200 h-[500px]">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7864.813254581939!2d80.015534!3d9.731581!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5498b86410df%3A0xd820147055601788!2sRose%20Villa%20Heritage%20Homes%20(pvt)%20Ltd!5e0!3m2!1sen!2slk!4v1768293510945!5m2!1sen!2slk" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                    <p class="text-gray-400 text-sm leading-relaxed font-light">
                        A sanctuary of heritage and luxury in the heart of Jaffna. Experience the timeless charm of our colonial home.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white transition duration-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white transition duration-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.225-.149-4.771-1.664-4.919-4.919-.059-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                     <h4 class="font-serif text-sm text-rose-gold mb-8 uppercase tracking-widest">{{ __('Explore') }}</h4>
                     <ul class="space-y-4 text-sm text-gray-400 font-light">
                        <li><a href="#about" class="hover:text-white transition duration-300 flex items-center gap-2"><span class="w-1 h-1 bg-rose-gold rounded-full"></span> {{ __('About Us') }}</a></li>
                        <li><a href="#rooms" class="hover:text-white transition duration-300 flex items-center gap-2"><span class="w-1 h-1 bg-rose-gold rounded-full"></span> {{ __('Our Suites') }}</a></li>
                        <li><a href="#experiences" class="hover:text-white transition duration-300 flex items-center gap-2"><span class="w-1 h-1 bg-rose-gold rounded-full"></span> {{ __('Experiences') }}</a></li>
                        <li><a href="#gallery" class="hover:text-white transition duration-300 flex items-center gap-2"><span class="w-1 h-1 bg-rose-gold rounded-full"></span> {{ __('Gallery') }}</a></li>
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
                <p>&copy; {{ date('Y') }} Rose Villa Heritage Homes. {{ __('All Rights Reserved') }}.</p>
                <div class="flex space-x-8 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Terms & Conditions') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Sitemap') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center p-4 transition-opacity duration-300">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-rose-gold transition-colors z-10 group">
            <svg class="w-8 h-8 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Previous Button -->
        <button onclick="navigateLightbox(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-rose-gold transition-colors z-10 group">
            <svg class="w-10 h-10 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Next Button -->
        <button onclick="navigateLightbox(1)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-rose-gold transition-colors z-10 group">
            <svg class="w-10 h-10 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="max-w-6xl max-h-[90vh] w-full h-full flex flex-col items-center justify-center">
            <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            
            <!-- Image Info -->
            <div class="mt-4 text-center">
                <p id="lightboxCounter" class="text-white text-sm uppercase tracking-wider"></p>
                <p id="lightboxTitle" class="text-rose-gold text-xs uppercase tracking-widest mt-1"></p>
            </div>
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
