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
    @php
        $heroTitle = $content['hero_title'] ?? 'Rose Villa';
        $heroSubtitle = $content['hero_subtitle'] ?? 'Experience the Extraordinary in Jaffna';
        // Updated to use the live site's hero image
        $heroImage = 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/11/front-page.png'; 
    @endphp

    <!-- Header -->
    <header class="absolute top-0 left-0 w-full z-10 bg-gradient-to-b from-black/50 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block">
                        <img src="https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Screenshot-2024-08-05-174751-removebg-preview1.png" alt="Rose Villa Logo" class="h-16 w-auto hover:opacity-90 transition">
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-10">
                    <a href="#about" class="text-white hover:text-rose-gold uppercase text-sm tracking-wider font-semibold transition">About</a>
                    <a href="#rooms" class="text-white hover:text-rose-gold uppercase text-sm tracking-wider font-semibold transition">Suites</a>
                    <a href="#experiences" class="text-white hover:text-rose-gold uppercase text-sm tracking-wider font-semibold transition">Experiences</a>
                    <a href="#gallery" class="text-white hover:text-rose-gold uppercase text-sm tracking-wider font-semibold transition">Gallery</a>
                    <a href="#contact" class="text-white hover:text-rose-gold uppercase text-sm tracking-wider font-semibold transition">Contact</a>
                </nav>

                <!-- Mobile Menu Button (Hamburger) -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button type="button" class="bg-transparent p-2 text-white hover:text-gray-300">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImage }}" alt="Rose Villa Heritage Home" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-1 text-center px-4">
            <h1 class="font-serif text-5xl md:text-7xl text-white mb-6 drop-shadow-lg tracking-wide uppercase">
                {{ $heroTitle }}
            </h1>
            <p class="text-white text-lg md:text-xl font-light tracking-widest uppercase mb-8">
                {{ $heroSubtitle }}
            </p>
            <a href="#rooms" class="inline-block border-2 border-white text-white hover:bg-white hover:text-rose-accent px-8 py-3 text-sm font-semibold uppercase tracking-widest transition duration-300">
                Explore Our Heritage
            </a>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-20 md:py-32 bg-rose-primary">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-8 uppercase tracking-wide">
                Wander & Explore
            </h2>
            <div class="w-24 h-1 bg-rose-gold mx-auto mb-10"></div>
            <p class="text-lg leading-relaxed text-gray-600 mb-8 font-light">
                {{ $content['about_text'] ?? "Nestled in the heart of Jaffna, Rose Villa is more than just a place to stay—it's a journey back in time. Our heritage home blends colonial charm with modern luxury, offering a tranquil sanctuary for travelers seeking authenticity and elegance." }}
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 text-sm uppercase tracking-wider text-rose-accent">
                <div class="flex flex-col items-center">
                    <span class="text-rose-gold text-2xl mb-2">✦</span>
                    <span>Heritage Living</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-rose-gold text-2xl mb-2">✦</span>
                    <span>Authentic Cuisine</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-rose-gold text-2xl mb-2">✦</span>
                    <span>Lush Gardens</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-rose-gold text-2xl mb-2">✦</span>
                    <span>Curated Tours</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">Our Suites</h2>
                <p class="text-gray-500 font-light">Experience comfort in our historically preserved chambers</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @foreach($rooms as $room)
                    <div class="bg-white group cursor-pointer shadow-sm hover:shadow-xl transition duration-500">
                        <div class="overflow-hidden h-80 relative">
                             <img src="{{ str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image) }}" alt="{{ $room->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                             <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                        </div>
                        <div class="p-8 text-center">
                            <h3 class="font-serif text-2xl text-rose-accent uppercase mb-3">{{ $room->title }}</h3>
                            <p class="text-xs font-bold text-rose-gold tracking-widest uppercase mb-4">
                                Sleeps {{ $room->capacity }} • {{ $room->bed_type }}
                            </p>
                            <p class="text-gray-500 text-sm mb-6 leading-relaxed">{{ Str::limit($room->description, 100) }}</p>
                                <span class="text-rose-accent text-lg">LKR {{ number_format($room->price_per_night, 0) }}<span class="text-xs text-gray-400"> per day</span></span>
                            </div>
                            <div class="mt-8 text-center">
                                <a href="#reservation" onclick="document.getElementById('room_id').value='{{ $room->id }}'" class="inline-block border border-rose-accent text-rose-accent hover:bg-rose-accent hover:text-white px-6 py-2 text-xs uppercase tracking-widest transition duration-300">
                                    Book This Suite
                                </a>
                            </div>
                            <div class="mt-6 flex flex-wrap justify-center gap-2">
                                @foreach(($room->amenities ?? []) as $amenity)
                                    <span class="text-[10px] uppercase border border-gray-200 px-2 py-1 text-gray-400 tracking-wider">{{ $amenity }}</span>
                                @endforeach
                            </div>

                            <!-- Room Gallery Thumbnails -->
                            @if(!empty($room->gallery_urls))
                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-semibold">Gallery ({{ count($room->gallery_urls) }} Photos)</p>
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach($room->gallery_urls as $index => $gurl)
                                            <div class="group/thumb relative h-20 overflow-hidden rounded-lg shadow-md border-2 border-gray-100 hover:border-rose-gold transition-all duration-300 cursor-pointer"
                                                 onclick="openLightbox('{{ $room->id }}', {{ $index }})">
                                                <img src="{{ str_starts_with($gurl, 'http') ? $gurl : asset('storage/' . $gurl) }}" 
                                                     class="h-full w-full object-cover transform group-hover/thumb:scale-110 transition duration-500"
                                                     alt="Gallery image {{ $index + 1 }}">
                                                <!-- Hover Overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover/thumb:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-2">
                                                    <span class="text-white text-[10px] font-semibold uppercase tracking-wider">View</span>
                                                </div>
                                                <!-- Image Counter Badge -->
                                                <div class="absolute top-1 right-1 bg-rose-accent/90 text-white text-[9px] px-1.5 py-0.5 rounded font-semibold">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Preview Section -->
    <section id="gallery" class="py-20 bg-rose-primary">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">Glimpses of Rose Villa</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($gallery->take(8) as $image)
                    <div class="relative h-64 overflow-hidden group">
                        <img src="{{ str_starts_with($image->image_url, 'http') ? $image->image_url : asset('storage/' . $image->image_url) }}" alt="{{ $image->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-500 flex items-center justify-center">
                            <span class="text-white uppercase tracking-widest text-xs font-semibold">{{ $image->title }}</span>
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
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">Guest Stories</h2>
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
    <section id="reservation" class="py-20 bg-rose-primary/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">Reserve Your Sanctuary</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto mb-6"></div>
                <p class="text-gray-600 font-light">Tell us your plans, and we will curate your perfect stay.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-xl p-8 md:p-12 border-t-4 border-rose-gold relative">
                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Guest Details -->
                        <div class="col-span-1 md:col-span-2">
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Full Name</label>
                             <input type="text" name="guest_name" required class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50" placeholder="e.g. John Doe">
                             @error('guest_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Email Address</label>
                             <input type="email" name="email" required class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50" placeholder="john@example.com">
                             @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Phone Number</label>
                             <input type="text" name="phone" class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50" placeholder="+94 ...">
                        </div>

                        <!-- Stay Details -->
                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Check-in Date</label>
                             <input type="date" name="check_in" required class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50">
                        </div>

                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Check-out Date</label>
                             <input type="date" name="check_out" required class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50">
                        </div>

                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Preferred Suite</label>
                             <select name="room_id" id="room_id" class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50">
                                 <option value="">-- Select a Suite --</option>
                                 @foreach($rooms as $r)
                                     <option value="{{ $r->id }}">{{ $r->title }} (LKR {{ number_format($r->price_per_night) }})</option>
                                 @endforeach
                             </select>
                        </div>

                        <div>
                             <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Guests</label>
                             <select name="guests" required class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50">
                                 @foreach(range(1, 8) as $i)
                                     <option value="{{ $i }}">{{ $i }} Guest{{ $i > 1 ? 's' : '' }}</option>
                                 @endforeach
                             </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-1">Special Requests or Questions</label>
                        <textarea name="message" rows="4" class="w-full border-gray-200 focus:border-rose-gold focus:ring-rose-gold bg-gray-50" placeholder="Dietary restrictions, arrival times, etc..."></textarea>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit" class="bg-rose-accent text-white hover:bg-rose-800 transition px-12 py-4 uppercase tracking-widest text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Request Reservation
                        </button>
                        <p class="mt-4 text-xs text-gray-400">Our team will contact you shortly to confirm your booking.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="location" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl text-rose-accent mb-4 uppercase tracking-wide">Find Us</h2>
                <div class="w-16 h-0.5 bg-rose-gold mx-auto"></div>
                <p class="text-gray-500 font-light mt-4">Discover our sanctuary in the heart of Jaffna</p>
            </div>
            
            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200 h-[500px]">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7864.813254581939!2d80.015534!3d9.731581!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5498b86410df%3A0xd820147055601788!2sRose%20Villa%20Heritage%20Homes%20(pvt)%20Ltd!5e0!3m2!1sen!2slk!4v1768293510945!5m2!1sen!2slk" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Contact & Footer -->
    <footer id="contact" class="bg-rose-accent text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16 border-b border-gray-700 pb-16">
                <!-- Brand -->
                <div class="text-center md:text-left">
                    <h3 class="font-serif text-2xl text-white mb-4 uppercase tracking-widest">Rose Villa</h3>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs mx-auto md:mx-0">
                        A heritage home in Jaffna offering a unique blend of history, culture, and luxury living.
                    </p>
                </div>
                
                <!-- Contact Info -->
                <div class="text-center">
                    <h4 class="font-serif text-lg text-rose-gold mb-6 uppercase tracking-widest">Contact Us</h4>
                    <p class="text-gray-400 text-sm mb-2">{{ $content['contact_address'] ?? '123 Heritage Lane, Jaffna' }}</p>
                    <p class="text-gray-400 text-sm mb-2">{{ $content['contact_phone'] ?? '+94 77 123 4567' }}</p>
                    <p class="text-gray-400 text-sm">{{ $content['contact_email'] ?? 'info@rosevilla.com' }}</p>
                </div>

                <!-- Social/Links -->
                <div class="text-center md:text-right">
                    <h4 class="font-serif text-lg text-rose-gold mb-6 uppercase tracking-widest">Follow</h4>
                    <div class="flex justify-center md:justify-end space-x-6 text-gray-400">
                        <a href="#" class="hover:text-white transition uppercase text-xs tracking-wider">Facebook</a>
                        <a href="#" class="hover:text-white transition uppercase text-xs tracking-wider">Instagram</a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 uppercase tracking-widest">
                <p>&copy; {{ date('Y') }} Rose Villa Heritage Homes. All Rights Reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
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
