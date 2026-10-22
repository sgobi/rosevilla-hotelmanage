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
                    $mainImg = $room->featured_image 
                        ? (str_starts_with($room->featured_image, 'http') ? $room->featured_image : asset('storage/' . $room->featured_image)) 
                        : ($index === 0 ? asset('images/room-heritage-1.jpg') : asset('images/room-garden-1.jpg'));
                    $gallery = is_array($room->gallery_urls) ? $room->gallery_urls : [];
                    $lkrPrice = number_format($room->price_per_night, 0);
                    $usdPrice = round($room->price_per_night / 300);
                    $imgElementId = 'room-main-img-' . $room->id;
                @endphp

                <div class="bg-creamBg rounded-3xl p-6 sm:p-10 shadow-lg border border-stoneBeige grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <!-- Image Column -->
                    <div class="lg:col-span-6 space-y-4 {{ $isOdd ? 'lg:order-2' : '' }}">
                        <div class="relative rounded-2xl overflow-hidden shadow-inner aspect-[4/3] bg-stoneBeige">
                            <img id="{{ $imgElementId }}" 
                                 src="{{ $mainImg }}" 
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=1200';" 
                                 alt="{{ $room->title }}" 
                                 class="w-full h-full object-cover transition-opacity duration-300">
                            <div class="absolute top-4 left-4 bg-heritageGreen text-white text-xs font-semibold px-3.5 py-1.5 rounded-xl shadow">
                                <span class="price-tag" data-lkr="{{ $lkrPrice }}" data-usd="{{ $usdPrice }}">From LKR {{ $lkrPrice }} / night</span>
                            </div>
                        </div>

                        <!-- Gallery Thumbnails -->
                        @if(!empty($gallery))
                            <div class="grid grid-cols-3 gap-3">
                                <button type="button" 
                                        onclick="changeImage('{{ $imgElementId }}', '{{ $mainImg }}')" 
                                        class="rounded-xl overflow-hidden border-2 border-heritageGreen h-16 shadow-sm focus:outline-none transition-all hover:scale-105">
                                    <img src="{{ $mainImg }}" alt="{{ $room->title }} Featured" class="w-full h-full object-cover">
                                </button>
                                @foreach(array_slice($gallery, 0, 2) as $thumb)
                                    @php
                                        $thumbSrc = str_starts_with($thumb, 'http') ? $thumb : asset('storage/' . $thumb);
                                    @endphp
                                    <button type="button" 
                                            onclick="changeImage('{{ $imgElementId }}', '{{ $thumbSrc }}')" 
                                            class="rounded-xl overflow-hidden border-2 border-transparent hover:border-heritageGreen h-16 shadow-sm focus:outline-none transition-all hover:scale-105">
                                        <img src="{{ $thumbSrc }}" alt="{{ $room->title }} View" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
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
