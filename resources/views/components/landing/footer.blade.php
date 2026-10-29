@props(['content' => null])

@php
    $content = $content ?? \App\Models\ContentSetting::pluck('value', 'key');
    $phone = !empty($content['contact_phone']) ? $content['contact_phone'] : '+94 76 569 2476';
    $email = !empty($content['contact_email']) ? $content['contact_email'] : 'stay@rosevillaheritagehomes.com';
    $address = !empty($content['contact_address']) ? $content['contact_address'] : 'Rosevilla Heritage Homes, Jaffna, Sri Lanka';
    $footerText = !empty($content['footer_text']) ? $content['footer_text'] : 'A heritage boutique homestay in Jaffna offering courtyard evenings, timeless architecture, and warm Northern hospitality.';
    $siteTitle = !empty($content['site_title']) ? $content['site_title'] : 'ROSE VILLA';
    $logoPath = $content['logo_path'] ?? null;
    $cleanWhatsapp = preg_replace('/[^0-9]/', '', $phone);
    if (empty($cleanWhatsapp)) {
        $cleanWhatsapp = '94765692476';
    }

    $facebookUrl = config('rosevilla.social.facebook') ?: env('SOCIAL_FACEBOOK_URL', $content['social_facebook'] ?? null);
    $instagramUrl = config('rosevilla.social.instagram') ?: env('SOCIAL_INSTAGRAM_URL', $content['social_instagram'] ?? null);
    $tripadvisorUrl = config('rosevilla.social.tripadvisor') ?: env('SOCIAL_TRIPADVISOR_URL', $content['social_tripadvisor'] ?? null);

    $isRealUrl = function($url) {
        return !empty($url) && trim($url) !== '#' && filter_var($url, FILTER_VALIDATE_URL);
    };

    $hasFacebook = $isRealUrl($facebookUrl);
    $hasInstagram = $isRealUrl($instagramUrl);
    $hasTripadvisor = $isRealUrl($tripadvisorUrl);
@endphp

<!-- 11. FOOTER -->
<footer class="bg-heritageGreen text-white py-16 px-6 lg:px-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 mb-12">
        <div class="md:col-span-4 space-y-4">
            <div class="flex items-center gap-3">
                @if($logoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}" alt="{{ $siteTitle }} Footer Logo" loading="lazy" class="h-12 w-auto object-contain">
                @else
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-roseRed shadow-sm">
                        <i class="fa-solid fa-rose text-lg"></i>
                    </div>
                    <span class="font-serif font-bold text-xl tracking-wider text-white">{{ $siteTitle }}</span>
                @endif
            </div>
            <p class="text-creamBg/80 text-xs leading-relaxed max-w-sm">
                {{ $footerText }}
            </p>
            @if($hasFacebook || $hasInstagram || $hasTripadvisor)
                <div class="flex items-center gap-4 pt-2 text-lg text-creamBg">
                    @if($hasFacebook)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-antiqueGold transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    @endif
                    @if($hasInstagram)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-antiqueGold transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($hasTripadvisor)
                        <a href="{{ $tripadvisorUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-antiqueGold transition-colors" aria-label="Tripadvisor"><i class="fa-brands fa-tripadvisor"></i></a>
                    @endif
                </div>
            @endif
        </div>

        <div class="md:col-span-2 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Quick Links</h3>
            <ul class="space-y-2 text-xs text-creamBg/80">
                <li><a href="#about" class="hover:text-white transition-colors">The Heritage</a></li>
                <li><a href="#our-story" class="hover:text-white transition-colors">Our Story</a></li>
                <li><a href="#rooms" class="hover:text-white transition-colors">Rooms & Villas</a></li>
                <li><a href="#amenities" class="hover:text-white transition-colors">Amenities</a></li>
                <li><a href="#culinary" class="hover:text-white transition-colors">Flavors of Jaffna</a></li>
                <li><a href="#things-to-do" class="hover:text-white transition-colors">Things to Do</a></li>
                <li><a href="#gallery" class="hover:text-white transition-colors">Gallery</a></li>
                <li><a href="#policies" class="hover:text-white transition-colors">Guest Policies</a></li>
                <li><a href="#find-us" class="hover:text-white transition-colors">Find Us</a></li>
            </ul>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Contact</h3>
            <div class="text-xs text-creamBg/80 leading-relaxed space-y-1">
                <p>{{ $address }}</p>
                <p>Phone: <a href="tel:{{ $phone }}" class="hover:text-white transition-colors">{{ $phone }}</a></p>
                <p>WhatsApp: <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" class="hover:text-white transition-colors">+{{ $cleanWhatsapp }}</a></p>
                <p>Email: <a href="mailto:{{ $email }}" class="hover:text-white transition-colors">{{ $email }}</a></p>
            </div>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Newsletter</h3>
            <p class="text-xs text-creamBg/80">Subscribe for seasonal offers and Jaffna travel guides.</p>
            <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to updates!');" class="flex gap-2">
                <input type="email" placeholder="Your email" required class="bg-white/10 border border-white/20 rounded-xl px-3 py-2.5 text-xs text-white placeholder-creamBg/50 focus:outline-none flex-1">
                <button type="submit" class="bg-antiqueGold hover:bg-goldHover text-white px-4 py-2.5 rounded-xl text-xs font-semibold">Join</button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-creamBg/70 gap-4">
        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 text-center sm:text-left">
            <span>&copy; 2026 <strong class="text-white font-semibold">CodePortLab</strong>.</span>
            <span class="hidden sm:inline text-white/30">•</span>
            <a href="https://codeportlab.com" target="_blank" rel="noopener noreferrer" class="hover:text-antiqueGold text-white font-medium underline-offset-4 hover:underline transition-colors">CodePortLab.com</a>
            <span class="hidden sm:inline text-white/30">•</span>
            <span>Cloud &amp; DevOps B2B Consulting.</span>
        </div>
        <div class="text-center sm:text-right">
            <span>Direct / WhatsApp: <a href="https://wa.me/94766383402" target="_blank" rel="noopener noreferrer" class="hover:text-antiqueGold text-white font-semibold transition-colors">+94 76 638 3402</a></span>
        </div>
    </div>
</footer>
