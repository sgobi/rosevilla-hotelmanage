<footer class="bg-[#0f0f0f] text-white pt-24 pb-12 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('{{ asset('images/pattern.png') }}'); background-size: 400px;"></div>
    
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-rose-gold/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-rose-primary/5 rounded-full blur-[80px] translate-y-1/3 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
            <!-- Brand Column -->
            <div class="space-y-8 flex flex-col items-center md:items-start text-center md:text-left">
                <a href="{{ route('home') }}" class="inline-block transform hover:scale-105 transition-transform duration-500">
                    <x-application-logo class="w-40 h-auto" />
                </a>
                <p class="text-gray-400 text-sm leading-relaxed font-light italic">
                    "A sanctuary of heritage and luxury in the heart of Jaffna. Experience the timeless charm of our colonial home."
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white hover:border-rose-gold transition-all duration-500" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white hover:border-rose-gold transition-all duration-500" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.225-.149-4.771-1.664-4.919-4.919-.059-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-rose-gold hover:bg-rose-gold hover:text-white hover:border-rose-gold transition-all duration-500" aria-label="TripAdvisor" title="TripAdvisor">
                         <span class="text-[10px] font-black uppercase tracking-tighter">TA</span>
                    </a>
                </div>
            </div>

            <!-- Explore Column -->
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="font-serif text-lg text-rose-gold mb-10 uppercase tracking-[0.2em] relative inline-block">
                    Explore
                    <span class="absolute -bottom-2 left-0 w-8 h-px bg-rose-gold/50"></span>
                </h4>
                <ul class="space-y-4 text-sm">
                    @php
                        $links = [
                            ['label' => 'About Us', 'link' => '#about'],
                            ['label' => 'Our Rooms', 'link' => '#rooms'],
                            ['label' => 'Experiences', 'link' => '#experiences'],
                            ['label' => 'Gallery', 'link' => '#gallery'],
                            ['label' => 'FAQ', 'link' => route('faq')],
                        ];
                    @endphp
                    @foreach($links as $link)
                        <li>
                            <a href="{{ $link['link'] }}" class="text-gray-400 hover:text-rose-gold transition-colors duration-300">
                                {{ __($link['label']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="flex flex-col items-center md:items-start text-center md::text-left">
                <h4 class="font-serif text-lg text-rose-gold mb-10 uppercase tracking-[0.2em] relative inline-block">
                    Concierge
                    <span class="absolute -bottom-2 left-0 w-8 h-px bg-rose-gold/50"></span>
                </h4>
                <ul class="space-y-6 text-sm">
                    <li class="flex flex-col md:flex-row items-center md:items-start gap-4 group">
                        <div class="text-rose-gold shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-gray-400 group-hover:text-white transition-colors duration-300">
                            Rosevilla Heritage Homes, Jaffna, Sri Lanka
                        </span>
                    </li>
                    <li class="flex flex-col md:flex-row items-center md:items-start gap-4 group">
                        <div class="text-rose-gold shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <a href="tel:+94763193311" class="text-gray-400 group-hover:text-white transition-colors">+94 76 319 3311</a>
                            <a href="tel:+4791538193" class="text-gray-400 group-hover:text-white transition-colors">+47 915 38 193</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Currency Column -->
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="font-serif text-lg text-rose-gold mb-10 uppercase tracking-[0.2em] relative inline-block">
                    Finance
                    <span class="absolute -bottom-2 left-0 w-8 h-px bg-rose-gold/50"></span>
                </h4>
                <div class="w-full">
                    <p class="text-[10px] text-gray-500 uppercase tracking-[0.3em] font-black mb-6">Select Currency</p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        @foreach(['LKR', 'USD', 'EUR', 'CAD', 'INR'] as $code)
                            <a href="{{ route('currency.switch', $code) }}" class="group/curr relative px-4 py-2 border border-white/5 rounded-xl text-[11px] font-bold tracking-widest transition-all duration-500 hover:border-rose-gold/50 {{ session('currency', 'LKR') == $code ? 'bg-rose-gold text-white border-rose-gold shadow-lg shadow-rose-gold/20' : 'text-gray-500 hover:text-white' }}">
                                {{ $code }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex flex-col items-center md:items-start gap-4">
                <p class="text-[10px] text-gray-500 uppercase tracking-[0.4em] font-medium">
                    &copy; {{ date('Y') }} Rose Villa Heritage Homes. All Rights Reserved.
                </p>
                <div class="flex gap-8">
                    <a href="#" class="text-[9px] text-gray-600 hover:text-rose-gold transition-colors uppercase tracking-[0.2em] font-black">Privacy Policy</a>
                    <a href="#" class="text-[9px] text-gray-600 hover:text-rose-gold transition-colors uppercase tracking-[0.2em] font-black">Terms & Conditions</a>
                    <a href="#" class="text-[9px] text-gray-600 hover:text-rose-gold transition-colors uppercase tracking-[0.2em] font-black">Sitemap</a>
                </div>
            </div>

            <!-- Enhanced Attribution -->
            <div class="relative group">
                <div class="absolute -inset-4 bg-rose-gold/10 rounded-2xl blur-xl opacity-20 group-hover:opacity-100 transition-opacity duration-700"></div>
                <div class="relative flex flex-col items-center md:items-end gap-2 pr-0 md:pr-4">
                    <p class="text-[9px] text-rose-gold/60 uppercase tracking-[0.5em] font-black group-hover:text-rose-gold transition-colors duration-500">Architected & Engineered By</p>
                    <div class="flex flex-col items-center md:items-end">
                        <p class="text-base font-serif text-white group-hover:text-rose-gold transition-all duration-500 tracking-[0.05em] scale-100 group-hover:scale-110 origin-right drop-shadow-[0_0_10px_rgba(255,255,255,0.1)] group-hover:drop-shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                            Gobikrishna Subramaniyam
                        </p>
                        <p class="text-[10px] text-gray-400 font-sans tracking-[0.2em] uppercase flex items-center gap-3 mt-1.5 transition-colors duration-500 group-hover:text-gray-200">
                            <span class="font-bold border-b border-rose-gold/30">BEng (Hons)</span>
                            <span class="w-3 h-px bg-rose-gold/20 group-hover:bg-rose-gold/50 transition-colors"></span>
                            <a href="tel:+94766383402" class="hover:text-rose-gold transition-colors font-black text-rose-gold group-hover:text-white">+94 76 638 3402</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
