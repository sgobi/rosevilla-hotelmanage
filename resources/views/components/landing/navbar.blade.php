<nav x-data="{
        scrolled: false,
        mobileOpen: false,
        langOpen: false,
        currencyOpen: false
     }" x-init="scrolled = (window.pageYOffset > 20)" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="{
        'bg-creamBg/95 backdrop-blur-md shadow-md py-3 border-b border-stoneBeige text-darkText': scrolled,
        'bg-heritageGreen/75 backdrop-blur-md py-4 border-b border-white/10 text-white': !scrolled
     }" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 lg:px-12" id="navbar">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <!-- DYNAMIC LOGO / BRANDING -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 group py-1">
            @php
                $logoPath = \App\Models\ContentSetting::where('key', 'logo_path')->value('value');
            @endphp

            @if($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                <div class="flex items-center transition-all duration-300">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}" alt="Rose Villa Heritage Homes"
                        class="h-10 sm:h-12 w-auto object-contain transition-all duration-300 group-hover:scale-105">
                </div>
            @else
                <!-- Fallback if no logo uploaded -->
                <div
                    class="w-10 h-10 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-white shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-rose text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-serif font-bold text-xl tracking-wider text-white">ROSE VILLA</span>
                    <span class="text-[10px] tracking-widest uppercase text-creamBg/80 -mt-1 font-sans font-semibold">
                        Heritage Homes · Jaffna
                    </span>
                </div>
            @endif
        </a>

        <!-- Desktop Navigation Links inside a High-Contrast Pill Container -->
        <div class="hidden xl:flex items-center gap-6 font-semibold text-sm transition-all duration-300 px-6 py-2 rounded-full shadow-lg"
            :class="{
                'bg-transparent border-transparent shadow-none': scrolled,
                'bg-black/35 backdrop-blur-md border border-white/20 text-white': !scrolled
             }">
            <a href="#about" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                The Heritage
            </a>
            <a href="#rooms" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                Sanctuary Stays
            </a>
            <a href="#culinary" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                Flavors of Jaffna
            </a>
            <a href="#gallery" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                Gallery
            </a>
            <a href="#events" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                Garden Events
            </a>
            <a href="#find-us" class="transition-colors hover:text-antiqueGold"
                :class="{ 'text-darkText hover:text-heritageGreen': scrolled, 'text-white': !scrolled }">
                Find Us
            </a>
        </div>

        <!-- Desktop Right Controls: Currency, Language & CTA -->
        <div class="hidden md:flex items-center gap-4">

            <!-- Currency Switcher Dropdown -->
            <div class="relative" @click.away="currencyOpen = false">
                <button type="button" @click="currencyOpen = !currencyOpen"
                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border flex items-center gap-1.5 transition-all cursor-pointer backdrop-blur-md"
                    :class="{
                        'bg-stoneBeige/60 border-stoneBeige text-darkText hover:bg-stoneBeige': scrolled,
                        'bg-black/35 border-white/30 text-white hover:bg-black/50': !scrolled
                    }">
                    <span>{{ session('currency', 'LKR') }}</span>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200"
                        :class="{ 'rotate-180': currencyOpen }"></i>
                </button>
                <div x-show="currencyOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute right-0 mt-2 w-32 bg-creamBg border border-stoneBeige rounded-xl shadow-xl py-1.5 z-50 text-darkText text-xs font-medium">
                    @foreach(['LKR' => 'LKR (Rs.)', 'USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'CAD' => 'CAD (C$)', 'INR' => 'INR (₹)'] as $currCode => $currLabel)
                        <a href="{{ route('currency.switch', $currCode) }}"
                            class="block px-3 py-1.5 hover:bg-stoneBeige/60 transition-colors {{ session('currency', 'LKR') === $currCode ? 'text-heritageGreen font-bold' : '' }}">
                            {{ $currLabel }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Language Switcher Dropdown -->
            <div class="relative" @click.away="langOpen = false">
                <button type="button" @click="langOpen = !langOpen"
                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border flex items-center gap-1.5 transition-all cursor-pointer backdrop-blur-md"
                    :class="{
                        'bg-stoneBeige/60 border-stoneBeige text-darkText hover:bg-stoneBeige': scrolled,
                        'bg-black/35 border-white/30 text-white hover:bg-black/50': !scrolled
                    }">
                    <span>{{ strtoupper(app()->getLocale() ?? 'EN') }}</span>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200"
                        :class="{ 'rotate-180': langOpen }"></i>
                </button>
                <div x-show="langOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute right-0 mt-2 w-36 bg-creamBg border border-stoneBeige rounded-xl shadow-xl py-1.5 z-50 text-darkText text-xs font-medium">
                    @foreach(['en' => 'English (EN)', 'ta' => 'தமிழ் (TA)', 'si' => 'සිංහල (SI)', 'fr' => 'Français (FR)', 'hi' => 'हिन्दी (HI)'] as $langCode => $langLabel)
                        <a href="{{ route('lang.switch', $langCode) }}"
                            class="block px-3 py-1.5 hover:bg-stoneBeige/60 transition-colors {{ app()->getLocale() === $langCode ? 'text-heritageGreen font-bold' : '' }}">
                            {{ $langLabel }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Reserve Now Button -->
            <a href="#reserve"
                class="bg-antiqueGold hover:bg-goldHover text-white text-xs font-semibold px-5 py-2.5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">
                Reserve Now
            </a>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <button type="button" id="menu-btn" @click="mobileOpen = !mobileOpen"
            class="xl:hidden text-2xl focus:outline-none p-2 transition-colors duration-300"
            :class="{ 'text-darkText': scrolled, 'text-white': !scrolled }" aria-label="Toggle navigation menu">
            <i class="fa-solid" :class="{ 'fa-xmark': mobileOpen, 'fa-bars': !mobileOpen }"></i>
        </button>
    </div>

    <!-- Mobile Drawer / Menu -->
    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="xl:hidden absolute top-full left-0 right-0 bg-creamBg border-b border-stoneBeige shadow-2xl py-6 px-8 flex flex-col gap-4 text-darkText"
        id="mobile-menu">
        <a href="#about" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">The Heritage</a>
        <a href="#rooms" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">Sanctuary
            Stays</a>
        <a href="#culinary" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">Flavors of
            Jaffna</a>
        <a href="#gallery" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">Gallery</a>
        <a href="#events" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">Garden Events</a>
        <a href="#find-us" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">Find Us</a>

        <div class="pt-4 border-t border-stoneBeige flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-darkText/70 uppercase">Currency</span>
                <div class="flex flex-wrap gap-1">
                    @foreach(['LKR', 'USD', 'EUR', 'CAD', 'INR'] as $c)
                        <a href="{{ route('currency.switch', $c) }}"
                            class="px-2.5 py-1 text-xs rounded-lg border {{ session('currency', 'LKR') === $c ? 'bg-heritageGreen text-white border-heritageGreen' : 'bg-stoneBeige/60 text-darkText border-stoneBeige' }}">
                            {{ $c }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-darkText/70 uppercase">Language</span>
                <div class="flex flex-wrap gap-1">
                    @foreach(['en' => 'EN', 'fr' => 'FR', 'hi' => 'HI', 'si' => 'SI', 'ta' => 'TA'] as $lCode => $lText)
                        <a href="{{ route('lang.switch', $lCode) }}"
                            class="px-2.5 py-1 text-xs rounded-lg border {{ app()->getLocale() === $lCode ? 'bg-heritageGreen text-white border-heritageGreen' : 'bg-stoneBeige/60 text-darkText border-stoneBeige' }}">
                            {{ $lText }}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="#reserve" @click="mobileOpen = false"
                class="text-center bg-antiqueGold hover:bg-goldHover text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-md transition-all">
                Reserve Now
            </a>
        </div>
    </div>
</nav>