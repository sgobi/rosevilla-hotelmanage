@props(['gallery' => null])

@php
    $galleryList = ($gallery && count($gallery) > 0) 
        ? $gallery 
        : \App\Models\GalleryImage::orderByDesc('is_featured')->latest()->get();

    // Dynamically collect unique categories from the database images
    $dbCategories = $galleryList->pluck('category')->filter()->map(function($cat) {
        return strtolower(trim($cat));
    })->unique()->values()->all();

    // Mapping standard category labels
    $categoryLabels = [
        'villa' => 'Rooms & Villa',
        'rooms' => 'Rooms & Villa',
        'garden' => 'Garden',
        'dining' => 'Dining',
    ];
@endphp

<!-- 7. GALLERY -->
<section id="gallery" class="py-24 px-6 lg:px-12 bg-stoneBeige/30 border-y border-stoneBeige/60">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Visual Tour</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">Glimpses of Rose Villa</h2>
            <p class="text-darkText/70 text-sm">Explore the architecture, tranquil gardens, and cozy interiors.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <button type="button" 
                    onclick="filterGallery('all', this)" 
                    class="gallery-filter-btn active bg-heritageGreen text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-all shadow-sm">
                All
            </button>

            @php
                $renderedCategories = [];
            @endphp

            @foreach($dbCategories as $cat)
                @php
                    $filterKey = ($cat === 'villa' || $cat === 'rooms') ? 'rooms' : $cat;
                    if (in_array($filterKey, $renderedCategories)) continue;
                    $renderedCategories[] = $filterKey;
                    $label = $categoryLabels[$cat] ?? ucfirst($cat);
                @endphp
                <button type="button" 
                        onclick="filterGallery('{{ $filterKey }}', this)" 
                        class="gallery-filter-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">
                    {{ $label }}
                </button>
            @endforeach

            {{-- Ensure standard tabs appear even if not yet in DB --}}
            @if(!in_array('rooms', $renderedCategories))
                <button type="button" onclick="filterGallery('rooms', this)" class="gallery-filter-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Rooms</button>
            @endif
            @if(!in_array('garden', $renderedCategories))
                <button type="button" onclick="filterGallery('garden', this)" class="gallery-filter-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Garden</button>
            @endif
            @if(!in_array('dining', $renderedCategories))
                <button type="button" onclick="filterGallery('dining', this)" class="gallery-filter-btn bg-stoneBeige text-darkText hover:bg-stoneBeige/80 text-xs font-semibold px-5 py-2.5 rounded-full transition-all">Dining</button>
            @endif
        </div>

        <!-- Gallery Grid -->
        <div id="gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleryList as $item)
                @php
                    $imgSrc = str_starts_with($item->image_url, 'http') 
                        ? $item->image_url 
                        : asset('storage/' . $item->image_url);
                    
                    $catSlug = strtolower(trim($item->category ?? ''));
                    $itemClasses = 'gallery-item ' . $catSlug;
                    if ($catSlug === 'villa') {
                        $itemClasses .= ' rooms';
                    } elseif ($catSlug === 'rooms') {
                        $itemClasses .= ' villa';
                    }
                @endphp
                <div class="{{ $itemClasses }} rounded-3xl overflow-hidden shadow-md bg-stoneBeige aspect-[4/3] cursor-pointer group relative" 
                     onclick="openLightbox('{{ addslashes($imgSrc) }}', '{{ addslashes($item->title) }}')">
                    <img src="{{ $imgSrc }}" 
                         alt="{{ $item->title }}" 
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    @if($item->is_featured)
                        <div class="absolute top-4 left-4 z-10 bg-amber-500/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow backdrop-blur-sm flex items-center gap-1">
                            <i class="fa-solid fa-star text-[9px]"></i> Featured
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-heritageGreen/90 via-heritageGreen/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6 text-white">
                        <span class="text-base font-serif font-bold drop-shadow-sm">{{ $item->title }}</span>
                        @if($item->description)
                            <p class="text-white/90 text-xs mt-1 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                        @endif
                        @if($item->category)
                            <div class="mt-2">
                                <span class="inline-block text-[10px] uppercase tracking-wider bg-white/20 backdrop-blur-md px-2.5 py-0.5 rounded-full font-medium">
                                    {{ $categoryLabels[$catSlug] ?? ucfirst($item->category) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-darkText/60">
                    <p>Gallery photos are being updated. Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    function filterGallery(category, btn) {
        // Toggle button states
        const buttons = document.querySelectorAll('.gallery-filter-btn');
        buttons.forEach(b => {
            b.classList.remove('bg-heritageGreen', 'text-white', 'shadow-sm');
            b.classList.add('bg-stoneBeige', 'text-darkText');
        });

        if (btn) {
            btn.classList.remove('bg-stoneBeige', 'text-darkText');
            btn.classList.add('bg-heritageGreen', 'text-white', 'shadow-sm');
        }

        // Filter gallery items
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            if (category === 'all' || item.classList.contains(category) || (category === 'rooms' && item.classList.contains('villa'))) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
