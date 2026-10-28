@props(['rooms' => null])

@php
    $roomList = ($rooms && count($rooms) > 0) ? $rooms : \App\Models\Room::where('is_active', true)->orderBy('price_per_night')->get();
@endphp

<!-- 4. SANCTUARY STAYS (ROOMS) -->
<section id="rooms" class="py-24 px-6 lg:px-12 bg-stoneBeige/30 border-y border-stoneBeige/60">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Sanctuary Stays</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">Our Rooms & Villas</h2>
            <p class="text-darkText/70 text-sm">Each room is thoughtfully appointed with heirloom furnishings and modern comforts.</p>
        </div>

        <div class="space-y-16">
            @forelse($roomList as $index => $room)
                @php
                    $isOdd = $index % 2 === 1;
                    $featuredSrc = $room->featured_image 
                        ? (str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image)) 
                        : ($index === 0 ? asset('images/room-heritage-1.jpg') : asset('images/room-garden-1.jpg'));
                    
                    $rawGallery = is_array($room->gallery_urls) ? array_filter($room->gallery_urls) : [];
                    
                    // Compile all photos: featured photo first, followed by all gallery items
                    $allPhotos = [];
                    if (!empty($featuredSrc)) {
                        $allPhotos[] = $featuredSrc;
                    }
                    foreach ($rawGallery as $url) {
                        $src = str_starts_with($url, 'http') ? $url : asset('storage/' . $url);
                        if (!in_array($src, $allPhotos)) {
                            $allPhotos[] = $src;
                        }
                    }

                    $mainImg = $allPhotos[0] ?? $featuredSrc;
                    $lkrPrice = number_format($room->price_per_night, 0);
                    $usdPrice = round($room->price_per_night / 300);
                    $imgElementId = 'room-main-img-' . $room->id;
                @endphp

                <div x-data="{ 
                        activeImg: '{{ $mainImg }}',
                        isFading: false,
                        activeIdx: 0,
                        photos: {{ json_encode($allPhotos) }},
                        selectPhoto(src, idx) {
                            if (this.activeImg === src) return;
                            this.isFading = true;
                            this.activeIdx = idx;
                            setTimeout(() => {
                                this.activeImg = src;
                                this.isFading = false;
                            }, 120);
                        },
                        prevPhoto() {
                            if (this.photos.length <= 1) return;
                            let newIdx = (this.activeIdx - 1 + this.photos.length) % this.photos.length;
                            this.selectPhoto(this.photos[newIdx], newIdx);
                        },
                        nextPhoto() {
                            if (this.photos.length <= 1) return;
                            let newIdx = (this.activeIdx + 1) % this.photos.length;
                            this.selectPhoto(this.photos[newIdx], newIdx);
                        }
                     }"
                     class="bg-creamBg rounded-3xl p-6 sm:p-10 shadow-lg border border-stoneBeige grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Image Column -->
                    <div class="lg:col-span-6 space-y-4 {{ $isOdd ? 'lg:order-2' : '' }}">
                        <div class="relative rounded-2xl overflow-hidden shadow-inner aspect-[4/3] bg-stoneBeige group cursor-pointer"
                             @click="typeof openLightbox === 'function' ? openLightbox(activeImg, '{{ addslashes($room->title) }}') : null"
                             title="Click to view fullscreen">
                            <img id="{{ $imgElementId }}" 
                                 :src="activeImg" 
                                 src="{{ $mainImg }}" 
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=1200';" 
                                 alt="{{ $room->title }}" 
                                 :class="isFading ? 'opacity-30 scale-[0.99]' : 'opacity-100 scale-100'"
                                 class="w-full h-full object-cover transition-all duration-200">
                            
                            <div class="absolute top-4 left-4 bg-heritageGreen text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl shadow pointer-events-none z-10">
                                <span class="price-tag" data-lkr="{{ $lkrPrice }}" data-usd="{{ $usdPrice }}">From LKR {{ $lkrPrice }} / night</span>
                            </div>

                            <!-- Photo Counter Badge (if multiple photos) -->
                            <template x-if="photos.length > 1">
                                <div class="absolute top-4 right-4 bg-black/60 text-white text-[11px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm shadow z-10 flex items-center gap-1.5 pointer-events-none">
                                    <i class="fa-solid fa-camera text-[10px]"></i>
                                    <span x-text="(activeIdx + 1) + ' / ' + photos.length"></span>
                                </div>
                            </template>

                            <!-- Navigation arrows on hover (if multiple photos) -->
                            <template x-if="photos.length > 1">
                                <div class="absolute inset-x-0 inset-y-0 flex items-center justify-between px-3 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" 
                                            @click.stop="prevPhoto()" 
                                            class="pointer-events-auto h-9 w-9 rounded-full bg-black/60 hover:bg-heritageGreen text-white flex items-center justify-center backdrop-blur-sm shadow transition-all hover:scale-110 focus:outline-none"
                                            title="Previous photo">
                                        <i class="fa-solid fa-chevron-left text-xs"></i>
                                    </button>
                                    <button type="button" 
                                            @click.stop="nextPhoto()" 
                                            class="pointer-events-auto h-9 w-9 rounded-full bg-black/60 hover:bg-heritageGreen text-white flex items-center justify-center backdrop-blur-sm shadow transition-all hover:scale-110 focus:outline-none"
                                            title="Next photo">
                                        <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </template>

                            <!-- Fullscreen hint on bottom right -->
                            <div class="absolute bottom-3 right-3 bg-black/60 text-white text-[11px] font-medium px-2.5 py-1 rounded-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1.5 shadow pointer-events-none z-10">
                                <i class="fa-solid fa-expand text-[10px]"></i>
                                <span>Fullscreen</span>
                            </div>
                        </div>

                        <!-- Gallery Thumbnails (looping through ALL photos) -->
                        @if(count($allPhotos) > 1)
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-[11px] text-darkText/60 px-1 font-medium">
                                    <span>Gallery Photos ({{ count($allPhotos) }})</span>
                                    <span class="text-[10px] text-heritageGreen font-semibold">Click to preview</span>
                                </div>
                                <div class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-1 px-1 scrollbar-thin scrollbar-thumb-stoneBeige">
                                    @foreach($allPhotos as $pIdx => $pSrc)
                                        <button type="button" 
                                                @click="selectPhoto('{{ $pSrc }}', {{ $pIdx }})" 
                                                :class="activeIdx === {{ $pIdx }} 
                                                    ? 'border-heritageGreen ring-2 ring-heritageGreen/40 shadow-md scale-105 opacity-100' 
                                                    : 'border-transparent opacity-70 hover:opacity-100 hover:border-stoneBeige hover:scale-102'"
                                                class="relative flex-shrink-0 w-16 h-14 sm:w-20 sm:h-16 rounded-xl overflow-hidden border-2 shadow-sm focus:outline-none transition-all duration-200 group bg-stoneBeige"
                                                title="View photo {{ $pIdx + 1 }}">
                                            <img src="{{ $pSrc }}" 
                                                 alt="{{ $room->title }} Thumbnail {{ $pIdx + 1 }}" 
                                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=200';"
                                                 class="w-full h-full object-cover">
                                            <div x-show="activeIdx === {{ $pIdx }}" 
                                                 class="absolute inset-0 bg-heritageGreen/15 pointer-events-none"></div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Details Column -->
                    <div class="lg:col-span-6 space-y-6 {{ $isOdd ? 'lg:order-1' : '' }}">
                        @if($room->subtitle)
                            <div class="inline-block bg-roseRed/10 text-roseRed text-xs font-semibold px-3.5 py-1 rounded-full">
                                {{ $room->subtitle }}
                            </div>
                        @else
                            <div class="inline-block bg-roseRed/10 text-roseRed text-xs font-semibold px-3.5 py-1 rounded-full">
                                Classic Ambiance
                            </div>
                        @endif

                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-heritageGreen">{{ $room->title }}</h3>

                        <p class="text-darkText/80 text-sm leading-relaxed">
                            {{ $room->description ?: 'Designed for guests seeking historic authenticity paired with modern comfort in the heart of Jaffna.' }}
                        </p>

                        <!-- Highlights & Amenities -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-2">
                            @if($room->capacity)
                                <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText">
                                    <i class="fa-solid fa-users text-heritageGreen mb-1 block text-base"></i> 
                                    Up to {{ $room->capacity }} Guests
                                </div>
                            @endif

                            @if($room->bed_type)
                                <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText">
                                    <i class="fa-solid fa-bed text-heritageGreen mb-1 block text-base"></i> 
                                    {{ $room->bed_type }}
                                </div>
                            @endif

                            @if(!empty($room->amenities) && is_array($room->amenities))
                                @php
                                    $amenityIcons = [
                                        'wifi' => 'fa-wifi',
                                        'ac' => 'fa-snowflake',
                                        'air' => 'fa-snowflake',
                                        'shower' => 'fa-shower',
                                        'bath' => 'fa-bath',
                                        'verandah' => 'fa-tree',
                                        'garden' => 'fa-tree',
                                        'view' => 'fa-tree',
                                        'breakfast' => 'fa-utensils',
                                        'tea' => 'fa-mug-hot',
                                        'coffee' => 'fa-mug-hot',
                                        'tv' => 'fa-tv',
                                    ];
                                @endphp
                                @foreach(array_slice($room->amenities, 0, $room->bed_type ? 2 : 3) as $amenity)
                                    @php
                                        $icon = 'fa-check';
                                        $lower = strtolower($amenity);
                                        foreach($amenityIcons as $key => $ic) {
                                            if (str_contains($lower, $key)) {
                                                $icon = $ic;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText truncate" title="{{ $amenity }}">
                                        <i class="fa-solid {{ $icon }} text-heritageGreen mb-1 block text-base"></i> 
                                        {{ $amenity }}
                                    </div>
                                @endforeach
                            @else
                                <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText">
                                    <i class="fa-solid fa-snowflake text-heritageGreen mb-1 block text-base"></i> AC & Fan
                                </div>
                                <div class="bg-stoneBeige/50 rounded-2xl p-3 text-center text-xs font-medium text-darkText">
                                    <i class="fa-solid fa-wifi text-heritageGreen mb-1 block text-base"></i> Free Wi-Fi
                                </div>
                            @endif
                        </div>

                        <div class="pt-4">
                            <a href="#reserve" 
                               onclick="selectRoom('{{ addslashes($room->title) }}')" 
                               class="inline-block bg-antiqueGold hover:bg-goldHover text-white font-semibold px-7 py-3.5 rounded-xl shadow-md transition-all text-sm">
                                Reserve {{ $room->title }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-darkText/60">
                    <p>Rooms are being prepared. Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
