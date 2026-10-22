@props(['rooms' => null])

<!-- 9. BOOKING FORM -->
<section id="reserve" class="py-24 px-6 lg:px-12 bg-heritageGreen text-white">
    <div class="max-w-3xl mx-auto bg-creamBg text-darkText rounded-3xl p-8 sm:p-12 shadow-2xl">
        <div class="text-center mb-10">
            <span class="text-xs uppercase tracking-widest text-roseRed font-bold block mb-2">Instant Inquiry & Booking</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-heritageGreen">Reserve Your Sanctuary</h2>
            <p class="text-darkText/70 text-sm mt-1">Complete the 2-step form below to request your booking.</p>
            
            @if(session('success'))
                <div class="mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                    <i class="fa-solid fa-circle-check mr-1.5"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                    <i class="fa-solid fa-circle-exclamation mr-1.5"></i> {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center justify-center gap-2 mt-6">
                <span id="step-indicator-1" class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-heritageGreen text-white transition-all shadow-sm">Step 1 of 2: Stay Details</span>
                <span id="step-indicator-2" class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-stoneBeige text-darkText/50 transition-all">Step 2 of 2: Guest Info</span>
            </div>
        </div>

        <form id="booking-form" action="{{ route('reservations.store') }}" method="POST" onsubmit="handleBookingSubmit(event)">
            @csrf
            <input type="hidden" name="stay_type" id="stay-type-input" value="Room">

            <!-- Step 1: Stay Details -->
            <div id="form-step-1" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Stay Type</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" 
                                id="type-room-btn" 
                                onclick="setStayType('Room')" 
                                class="py-3.5 px-4 rounded-xl font-semibold text-sm border-2 border-heritageGreen bg-heritageGreen text-white transition-all shadow-sm">
                            Rooms / Villa
                        </button>
                        <button type="button" 
                                id="type-event-btn" 
                                onclick="setStayType('Garden Event')" 
                                class="py-3.5 px-4 rounded-xl font-semibold text-sm border-2 border-stoneBeige bg-stoneBeige/50 text-darkText transition-all">
                            Garden Event
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Check-In Date</label>
                        <input type="date" 
                               name="check_in" 
                               id="booking-checkin"
                               required 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Check-Out Date</label>
                        <input type="date" 
                               name="check_out" 
                               id="booking-checkout"
                               required 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Guests / Attendees</label>
                        <select name="guests" class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                            <option value="1">1 Guest</option>
                            <option value="2" selected>2 Guests</option>
                            <option value="3">3 - 4 Guests</option>
                            <option value="5">5+ Guests / Event Attendees</option>
                        </select>
                    </div>
                    <div id="room-selection-container">
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Room Preference</label>
                        <select id="room-type-select" name="room_preference" class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                            <option value="Heritage Room">Heritage Room (LKR 22,000 / night)</option>
                            <option value="Garden Villa">Garden Villa (LKR 32,000 / night)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" 
                            onclick="goToStep(2)" 
                            class="bg-heritageGreen text-white font-semibold px-8 py-3.5 rounded-xl shadow-md hover:bg-heritageGreen/90 transition-all text-sm">
                        Next: Guest Details <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Guest Details -->
            <div id="form-step-2" class="space-y-6 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Full Name</label>
                        <input type="text" 
                               id="guest-name" 
                               name="guest_name" 
                               required 
                               placeholder="Subramaniyam Gobikrishna" 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Email Address</label>
                        <input type="email" 
                               id="guest-email" 
                               name="email" 
                               required 
                               placeholder="gobik@example.com" 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Phone Number / WhatsApp</label>
                        <input type="tel" 
                               id="guest-phone" 
                               name="phone" 
                               required 
                               placeholder="+94 77 123 4567" 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Country of Residence</label>
                        <input type="text" 
                               name="address" 
                               placeholder="Sri Lanka / United Kingdom" 
                               class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Special Requests / Dietary Notes</label>
                    <textarea name="special_requirements" 
                              rows="3" 
                              placeholder="Let us know if you need airport pickup, traditional Jaffna meals, or setup preferences." 
                              class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen"></textarea>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" 
                            onclick="goToStep(1)" 
                            class="text-xs font-semibold text-heritageGreen hover:underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Stay Details
                    </button>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button" 
                                onclick="bookViaWhatsApp()" 
                                class="flex-1 sm:flex-initial bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3.5 rounded-xl shadow transition-all text-xs flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-base"></i> Book via WhatsApp
                        </button>
                        <button type="submit" 
                                class="flex-1 sm:flex-initial bg-antiqueGold hover:bg-goldHover text-white font-semibold px-8 py-3.5 rounded-xl shadow transition-all text-xs">
                            Submit Reservation
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    function goToStep(step) {
        const step1 = document.getElementById('form-step-1');
        const step2 = document.getElementById('form-step-2');
        const ind1 = document.getElementById('step-indicator-1');
        const ind2 = document.getElementById('step-indicator-2');

        if (step === 2) {
            // Basic step 1 validation
            const checkin = document.getElementById('booking-checkin');
            const checkout = document.getElementById('booking-checkout');
            if (checkin && !checkin.value) {
                checkin.focus();
                return;
            }
            if (checkout && !checkout.value) {
                checkout.focus();
                return;
            }

            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            ind1.classList.remove('bg-heritageGreen', 'text-white');
            ind1.classList.add('bg-stoneBeige', 'text-darkText/50');
            ind2.classList.remove('bg-stoneBeige', 'text-darkText/50');
            ind2.classList.add('bg-heritageGreen', 'text-white');
        } else {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            ind2.classList.remove('bg-heritageGreen', 'text-white');
            ind2.classList.add('bg-stoneBeige', 'text-darkText/50');
            ind1.classList.remove('bg-stoneBeige', 'text-darkText/50');
            ind1.classList.add('bg-heritageGreen', 'text-white');
        }
    }

    function setStayType(type) {
        const roomBtn = document.getElementById('type-room-btn');
        const eventBtn = document.getElementById('type-event-btn');
        const roomContainer = document.getElementById('room-selection-container');
        const stayTypeInput = document.getElementById('stay-type-input');

        if (stayTypeInput) stayTypeInput.value = type;

        if (type === 'Room') {
            roomBtn.classList.add('bg-heritageGreen', 'text-white', 'border-heritageGreen');
            roomBtn.classList.remove('bg-stoneBeige/50', 'text-darkText', 'border-stoneBeige');
            eventBtn.classList.remove('bg-heritageGreen', 'text-white', 'border-heritageGreen');
            eventBtn.classList.add('bg-stoneBeige/50', 'text-darkText', 'border-stoneBeige');
            if (roomContainer) roomContainer.style.display = 'block';
        } else {
            eventBtn.classList.add('bg-heritageGreen', 'text-white', 'border-heritageGreen');
            eventBtn.classList.remove('bg-stoneBeige/50', 'text-darkText', 'border-stoneBeige');
            roomBtn.classList.remove('bg-heritageGreen', 'text-white', 'border-heritageGreen');
            roomBtn.classList.add('bg-stoneBeige/50', 'text-darkText', 'border-stoneBeige');
            if (roomContainer) roomContainer.style.display = 'none';
        }
    }

    function selectRoom(roomName) {
        const select = document.getElementById('room-type-select');
        if (select) {
            for(let i=0; i<select.options.length; i++) {
                if(select.options[i].text.includes(roomName)) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
        setStayType('Room');
    }

    function selectStayType(type) {
        if(type === 'Garden Event') {
            setStayType('Garden Event');
        }
    }

    function bookViaWhatsApp() {
        const name = document.getElementById('guest-name')?.value || 'Guest';
        const phone = document.getElementById('guest-phone')?.value || '';
        const email = document.getElementById('guest-email')?.value || '';
        const stayType = document.getElementById('stay-type-input')?.value || 'Room';
        const checkin = document.getElementById('booking-checkin')?.value || '';
        const checkout = document.getElementById('booking-checkout')?.value || '';
        const msg = `Hello Rose Villa, I would like to request a reservation.%0A*Type:* ${stayType}%0A*Check-in:* ${checkin}%0A*Check-out:* ${checkout}%0A*Name:* ${name}%0A*Phone:* ${phone}%0A*Email:* ${email}`;
        window.open(`https://wa.me/94771234567?text=${msg}`, '_blank');
    }

    function handleBookingSubmit(event) {
        // Allows default form POST to Laravel controller if required fields are valid
    }
</script>
