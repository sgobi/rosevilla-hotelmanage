@props(['content' => null])

@php
    $content = $content ?? \App\Models\ContentSetting::pluck('value', 'key');
    $phone = !empty($content['contact_phone']) ? $content['contact_phone'] : '+94 76 569 2476';
    $email = !empty($content['contact_email']) ? $content['contact_email'] : 'stay@rosevillaheritagehomes.com';
    $address = !empty($content['contact_address']) ? $content['contact_address'] : 'Rosevilla Heritage Homes, Jaffna, Sri Lanka';
    $siteTitle = !empty($content['site_title']) ? $content['site_title'] : 'Rose Villa Heritage Homes';
    $mapEmbed = !empty($content['map_embed']) ? $content['map_embed'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7864.813244882406!2d80.00654078217246!3d9.73158141202129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5498b86410df%3A0xd820147055601788!2sRose%20Villa%20Heritage%20Homes%20(pvt)%20Ltd!5e0!3m2!1sen!2snl!4v1769480636437!5m2!1sen!2snl';
    
    $reachAirport = !empty($content['reach_time_airport']) ? $content['reach_time_airport'] : '20-25 Mins';
    $reachRailway = !empty($content['reach_time_railway']) ? $content['reach_time_railway'] : '10-15 Mins';
    $reachBus = !empty($content['reach_time_bus']) ? $content['reach_time_bus'] : '10-15 Mins';
    $reachJaffna = !empty($content['reach_time_jaffna']) ? $content['reach_time_jaffna'] : '10-15 Mins';

    $cleanWhatsapp = preg_replace('/[^0-9]/', '', $phone);
    if (empty($cleanWhatsapp)) {
        $cleanWhatsapp = '94765692476';
    }
@endphp

<!-- 10. FIND US & MAP -->
<section id="find-us" class="py-24 px-6 lg:px-12 bg-stoneBeige/30 border-t border-stoneBeige/60">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Location & Contact</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen mb-4">Find Your Way to Rose Villa</h2>
            <p class="text-darkText/70 text-sm">Situated in the heart of the Northern Province with easy access points.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <div class="lg:col-span-7 bg-stoneBeige rounded-3xl overflow-hidden shadow-md min-h-[400px] relative border border-stoneBeige">
                <iframe title="{{ $siteTitle }} Location Map" 
                        src="{{ $mapEmbed }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy"></iframe>
            </div>

            <div class="lg:col-span-5 bg-creamBg rounded-3xl p-8 border border-stoneBeige shadow-md flex flex-col justify-between space-y-6">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-heritageGreen/10 flex items-center justify-center text-heritageGreen">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-lg text-heritageGreen">{{ $siteTitle }}</h3>
                            <p class="text-xs text-darkText/70">{{ $address }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs text-darkText/80">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-roseRed"></i>
                            <a href="tel:{{ $phone }}" class="hover:text-heritageGreen transition-colors">{{ $phone }}</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-roseRed"></i>
                            <a href="mailto:{{ $email }}" class="hover:text-heritageGreen transition-colors">{{ $email }}</a>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-heritageGreen mb-3">Travel-Time Chips</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-stoneBeige/50 rounded-2xl p-3.5 text-center">
                                <span class="block font-bold text-heritageGreen text-sm">{{ $reachAirport }}</span>
                                <span class="text-[11px] text-darkText/70">Palaly Airport</span>
                            </div>
                            <div class="bg-stoneBeige/50 rounded-2xl p-3.5 text-center">
                                <span class="block font-bold text-heritageGreen text-sm">{{ $reachRailway }}</span>
                                <span class="text-[11px] text-darkText/70">Jaffna Railway Stn</span>
                            </div>
                            <div class="bg-stoneBeige/50 rounded-2xl p-3.5 text-center">
                                <span class="block font-bold text-heritageGreen text-sm">{{ $reachBus }}</span>
                                <span class="text-[11px] text-darkText/70">Central Bus Stand</span>
                            </div>
                            <div class="bg-stoneBeige/50 rounded-2xl p-3.5 text-center">
                                <span class="block font-bold text-heritageGreen text-sm">{{ $reachJaffna }}</span>
                                <span class="text-[11px] text-darkText/70">Jaffna Town</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-stoneBeige">
                    <a href="https://wa.me/{{ $cleanWhatsapp }}" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow text-center flex items-center justify-center gap-2 text-xs">
                        <i class="fa-brands fa-whatsapp text-base"></i> Chat with Front Desk on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
