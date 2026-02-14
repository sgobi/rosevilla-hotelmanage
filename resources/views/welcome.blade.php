<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>Rose Villa Heritage Homes | Luxury Stay in Jaffna</title>
    <meta name="description" content="Experience the charm of Rose Villa Heritage Homes in Jaffna. A blend of colonial elegance and modern luxury. Book your stay for an unforgettable authentic experience.">
    <meta name="keywords" content="Rose Villa, Heritage Home Jaffna, Luxury Hotel Jaffna, Boutique Hotel Sri Lanka, Jaffna Accommodation, Colonial Villa Jaffna, Best Places to Stay in Jaffna">
    <meta name="author" content="Rose Villa Heritage Homes">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Rose Villa Heritage Homes | Luxury Stay in Jaffna">
    <meta property="og:description" content="Experience the charm of Rose Villa Heritage Homes in Jaffna. A blend of colonial elegance and modern luxury.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">
    <meta property="og:site_name" content="Rose Villa Heritage Homes">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Rose Villa Heritage Homes | Luxury Stay in Jaffna">
    <meta property="twitter:description" content="Experience the charm of Rose Villa Heritage Homes in Jaffna. A blend of colonial elegance and modern luxury.">
    <meta property="twitter:image" content="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-rose-text antialiased bg-white">

    <!-- Header -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 50)"
            :class="{ 'bg-rose-primary shadow-lg': scrolled, 'bg-gradient-to-b from-black/80 to-transparent': !scrolled }"
            class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-white font-serif text-2xl tracking-widest uppercase hover:text-rose-accent transition">
                        Rose Villa
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8 items-center" aria-label="Main Navigation">
                    <a href="#home" class="text-white hover:text-rose-accent uppercase text-xs tracking-widest font-semibold transition">Home</a>
                    <a href="#about" class="text-white hover:text-rose-accent uppercase text-xs tracking-widest font-semibold transition">The Villa</a>
                    <a href="#rooms" class="text-white hover:text-rose-accent uppercase text-xs tracking-widest font-semibold transition">Rooms</a>
                    <a href="#experiences" class="text-white hover:text-rose-accent uppercase text-xs tracking-widest font-semibold transition">Experiences</a>
                    <a href="#contact" class="text-white hover:text-rose-accent uppercase text-xs tracking-widest font-semibold transition">Contact</a>
                    
                    <!-- Book Now Button -->
                    <a href="#book-now" class="ml-4 bg-rose-accent hover:bg-white hover:text-rose-primary text-white text-xs font-bold uppercase px-6 py-3 tracking-widest transition duration-300">
                        Book Your Stay
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-transparent p-2 text-white hover:text-gray-300" aria-label="Open main menu">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
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
                 class="fixed inset-0 z-[100] bg-rose-primary flex flex-col">
                
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between p-6 border-b border-white/10 bg-black/20">
                    <div class="flex items-center gap-3">
                        <span class="text-white text-lg font-serif tracking-[0.2em] uppercase">Rose Villa</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-3 rounded-2xl bg-white/10 border border-white/10 text-white transition-all active:scale-90">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Mobile Menu Body -->
                <div class="flex-grow overflow-y-auto px-6 py-8 space-y-4">
                    @php
                        $welcomeItems = [
                            ['label' => 'The Villa', 'link' => '#about', 'sub' => 'Our Sanctuary', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['label' => 'Rooms', 'link' => '#rooms', 'sub' => 'Heritage Chambers', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['label' => 'Experiences', 'link' => '#experiences', 'sub' => 'Jaffna Flavours', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0L4 10.172V17a1 1 0 001 1h14a1 1 0 001-1v-6.828l-5.172 4.656z'],
                            ['label' => 'Contact', 'link' => '#contact', 'sub' => 'Get in Touch', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ];
                    @endphp

                    @foreach($welcomeItems as $item)
                        <a href="{{ $item['link'] }}" @click="mobileMenuOpen = false" class="group flex items-center justify-between p-5 rounded-[1.5rem] bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-rose-accent group-hover:bg-white group-hover:text-rose-primary transition-all duration-300 shadow-xl shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-serif text-white group-hover:text-rose-accent transition-colors">{{ __($item['label']) }}</h3>
                                    <p class="text-[8px] font-black text-white/40 uppercase tracking-[0.2em] mt-1">{{ __($item['sub']) }}</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-white/20 group-hover:text-white transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @endforeach

                    @auth
                        <div class="mt-6 pt-6 border-t border-white/10 space-y-3">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 p-4 rounded-xl bg-emerald-500/20 text-emerald-100 border border-emerald-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-black uppercase tracking-widest text-xs">Dashboard</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-4 p-4 rounded-xl bg-white/5 text-white/60 border border-white/10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span class="font-black uppercase tracking-widest text-[10px]">Sign Out</span>
                                </button>
                            </form>
                        </div>
                    @endauth

                    <div class="mt-8 text-center pb-8">
                         <p class="text-[9px] text-white/30 uppercase tracking-[0.6em] font-black italic">Rose Villa Heritage</p>
                    </div>
                </div>
            </div>
        </template>
    </header>

    <!-- Hero Section -->
    <div id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image (Eager Load) -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Rose Villa Heritage Home in Jaffna" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-1 text-center px-4">
            <h1 class="font-serif text-5xl md:text-7xl text-white mb-6 drop-shadow-lg tracking-wide uppercase">
                Rose Villa
            </h1>
            <p class="text-white text-lg md:text-xl font-light tracking-widest uppercase mb-8">
                Experience the Extraordinary in Jaffna
            </p>
            <a href="#rooms" class="inline-block border-2 border-white text-white hover:bg-white hover:text-rose-primary px-8 py-3 text-sm font-semibold uppercase tracking-widest transition duration-300">
                Explore Our Heritage
            </a>

            <!-- Booking Widget -->
            <div class="mt-12 bg-white/10 backdrop-blur-md p-6 rounded-lg border border-white/20 shadow-2xl max-w-4xl mx-auto hidden md:block">
                <form action="#" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 text-left">
                        <label class="block text-white text-xs uppercase tracking-wider mb-1">Check In</label>
                        <input type="date" class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm" aria-label="Check In Date">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-xs uppercase tracking-wider mb-1">Check Out</label>
                        <input type="date" class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm" aria-label="Check Out Date">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-xs uppercase tracking-wider mb-1">Guests</label>
                        <select class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm" aria-label="Number of Guests">
                            <option>1 Guest</option>
                            <option>2 Guests</option>
                            <option>3 Guests</option>
                            <option>4+ Guests</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-rose-accent hover:bg-white hover:text-rose-primary text-white text-sm font-bold uppercase px-8 py-2 h-[38px] tracking-widest transition duration-300 shadow-md">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- About / Welcome Section -->
    <section id="about" class="py-20 md:py-32 bg-white text-rose-dark">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-serif text-3xl md:text-4xl text-rose-primary mb-8 uppercase tracking-wide">
                About Rose Villa Heritage Home
            </h2>
            <div class="w-24 h-1 bg-rose-gold mx-auto mb-10"></div>
            <p class="text-lg leading-relaxed text-gray-600 mb-8 font-light">
                Nestled in the heart of Jaffna, Rose Villa is more than just a place to stay—it's a journey back in time. Our heritage home blends colonial charm with modern luxury, offering a tranquil sanctuary for travelers seeking authenticity and elegance.
            </p>
            <p class="text-lg leading-relaxed text-gray-600 font-light">
                Discover the rich history, vibrant culture, and warm hospitality that define our heritage.
            </p>
        </div>
    </section>

    <!-- Features Section (Grid) -->
    <section id="experiences" class="py-16 bg-rose-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="sr-only">Our Experiences</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Suites at Rose Villa" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                         <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                    <h3 class="font-serif text-xl text-rose-accent uppercase mb-2 group-hover:text-rose-gold transition">Luxury Rooms</h3>
                    <p class="text-gray-500 text-sm">Comfort meets tradition in our designed rooms.</p>
                </div>
                 <!-- Feature 2 -->
                 <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1596178060841-5a9d8d1H1c2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Exquisite Dining Experience" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                         <!-- Fallback image just in case -->
                         <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Exquisite Dining at Rose Villa" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 absolute inset-0">
                         <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                    <h3 class="font-serif text-xl text-rose-accent uppercase mb-2 group-hover:text-rose-gold transition">Exquisite Dining</h3>
                    <p class="text-gray-500 text-sm">Savor authentic local flavors.</p>
                </div>
                 <!-- Feature 3 -->
                 <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Serene Gardens at Rose Villa" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                         <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                    <h3 class="font-serif text-xl text-rose-accent uppercase mb-2 group-hover:text-rose-gold transition">Serene Gardens</h3>
                    <p class="text-gray-500 text-sm">Relax in our lush, private courtyards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-rose-dark text-white py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Col 1 -->
                <div>
                    <h4 class="font-serif text-lg mb-6 uppercase tracking-widest text-rose-gold">Rose Villa</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        A heritage home in Jaffna offering a unique blend of history, culture, and luxury living.
                    </p>
                </div>
                 <!-- Col 2 -->
                 <div>
                    <h4 class="font-serif text-lg mb-6 uppercase tracking-widest text-rose-gold">Navigation</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#" class="hover:text-white transition">The Villa</a></li>
                        <li><a href="#" class="hover:text-white transition">Rooms</a></li>
                        <li><a href="#" class="hover:text-white transition">Gallery</a></li>
                    </ul>
                </div>
                 <!-- Col 3 -->
                 <div>
                    <h4 class="font-serif text-lg mb-6 uppercase tracking-widest text-rose-gold">Contact</h4>
                    <address class="not-italic">
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li>123 Heritage Lane, Jaffna</li>
                            <li><a href="tel:+94771234567" class="hover:text-white transition">+94 77 123 4567</a></li>
                            <li><a href="mailto:info@rosevilla.com" class="hover:text-white transition">info@rosevilla.com</a></li>
                        </ul>
                    </address>
                </div>
                 <!-- Col 4 -->
                 <div>
                    <h4 class="font-serif text-lg mb-6 uppercase tracking-widest text-rose-gold">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i> FB</a>
                        <a href="#" class="text-gray-400 hover:text-white transition" aria-label="Instagram"><i class="fab fa-instagram"></i> IG</a>
                        <a href="#" class="text-gray-400 hover:text-white transition" aria-label="Twitter"><i class="fab fa-twitter"></i> TW</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-xs text-gray-500 uppercase tracking-widest">
                <p>&copy; {{ date('Y') }} Rose Villa Heritage Homes. All Rights Reserved.</p>
                <div class="mt-4 text-xs font-semibold text-white normal-case opacity-90">
                    Powered by Gobikrishna Subramaniyam (BEng (Hons)) | Mobile: <a href="tel:+94766383402" class="text-rose-gold hover:text-white transition">+94 76 638 3402</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LodgingBusiness",
      "name": "Rose Villa Heritage Homes",
      "image": "https://images.unsplash.com/photo-1566073771259-6a8506099945",
      "description": "Rose Villa Heritage Homes blends colonial charm with modern luxury in the heart of Jaffna. Experience authentic cultural heritage.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Heritage Lane",
        "addressLocality": "Jaffna",
        "addressRegion": "Northern Province",
        "postalCode": "40000",
        "addressCountry": "LK"
      },
      "telephone": "+94771234567",
      "priceRange": "$$",
      "url": "{{ url('/') }}"
    }
    </script>
</body>
</html>
