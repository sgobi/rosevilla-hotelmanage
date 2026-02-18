@props(['dark' => false, 'iconOnly' => false])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center group']) }}>
    @php
        $logoPath = \App\Models\ContentSetting::getValue('logo_path');
    @endphp

    @if($logoPath)
        {{-- Use uploaded logo if available --}}
        <img src="{{ asset('storage/' . $logoPath) }}" alt="Rose Villa Logo" {{ $attributes->merge(['class' => 'h-full w-auto object-contain transition-all duration-700']) }}>
    @else
        {{-- Fallback to SVG/CSS logo --}}
        <div class="relative flex flex-col items-center">
            @if($iconOnly)
                <!-- Just the icon for navigation/etc -->
                <svg viewBox="0 0 100 100" class="w-full h-full text-rose-gold fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 90C50 90 85 65 85 45C85 30 70 20 50 35C30 20 15 30 15 45C15 65 50 90 50 90Z" fill="none" stroke="currentColor" stroke-width="2"/>
                    <path d="M50 75C50 75 75 58 75 45C75 35 65 30 55 40L50 45L45 40C35 30 25 35 25 45C25 58 50 75 50 75Z" fill="none" stroke="currentColor" stroke-width="3"/>
                    <path d="M50 60C50 60 65 50 65 45C65 40 60 38 55 42L50 45L45 42C40 38 35 40 35 45C35 50 50 60 50 60Z" fill="currentColor"/>
                </svg>
            @else
                <!-- Full Layout: ROSE [Icon] VILLA -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center gap-4 sm:gap-6">
                        <span class="font-serif text-2xl sm:text-4xl {{ $dark ? 'text-gray-900' : 'text-white' }} uppercase tracking-[0.2em] leading-none">Rose</span>
                        
                        <!-- Central Rose Icon -->
                        <div class="w-12 h-12 sm:w-16 sm:h-16 text-rose-gold">
                            <svg viewBox="0 0 100 100" class="w-full h-full fill-none stroke-current" xmlns="http://www.w3.org/2000/svg">
                                <path d="M50 85C30 75 15 60 15 40C15 25 30 15 50 30C70 15 85 25 85 40C85 60 70 75 50 85Z" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M50 70C38 62 25 50 25 40C25 30 35 25 45 35L50 40L55 35C65 25 75 30 75 40C75 50 62 62 50 70Z" stroke-width="2" stroke-linecap="round"/>
                                <path d="M50 55C45 50 40 45 40 40C40 35 45 32 50 38C55 32 60 35 60 40C60 45 55 50 50 55Z" fill="currentColor" class="opacity-30" stroke-width="1"/>
                                <path d="M50 55C45 50 40 45 40 40C40 35 45 32 50 38C55 32 60 35 60 40C60 45 55 50 50 55Z" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <span class="font-serif text-2xl sm:text-4xl {{ $dark ? 'text-gray-900' : 'text-white' }} uppercase tracking-[0.2em] leading-none">Villa</span>
                    </div>
                    
                    <div class="w-full flex items-center gap-4 mt-2">
                        <div class="flex-grow h-px bg-rose-gold/30"></div>
                        <span class="text-[8px] sm:text-[10px] font-black uppercase tracking-[0.8em] {{ $dark ? 'text-gray-500' : 'text-white/60' }}">Heritage Homes</span>
                        <div class="flex-grow h-px bg-rose-gold/30"></div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
