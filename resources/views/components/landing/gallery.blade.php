@props(['gallery' => null])

<!-- 7. GALLERY -->
<section id="gallery" class="py-24 px-6 lg:px-12 bg-stoneBeige/30 border-y border-stoneBeige/60">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Visual Tour</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">Glimpses of Rose Villa</h2>
            <p class="text-darkText/70 text-sm">Explore the architecture, tranquil gardens, and cozy interiors.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <button type="button" onclick="filterGallery('all')" class="gallery-btn bg-heritageGreen text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-all shadow-sm">All</button>
            <button type="button" onclick="filterGallery('rooms')" class="gallery-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Rooms</button>
            <button type="button" onclick="filterGallery('garden')" class="gallery-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Garden</button>
            <button type="button" onclick="filterGallery('dining')" class="gallery-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Dining</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Heritage Room -->
            <div class="gallery-item rooms rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Heritage Room Interior')">
                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=1000" 
                     alt="Heritage Room Interior" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Heritage Room Interior</span>
                </div>
            </div>

            <!-- 2. Entrance Sign -->
            <div class="gallery-item garden rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Stone-Wall Entrance Sign')">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=1000" 
                     alt="Entrance Sign" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Stone-Wall Entrance Sign</span>
                </div>
            </div>

            <!-- 3. Private Dining -->
            <div class="gallery-item dining rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Private Dining Setup')">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=1000" 
                     alt="Private Dining" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Private Dining Setup</span>
                </div>
            </div>

            <!-- 4. Garden Sanctuary -->
            <div class="gallery-item garden rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Garden Sanctuary')">
                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=80&w=1000" 
                 alt="Garden Sanctuary" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Garden Sanctuary</span>
                </div>
            </div>

            <!-- 5. Garden Villa -->
            <div class="gallery-item rooms rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Garden Villa Bedroom')">
                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&q=80&w=1000" 
                     alt="Garden Villa" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Garden Villa Bedroom</span>
                </div>
            </div>

            <!-- 6. Sunlit Heritage Lounge -->
            <div class="gallery-item dining rooms rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                 onclick="openLightbox(this.querySelector('img').src, 'Sunlit Heritage Lounge')">
                <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&q=80&w=1000" 
                     alt="Heritage Lounge" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-heritageGreen/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <span class="text-white text-sm font-medium">Sunlit Heritage Lounge</span>
                </div>
            </div>
        </div>
    </div>
</section>
