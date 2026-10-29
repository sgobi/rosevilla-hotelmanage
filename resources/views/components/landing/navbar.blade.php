<nav x-data="{ mobileOpen: false, currencyOpen: false }"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-12 py-3.5 bg-heritageGreen/90 backdrop-blur-md border-b border-white/10 text-white shadow-md"
    id="navbar">

    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <!-- DYNAMIC LOGO / BRANDING -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 group py-1">
            @php
                $logoPath = \App\Models\ContentSetting::where('key', 'logo_path')->value('value');
            @endphp

            @if($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                <div class="flex items-center transition-all duration-300">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}"
                        alt="Rose Villa Heritage Homes Jaffna Logo"
                        class="h-10 sm:h-12 w-auto object-contain transition-all duration-300 group-hover:scale-105">
                </div>
            @else
                <!-- Fallback if no logo uploaded -->
                <div
                    class="w-10 h-10 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-white shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-rose text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-serif font-bold text-lg sm:text-xl tracking-wider text-white">ROSE VILLA</span>
                    <span
                        class="text-[9px] sm:text-[10px] tracking-widest uppercase text-creamBg/80 -mt-1 font-sans font-semibold">
                        Heritage Homes · Jaffna
                    </span>
                </div>
            @endif
        </a>

        <!-- Desktop Navigation Links (Visible on XL screens) -->
        <div
            class="hidden xl:flex items-center gap-3 2xl:gap-4 font-semibold text-xs 2xl:text-sm transition-all duration-300 px-4 2xl:px-6 py-2 rounded-full shadow-lg bg-black/25 backdrop-blur-md border border-white/20 text-white">
            <a href="#about" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('The Heritage') }}
            </a>
            <a href="#our-story" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Our Story') }}
            </a>
            <a href="#rooms" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Rooms') }}
            </a>
            <a href="#amenities" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Amenities') }}
            </a>
            <a href="#culinary" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Cuisine') }}
            </a>
            <a href="#things-to-do" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Things to Do') }}
            </a>
            <a href="#events" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Garden Events') }}
            </a>
            <a href="#gallery" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Gallery') }}
            </a>
            <a href="#policies" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Policies') }}
            </a>
            <a href="#find-us" class="transition-colors text-white hover:text-antiqueGold whitespace-nowrap">
                {{ __('Find Us') }}
            </a>
        </div>

        <!-- Desktop Right Controls: Currency & CTA -->
        <div class="hidden md:flex items-center gap-3 lg:gap-4">
            @php
                $activeCurrency = \App\Helpers\CurrencyHelper::getCurrentCurrency();
                $currencyOptions = [
                    'LKR' => 'LKR (Rs.)',
                    'USD' => 'USD ($)',
                ];
            @endphp

            <!-- Currency Selector Dropdown (LKR and USD only) -->
            <div class="relative" @click.away="currencyOpen = false">
                <button type="button" @click="currencyOpen = !currencyOpen"
                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border flex items-center gap-1.5 transition-all cursor-pointer backdrop-blur-md bg-black/25 border-white/30 text-white hover:bg-black/40"
                    title="Select Currency">
                    <span>{{ $currencyOptions[$activeCurrency] ?? 'LKR (Rs.)' }}</span>
                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200"
                        :class="{ 'rotate-180': currencyOpen }"></i>
                </button>
                <div x-show="currencyOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute right-0 mt-2 w-32 bg-creamBg border border-stoneBeige rounded-xl shadow-xl py-1.5 z-50 text-darkText text-xs font-medium">
                    @foreach($currencyOptions as $cCode => $cLabel)
                        <a href="{{ route('currency.switch', $cCode) }}"
                            class="block px-3 py-1.5 hover:bg-stoneBeige/60 transition-colors {{ $activeCurrency === $cCode ? 'text-heritageGreen font-bold bg-stoneBeige/40' : '' }}">
                            {{ $cLabel }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Reserve Now Button -->
            <a href="#reserve"
                class="bg-antiqueGold hover:bg-goldHover text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">
                Reserve Now
            </a>
        </div>

        <!-- Mobile Menu Toggle Button (Visible below XL screens) -->
        <button type="button" id="menu-btn" @click="mobileOpen = !mobileOpen"
            class="xl:hidden text-2xl focus:outline-none p-2 text-white transition-colors duration-300 cursor-pointer"
            aria-label="Toggle navigation menu">
            <i class="fa-solid" :class="{ 'fa-xmark': mobileOpen, 'fa-bars': !mobileOpen }"></i>
        </button>
    </div>

    <!-- Mobile Drawer / Menu -->
    <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        @click.away="mobileOpen = false"
        class="xl:hidden absolute top-full left-0 right-0 bg-creamBg border-b border-stoneBeige shadow-2xl py-6 px-6 sm:px-8 flex flex-col gap-4 text-darkText"
        id="mobile-menu">
        <a href="#about" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('The Heritage') }}</a>
        <a href="#our-story" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Our Story') }}</a>
        <a href="#rooms" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Sanctuary Stays') }}</a>
        <a href="#amenities" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Amenities') }}</a>
        <a href="#culinary" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Flavors of Jaffna') }}</a>
        <a href="#things-to-do" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Things to Do') }}</a>
        <a href="#events" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Garden Events') }}</a>
        <a href="#gallery" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Gallery') }}</a>
        <a href="#policies" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Policies') }}</a>
        <a href="#find-us" @click="mobileOpen = false"
            class="mobile-link text-base font-medium py-1 hover:text-heritageGreen transition-colors">{{ __('Find Us') }}</a>

        <div class="pt-4 border-t border-stoneBeige flex flex-col gap-4">
            @php
                $activeCurrency = \App\Helpers\CurrencyHelper::getCurrentCurrency();
            @endphp
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-darkText/70 uppercase">Currency</span>
                <div class="flex gap-1.5">
                    @foreach(['LKR' => 'LKR (Rs.)', 'USD' => 'USD ($)'] as $cCode => $cLabel)
                        <a href="{{ route('currency.switch', $cCode) }}"
                            class="px-3 py-1 text-xs rounded-lg border font-semibold transition-colors {{ $activeCurrency === $cCode ? 'bg-heritageGreen text-white border-heritageGreen' : 'bg-stoneBeige/60 text-darkText border-stoneBeige hover:bg-stoneBeige' }}">
                            {{ $cLabel }}
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
