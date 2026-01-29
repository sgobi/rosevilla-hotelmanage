<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rose Villa Heritage Homes</title>

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
                <nav class="hidden md:flex space-x-8 items-center">
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
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-transparent p-2 text-white hover:text-gray-300">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="mobileMenuOpen = false"
             class="md:hidden bg-rose-primary border-t border-rose-800">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-white hover:text-rose-accent uppercase text-sm tracking-wider font-semibold">Home</a>
                <a href="#about" class="block px-3 py-2 text-white hover:text-rose-accent uppercase text-sm tracking-wider font-semibold">The Villa</a>
                <a href="#rooms" class="block px-3 py-2 text-white hover:text-rose-accent uppercase text-sm tracking-wider font-semibold">Rooms</a>
                <a href="#experiences" class="block px-3 py-2 text-white hover:text-rose-accent uppercase text-sm tracking-wider font-semibold">Experiences</a>
                <a href="#contact" class="block px-3 py-2 text-white hover:text-rose-accent uppercase text-sm tracking-wider font-semibold">Contact</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div id="home" class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Rose Villa Heritage Home" class="w-full h-full object-cover">
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
                        <input type="date" class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-xs uppercase tracking-wider mb-1">Check Out</label>
                        <input type="date" class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-white text-xs uppercase tracking-wider mb-1">Guests</label>
                        <select class="w-full bg-white/80 border-0 text-gray-800 text-sm focus:ring-0 rounded-sm">
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
                Wander & Explore
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Suites" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                         <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                    <h3 class="font-serif text-xl text-rose-accent uppercase mb-2 group-hover:text-rose-gold transition">Luxury Rooms</h3>
                    <p class="text-gray-500 text-sm">Comfort meets tradition in our designed rooms.</p>
                </div>
                 <!-- Feature 2 -->
                 <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1596178060841-5a9d8d1H1c2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dining" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                         <!-- Note: Image URL might need fixing, using a valid placeholder -->
                         <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dining" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 absolute inset-0">
                         <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                    <h3 class="font-serif text-xl text-rose-accent uppercase mb-2 group-hover:text-rose-gold transition">Exquisite Dining</h3>
                    <p class="text-gray-500 text-sm">Savor authentic local flavors.</p>
                </div>
                 <!-- Feature 3 -->
                 <div class="text-center group cursor-pointer">
                    <div class="overflow-hidden mb-6 h-64 relative">
                         <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Gardens" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
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
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li>123 Heritage Lane, Jaffna</li>
                        <li>+94 77 123 4567</li>
                        <li>info@rosevilla.com</li>
                    </ul>
                </div>
                 <!-- Col 4 -->
                 <div>
                    <h4 class="font-serif text-lg mb-6 uppercase tracking-widest text-rose-gold">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i> FB</a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i> IG</a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i> TW</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-xs text-gray-500 uppercase tracking-widest">
                &copy; {{ date('Y') }} Rose Villa Heritage Homes. All Rights Reserved.
            </div>
        </div>
    </footer>
</body>
</html>
