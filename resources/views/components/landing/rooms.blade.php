@props(['rooms' => null])

<!-- 4. SANCTUARY STAYS (ROOMS) -->
<section id="rooms" class="py-24 px-6 lg:px-12 bg-stoneBeige/30 border-y border-stoneBeige/60">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Sanctuary Stays</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">Our Rooms & Villas</h2>
            <p class="text-darkText/70 text-sm">Each room is thoughtfully appointed with heirloom furnishings and modern comforts.</p>
        </div>

        <div class="space-y-16">
            <!-- Heritage Room -->
            <div class="bg-creamBg rounded-3xl p-6 sm:p-10 shadow-lg border border-stoneBeige grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <div class="relative rounded-2xl overflow-hidden shadow-inner aspect-[4/3] bg-stoneBeige">
                        <img id="heritage-main-img" 
                             src="{{ asset('images/room-heritage-1.jpg') }}" 
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=1200';" 
                             alt="Heritage Room" 
                             class="w-full h-full object-cover transition-opacity duration-300">
                        <div class="absolute top-4 left-4 bg-heritageGreen text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl shadow">
                            <span class="price-tag" data-lkr="22,000" data-usd="75">From LKR 22,000 / night</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" 
                                onclick="changeImage('heritage-main-img', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=1200')" 
                                class="rounded-xl overflow-hidden border-2 border-heritageGreen h-20 shadow-sm focus:outline-none">
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=400" alt="View 1" class="w-full h-full object-cover">
                        </button>
                        <button type="button" 
                                onclick="changeImage('heritage-main-img', 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&q=80&w=1200')" 
                                class="rounded-xl overflow-hidden border-2 border-transparent hover:border-heritageGreen h-20 shadow-sm focus:outline-none">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&q=80&w=400" alt="View 2" class="w-full h-full object-cover">
                        </button>
                    </div>
                </div>
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-block bg-roseRed/10 text-roseRed text-xs font-semibold px-3.5 py-1 rounded-full">Classic Ambiance</div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-heritageGreen">Heritage Room</h3>
                    <p class="text-darkText/80 text-sm leading-relaxed">
                        Featuring traditional carved wooden furniture, classic Persian rugs, and high timber ceilings. Designed for guests seeking historic authenticity paired with modern air-conditioned comfort.
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-2">
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-snowflake text-heritageGreen mb-1 block text-base"></i> AC & Fan</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-wifi text-heritageGreen mb-1 block text-base"></i> Free Wi-Fi</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-bed text-heritageGreen mb-1 block text-base"></i> Twin / Double</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-tree text-heritageGreen mb-1 block text-base"></i> Garden View</div>
                    </div>
                    <div class="pt-4">
                        <a href="#reserve" onclick="selectRoom('Heritage Room')" class="inline-block bg-antiqueGold hover:bg-goldHover text-white font-semibold px-7 py-3.5 rounded-xl shadow-md transition-all text-sm">
                            Reserve Heritage Room
                        </a>
                    </div>
                </div>
            </div>

            <!-- Garden Villa -->
            <div class="bg-creamBg rounded-3xl p-6 sm:p-10 shadow-lg border border-stoneBeige grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-4 lg:order-2">
                    <div class="relative rounded-2xl overflow-hidden shadow-inner aspect-[4/3] bg-stoneBeige">
                        <img id="garden-main-img" 
                             src="{{ asset('images/room-garden-1.jpg') }}" 
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=1200';" 
                             alt="Garden Villa" 
                             class="w-full h-full object-cover transition-opacity duration-300">
                        <div class="absolute top-4 left-4 bg-heritageGreen text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl shadow">
                            <span class="price-tag" data-lkr="32,000" data-usd="110">From LKR 32,000 / night</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" 
                                onclick="changeImage('garden-main-img', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=1200')" 
                                class="rounded-xl overflow-hidden border-2 border-heritageGreen h-20 shadow-sm focus:outline-none">
                            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=400" alt="View 1" class="w-full h-full object-cover">
                        </button>
                        <button type="button" 
                                onclick="changeImage('garden-main-img', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&q=80&w=1200')" 
                                class="rounded-xl overflow-hidden border-2 border-transparent hover:border-heritageGreen h-20 shadow-sm focus:outline-none">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&q=80&w=400" alt="View 2" class="w-full h-full object-cover">
                        </button>
                    </div>
                </div>
                <div class="lg:col-span-6 space-y-6 lg:order-1">
                    <div class="inline-block bg-roseRed/10 text-roseRed text-xs font-semibold px-3.5 py-1 rounded-full">Private Retreat</div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-heritageGreen">Garden Villa</h3>
                    <p class="text-darkText/80 text-sm leading-relaxed">
                        Step directly into the lush greenery from your spacious villa. Features open wooden windows facing the manicured lawn, stone pillar architecture, and an exclusive seating gazebo right outside.
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-2">
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-snowflake text-heritageGreen mb-1 block text-base"></i> AC & Fan</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-wifi text-heritageGreen mb-1 block text-base"></i> Free Wi-Fi</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-bed text-heritageGreen mb-1 block text-base"></i> King Bed</div>
                        <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText"><i class="fa-solid fa-door-open text-heritageGreen mb-1 block text-base"></i> Private Gazebo</div>
                    </div>
                    <div class="pt-4">
                        <a href="#reserve" onclick="selectRoom('Garden Villa')" class="inline-block bg-antiqueGold hover:bg-goldHover text-white font-semibold px-7 py-3.5 rounded-xl shadow-md transition-all text-sm">
                            Reserve Garden Villa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
