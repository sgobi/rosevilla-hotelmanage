@props(['reviews' => null])

<!-- 8. GUEST STORIES (TESTIMONIALS) -->
<section class="py-24 px-6 lg:px-12 max-w-7xl mx-auto" x-data="{ reviewModalOpen: false }">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
        <div>
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Testimonials</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen">Guest Stories</h2>
        </div>
        <div class="mt-4 md:mt-0">
            <button type="button" 
                    @click="reviewModalOpen = true" 
                    class="bg-stoneBeige hover:bg-stoneBeige/80 text-darkText font-semibold text-xs px-5 py-3.5 rounded-xl transition-all border border-stoneBeige shadow-sm">
                Share your experience
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-stoneBeige/40 rounded-3xl p-8 border border-stoneBeige shadow-sm flex flex-col justify-between">
            <div class="space-y-4">
                <div class="text-antiqueGold flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-darkText/80 text-sm leading-relaxed italic">
                    "Staying at Rose Villa was the highlight of our Jaffna trip. The historic architecture, peaceful mornings in the garden, and genuine warmth made us feel right at home."
                </p>
            </div>
            <div class="pt-6 border-t border-stoneBeige/60 mt-6">
                <h3 class="font-serif font-bold text-heritageGreen text-base">Anjali & Ramesh</h3>
                <span class="text-xs text-darkText/60">Colombo, Sri Lanka</span>
            </div>
        </div>

        <div class="bg-stoneBeige/40 rounded-3xl p-8 border border-stoneBeige shadow-sm flex flex-col justify-between">
            <div class="space-y-4">
                <div class="text-antiqueGold flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-darkText/80 text-sm leading-relaxed italic">
                    "An absolute sanctuary of calm. The home-cooked Jaffna breakfast was outstanding, and the rooms combine old-world charm with impeccable cleanliness."
                </p>
            </div>
            <div class="pt-6 border-t border-stoneBeige/60 mt-6">
                <h3 class="font-serif font-bold text-heritageGreen text-base">Dr. Marcus Vance</h3>
                <span class="text-xs text-darkText/60">London, United Kingdom</span>
            </div>
        </div>

        <div class="bg-stoneBeige/40 rounded-3xl p-8 border border-stoneBeige shadow-sm flex flex-col justify-between">
            <div class="space-y-4">
                <div class="text-antiqueGold flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-darkText/80 text-sm leading-relaxed italic">
                    "We hosted our family reunion dinner in the garden. The ambiance under the palm trees was magical. Our guests are still talking about how wonderful it was!"
                </p>
            </div>
            <div class="pt-6 border-t border-stoneBeige/60 mt-6">
                <h3 class="font-serif font-bold text-heritageGreen text-base">Kavitha Selvarajah</h3>
                <span class="text-xs text-darkText/60">Jaffna, Sri Lanka</span>
            </div>
        </div>
    </div>

    <!-- Review Modal with Laravel Form submission -->
    <div x-show="reviewModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div @click.away="reviewModalOpen = false" 
             class="bg-creamBg border border-stoneBeige max-w-lg w-full rounded-3xl p-8 shadow-2xl relative">
            <button type="button" 
                    @click="reviewModalOpen = false" 
                    class="absolute top-5 right-5 text-darkText/60 hover:text-roseRed text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h3 class="font-serif font-bold text-2xl text-heritageGreen mb-2">Share Your Experience</h3>
            <p class="text-xs text-darkText/70 mb-6">Your feedback helps future guests discover the heritage warmth of Rose Villa.</p>
            
            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-1">Your Name</label>
                    <input type="text" name="guest_name" required placeholder="Your name" class="w-full bg-white border border-stoneBeige rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-heritageGreen">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-1">Rating</label>
                    <select name="rating" class="w-full bg-white border border-stoneBeige rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-heritageGreen">
                        <option value="5" selected>5 Stars - Exceptional</option>
                        <option value="4">4 Stars - Very Good</option>
                        <option value="3">3 Stars - Good</option>
                        <option value="2">2 Stars - Fair</option>
                        <option value="1">1 Star - Poor</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-1">Review</label>
                    <textarea name="comment" rows="4" required placeholder="Tell us about your stay, the food, or our garden..." class="w-full bg-white border border-stoneBeige rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-heritageGreen"></textarea>
                </div>
                <div class="pt-2 flex justify-end gap-3">
                    <button type="button" @click="reviewModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-darkText hover:bg-stoneBeige/50">Cancel</button>
                    <button type="submit" class="bg-heritageGreen text-white px-6 py-2.5 rounded-xl text-xs font-semibold shadow hover:bg-heritageGreen/90">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</section>
