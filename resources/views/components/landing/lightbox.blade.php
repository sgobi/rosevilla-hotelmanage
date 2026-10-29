<!-- LIGHTBOX MODAL -->
<div id="lightbox" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4">
    <button type="button" 
            onclick="closeLightbox()" 
            class="absolute top-6 right-6 text-white text-3xl hover:text-antiqueGold focus:outline-none transition-colors"
            aria-label="Close image popup">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="max-w-4xl max-h-[85vh] overflow-hidden rounded-3xl flex flex-col items-center">
        <img id="lightbox-img" src="" alt="Enlarged gallery view of Rose Villa Heritage Homes" class="max-h-[75vh] object-contain rounded-2xl shadow-2xl">
        <p id="lightbox-caption" class="text-white text-sm mt-4 text-center font-medium"></p>
    </div>
</div>

<script>
    function openLightbox(src, alt) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        if (!lightbox || !lightboxImg) return;
        lightboxImg.src = src;
        if (lightboxCaption) lightboxCaption.textContent = alt || '';
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox) return;
        lightbox.classList.remove('flex');
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close on click outside or escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
