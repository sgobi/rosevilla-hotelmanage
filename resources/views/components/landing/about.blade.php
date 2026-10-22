@props([
    'content' => [],
    'eyebrow' => 'A Living Sanctuary',
    'heading' => 'Rooted in Jaffna’s history, designed for serene modern comfort.',
    'body' => null,
    'galleryLinkText' => 'Explore our photo gallery',
    'galleryLink' => '#gallery',
    'cards' => null,
])

@php
    // Use real database CMS content for about text if available
    $aboutBody = $body 
        ?? ($content['about_text'] ?? null) 
        ?? 'Rose Villa invites you to experience genuine Northern Sri Lankan warmth. Framed by ancient stone masonry, towering coconut palms, and breezy interior colonnades, our boutique property bridges historic architectural grace with mindful luxury.';

    // Default feature cards matching index.html approved UI design
    $featureCards = $cards ?? [
        [
            'icon' => 'fa-solid fa-landmark',
            'title' => 'Architecture',
            'description' => 'Timeless timber ceilings, carved woodwork, and traditional stone walls.'
        ],
        [
            'icon' => 'fa-solid fa-seedling',
            'title' => 'Private Garden',
            'description' => 'Lush manicured lawns, shady gazebos, and tranquil tropical foliage.'
        ],
        [
            'icon' => 'fa-solid fa-utensils',
            'title' => 'Home Meals',
            'description' => 'Authentic Jaffna culinary traditions prepared with freshly sourced local spices.'
        ]
    ];
@endphp

<!-- 3. THE HERITAGE & COURTYARD STORY -->
<section id="about" class="py-24 px-6 lg:px-12 max-w-7xl mx-auto scroll-mt-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Story / Narrative Column -->
        <div class="lg:col-span-5 space-y-6">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block">
                {{ $eyebrow }}
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-heritageGreen leading-tight">
                {{ $heading }}
            </h2>
            <p class="text-darkText/80 leading-relaxed text-sm sm:text-base">
                {{ $aboutBody }}
            </p>
            <div class="pt-2">
                <a href="{{ $galleryLink }}" 
                   class="inline-flex items-center gap-2 font-semibold text-heritageGreen hover:text-roseRed focus:ring-2 focus:ring-heritageGreen/30 focus:outline-none rounded-lg p-1 transition-colors">
                    <span>{{ $galleryLinkText }}</span>
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <!-- 3 Feature Cards Column -->
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($featureCards as $card)
                <div class="bg-stoneBeige/50 rounded-3xl p-6 text-center shadow-sm border border-stoneBeige/80 hover:-translate-y-1 transition-transform duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-heritageGreen/10 text-heritageGreen rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl shadow-inner">
                            <i class="{{ $card['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-heritageGreen mb-2">
                            {{ $card['title'] }}
                        </h3>
                        <p class="text-xs text-darkText/70 leading-relaxed">
                            {{ $card['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
