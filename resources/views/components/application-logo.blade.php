@props(['dark' => false])
<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    @php
        $logoPath = \App\Models\ContentSetting::getValue('logo_path');
    @endphp

    @if($logoPath)
        <img src="{{ asset('storage/' . $logoPath) }}" alt="Rose Villa Logo" class="h-full w-auto">
    @else
        <p class="text-3xl font-serif tracking-widest leading-none mb-1 {{ $dark ? 'text-white' : 'text-[#8a1538]' }}">ROSE VILLA</p>
        <p class="text-[9px] font-sans font-bold tracking-[0.3em] uppercase {{ $dark ? 'text-white/60' : 'text-[#b38e5d]' }}">Heritage Home</p>
    @endif
</div>
