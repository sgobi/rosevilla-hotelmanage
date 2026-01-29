@props(['dark' => false])
<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    @php
        $logoPath = \App\Models\ContentSetting::getValue('logo_path');
    @endphp

    @if($logoPath)
        <img src="{{ asset('storage/' . $logoPath) }}" alt="Rose Villa Logo" class="h-full w-auto">
    @else
        <img src="{{ asset('images/logo.png') }}" alt="Rose Villa Logo" class="h-full w-auto pointer-events-none">
    @endif
</div>
