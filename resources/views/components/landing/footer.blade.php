<!-- 11. FOOTER -->
<footer class="bg-heritageGreen text-white py-16 px-6 lg:px-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 mb-12">
        <div class="md:col-span-4 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-roseRed shadow-sm">
                    <i class="fa-solid fa-rose text-lg"></i>
                </div>
                <span class="font-serif font-bold text-xl tracking-wider text-white">ROSE VILLA</span>
            </div>
            <p class="text-creamBg/80 text-xs leading-relaxed max-w-sm">
                A heritage boutique homestay in Jaffna offering courtyard evenings, timeless architecture, and warm Northern hospitality.
            </p>
            <div class="flex items-center gap-4 pt-2 text-lg text-creamBg">
                <a href="#" class="hover:text-antiqueGold transition-colors" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-antiqueGold transition-colors" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-antiqueGold transition-colors" aria-label="Tripadvisor"><i class="fa-brands fa-tripadvisor"></i></a>
            </div>
        </div>

        <div class="md:col-span-2 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Quick Links</h3>
            <ul class="space-y-2 text-xs text-creamBg/80">
                <li><a href="#about" class="hover:text-white transition-colors">The Heritage</a></li>
                <li><a href="#rooms" class="hover:text-white transition-colors">Rooms & Villas</a></li>
                <li><a href="#culinary" class="hover:text-white transition-colors">Flavors of Jaffna</a></li>
                <li><a href="#gallery" class="hover:text-white transition-colors">Gallery</a></li>
                <li><a href="#find-us" class="hover:text-white transition-colors">Find Us</a></li>
            </ul>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Contact</h3>
            <p class="text-xs text-creamBg/80 leading-relaxed">
                Jaffna, Northern Province, Sri Lanka<br>
                Phone: +94 21 222 4567<br>
                WhatsApp: +94 77 123 4567<br>
                Email: stay@rosevilla.lk
            </p>
        </div>

        <div class="md:col-span-3 space-y-3">
            <h3 class="font-serif font-bold text-sm text-antiqueGold tracking-wider uppercase">Newsletter</h3>
            <p class="text-xs text-creamBg/80">Subscribe for seasonal offers and Jaffna travel guides.</p>
            <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to Rose Villa updates!');" class="flex gap-2">
                <input type="email" placeholder="Your email" required class="bg-white/10 border border-white/20 rounded-xl px-3 py-2.5 text-xs text-white placeholder-creamBg/50 focus:outline-none flex-1">
                <button type="submit" class="bg-antiqueGold hover:bg-goldHover text-white px-4 py-2.5 rounded-xl text-xs font-semibold">Join</button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-creamBg/60">
        <p>&copy; {{ date('Y') }} Rose Villa Heritage Homes. All rights reserved.</p>
        <p class="mt-2 sm:mt-0">Designed with heritage-luxury tone for Jaffna, Sri Lanka.</p>
    </div>
</footer>
