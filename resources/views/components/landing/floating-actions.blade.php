@props(['content' => null])

@php
    $content = $content ?? \App\Models\ContentSetting::pluck('value', 'key');
    $phone = !empty($content['contact_phone']) ? $content['contact_phone'] : '+94 76 569 2476';
    $cleanWhatsapp = preg_replace('/[^0-9]/', '', $phone);
    if (empty($cleanWhatsapp)) {
        $cleanWhatsapp = '94765692476';
    }
@endphp

<!-- FLOATING WHATSAPP BUTTON (DESKTOP) -->
<a href="https://wa.me/{{ $cleanWhatsapp }}" 
   target="_blank" 
   aria-label="Chat on WhatsApp" 
   class="hidden md:flex fixed bottom-6 right-6 z-40 bg-emerald-600 hover:bg-emerald-700 text-white w-14 h-14 rounded-full shadow-2xl items-center justify-center text-2xl transition-transform transform hover:scale-110">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- MOBILE STICKY BOTTOM BAR -->
<div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-creamBg/95 backdrop-blur-md border-t border-stoneBeige p-3 px-6 flex items-center justify-between shadow-2xl">
    <a href="https://wa.me/{{ $cleanWhatsapp }}" 
       target="_blank" 
       class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-xs mr-2 flex items-center justify-center gap-1.5 shadow transition-colors">
        <i class="fa-brands fa-whatsapp text-sm"></i>
        <span>WhatsApp</span>
    </a>
    <a href="#reserve" 
       class="flex-1 text-center bg-antiqueGold hover:bg-goldHover text-white font-semibold py-2.5 rounded-xl text-xs ml-2 shadow transition-colors">
        Reserve Now
    </a>
</div>
