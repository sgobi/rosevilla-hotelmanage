@props(['dark' => false, 'iconOnly' => false, 'variant' => 'simple'])

@php
    $logoPath = \App\Models\ContentSetting::getValue('logo_path');
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center']) }}>
    @if($variant === 'full')
        <!-- Full Layout: ROSE [Icon] VILLA (Used for Invoices) -->
        <div class="flex flex-col items-center">
            <div class="flex items-center gap-4 sm:gap-6">
                <span class="font-serif text-3xl sm:text-5xl {{ $dark ? 'text-black' : 'text-white' }} font-bold uppercase tracking-tight leading-none">Rose</span>
                
                <div class="w-14 h-14 sm:w-20 sm:h-20 flex items-center justify-center">
                    @if($logoPath)
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="Rose Villa Logo" class="w-full h-full object-contain">
                    @else
                        <div class="text-rose-gold w-full h-full">
                            <svg viewBox="0 0 100 100" class="w-full h-full fill-none stroke-current" xmlns="http://www.w3.org/2000/svg">
                                <path d="M50 85C30 75 15 60 15 40C15 25 30 15 50 30C70 15 85 25 85 40C85 60 70 75 50 85Z" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M50 70C38 62 25 50 25 40C25 30 35 25 45 35L50 40L55 35C65 25 75 30 75 40C75 50 62 62 50 70Z" stroke-width="2" stroke-linecap="round"/>
                                <path d="M50 55C45 50 40 45 40 40C40 35 45 32 50 38C55 32 60 35 60 40C60 45 55 50 50 55Z" fill="currentColor" class="opacity-30" stroke-width="1"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <span class="font-serif text-3xl sm:text-5xl {{ $dark ? 'text-black' : 'text-white' }} font-bold uppercase tracking-tight leading-none">Villa</span>
            </div>
            
            <div class="w-full flex flex-col items-center mt-2">
                <span class="text-[10px] sm:text-[12px] font-black uppercase tracking-[0.5em] {{ $dark ? 'text-black' : 'text-white/80' }}">Heritage Homes</span>
            </div>
        </div>
    @else
        <!-- Simple/Old Layout (Default for entire app) -->
        <div class="flex items-center justify-center w-full h-full">
            @if($logoPath)
                <img src="{{ asset('storage/' . $logoPath) }}" alt="Rose Villa Logo" {{ $attributes->merge(['class' => 'object-contain']) }}>
            @else
                <div class="text-rose-gold h-12 w-12">
                    <svg viewBox="0 0 100 100" class="w-full h-full fill-none stroke-current" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 85C30 75 15 60 15 40C15 25 30 15 50 30C70 15 85 25 85 40C85 60 70 75 50 85Z" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M50 70C38 62 25 50 25 40C25 30 35 25 45 35L50 40L55 35C65 25 75 30 75 40C75 50 62 62 50 70Z" stroke-width="2" stroke-linecap="round"/>
                        <path d="M50 55C45 50 40 45 40 40C40 35 45 32 50 38C55 32 60 35 60 40C60 45 55 50 50 55Z" fill="currentColor" class="opacity-30" stroke-width="1"/>
                    </svg>
                </div>
            @endif
        </div>
    @endif
</div>

