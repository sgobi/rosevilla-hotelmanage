@props(['rooms' => null, 'bookedDatesByRoom' => '{}', 'bookedDatesGarden' => '[]'])

<style>
    .flatpickr-calendar {
        font-family: inherit !important;
        border-radius: 1.25rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        border: 1px solid #e7e5e4 !important;
        background: #fffdfa !important;
        overflow: hidden;
    }
    .flatpickr-months {
        background: #1e3d34 !important;
        color: #ffffff !important;
        border-radius: 1.25rem 1.25rem 0 0 !important;
        padding: 8px 0 !important;
    }
    .flatpickr-months .flatpickr-month {
        color: #ffffff !important;
        fill: #ffffff !important;
    }
    .flatpickr-current-month .cur-month, 
    .flatpickr-current-month input.cur-year {
        font-weight: 700 !important;
        color: #ffffff !important;
    }
    .flatpickr-weekdays {
        background: #1e3d34 !important;
    }
    span.flatpickr-weekday {
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 600 !important;
        font-size: 11px !important;
    }
    .flatpickr-day.selected, 
    .flatpickr-day.startRange, 
    .flatpickr-day.endRange {
        background: #1e3d34 !important;
        border-color: #1e3d34 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.inRange {
        background: #e7eee8 !important;
        border-color: #e7eee8 !important;
        box-shadow: -5px 0 0 #e7eee8, 5px 0 0 #e7eee8 !important;
    }
    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.booked-date,
    .flatpickr-day.booked-date:hover {
        color: #ef4444 !important;
        background: #fee2e2 !important;
        text-decoration: line-through !important;
        opacity: 0.7 !important;
        cursor: not-allowed !important;
        border-radius: 6px !important;
    }
</style>

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

                <div class="space-y-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Check-In Date</label>
                            <input type="text" 
                                   name="check_in" 
                                   id="booking-checkin"
                                   placeholder="Select Check-in Date..."
                                   required 
                                   readonly
                                   class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-heritageGreen mb-2">Check-Out Date</label>
                            <input type="text" 
                                   name="check_out" 
                                   id="booking-checkout"
                                   placeholder="Select Check-out Date..."
                                   required 
                                   readonly
                                   class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen cursor-pointer">
                        </div>
                    </div>
                    <!-- Calendar Availability Legend -->
                    <div class="flex items-center justify-between text-[11px] text-darkText/60 px-1 pt-1">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block shadow-sm"></span> Available Dates
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block shadow-sm"></span> Red Strikethrough = Already Booked
                        </span>
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
                        <select id="room-type-select" name="room_id" onchange="updatePriceCalculation()" class="w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen">
                            @php
                                $roomList = ($rooms && count($rooms) > 0) ? $rooms : \App\Models\Room::where('is_active', true)->orderBy('price_per_night')->get();
                            @endphp
                            @foreach($roomList as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" data-title="{{ $room->title }}">
                                    {{ $room->title }} (LKR {{ number_format($room->price_per_night, 2) }} / night)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Live Total Price Breakdown Card -->
                <div id="booking-price-card" class="bg-stoneBeige/60 border border-stoneBeige rounded-2xl p-4 sm:p-5 transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-heritageGreen flex items-center gap-1.5">
                                <i class="fa-solid fa-calculator text-xs"></i> Total Price Calculation
                            </span>
                            <div id="price-calculation-breakdown" class="text-xs text-darkText/75 flex items-center gap-2 flex-wrap">
                                <span id="summary-room-title" class="font-bold text-darkText">Heritage Room</span>
                                <span class="text-darkText/30">•</span>
                                <span id="summary-room-rate">LKR 8,000.00 / night</span>
                                <span class="text-darkText/40 font-bold">×</span>
                                <span id="summary-duration" class="font-bold text-heritageGreen">1 night</span>
                            </div>
                        </div>
                        <div class="sm:text-right">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-darkText/50 block">Total Amount</span>
                            <div id="summary-total-display" class="text-2xl font-serif font-black text-heritageGreen leading-tight">
                                LKR 8,000.00
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" 
                            onclick="goToStep(2)" 
                            class="bg-heritageGreen text-white font-semibold px-8 py-3.5 rounded-xl shadow-md hover:bg-heritageGreen/90 transition-all text-sm">
                        Next: Guest Details <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Guest Details -->
            <div id="form-step-2" class="space-y-6 hidden">
                <!-- Step 2 Summary Banner -->
                <div class="bg-stoneBeige/40 border border-stoneBeige rounded-2xl px-5 py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-xl bg-heritageGreen/10 text-heritageGreen flex items-center justify-center text-xs">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-darkText/50 block">Booking Breakdown</span>
                            <span class="text-xs font-semibold text-darkText" id="step2-summary-text">Heritage Room • 1 night</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-darkText/50 block">Total Amount</span>
                        <span class="text-base font-serif font-black text-heritageGreen" id="step2-summary-price">LKR 8,000.00</span>
                    </div>
                </div>

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
    window.bookedDatesByRoom = {!! is_string($bookedDatesByRoom) ? $bookedDatesByRoom : json_encode($bookedDatesByRoom) !!};
    window.bookedDatesGarden = {!! is_string($bookedDatesGarden) ? $bookedDatesGarden : json_encode($bookedDatesGarden) !!};

    let fpCheckIn = null;
    let fpCheckOut = null;

    function formatDateToYMD(date) {
        if (!date) return '';
        const d = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        return d.toISOString().split('T')[0];
    }

    function isDateBooked(dateStr) {
        if (!dateStr) return false;
        const stayType = document.getElementById('stay-type-input')?.value || 'Room';
        const roomSelect = document.getElementById('room-type-select');

        if (stayType === 'Garden Event' && window.bookedDatesGarden) {
            for (let j = 0; j < window.bookedDatesGarden.length; j++) {
                const range = window.bookedDatesGarden[j];
                if (dateStr >= range.check_in && dateStr <= range.check_out) {
                    return true;
                }
            }
        }

        if (stayType === 'Room' && roomSelect && window.bookedDatesByRoom) {
            const selectedRoomId = roomSelect.value;
            if (selectedRoomId && window.bookedDatesByRoom[selectedRoomId]) {
                const ranges = window.bookedDatesByRoom[selectedRoomId];
                for (let j = 0; j < ranges.length; j++) {
                    const range = ranges[j];
                    const isBooked = (range.check_in === range.check_out)
                        ? (dateStr === range.check_in)
                        : (dateStr >= range.check_in && dateStr < range.check_out);
                    if (isBooked) return true;
                }
            }
        }
        return false;
    }

    function initFlatpickrCalendar() {
        if (typeof flatpickr === 'undefined') {
            setTimeout(initFlatpickrCalendar, 100);
            return;
        }

        const commonConfig = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "M d, Y",
            altInputClass: "w-full bg-stoneBeige/40 border border-stoneBeige rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-heritageGreen cursor-pointer",
            minDate: "today",
            disableMobile: true,
            disable: [
                function(date) {
                    return isDateBooked(formatDateToYMD(date));
                }
            ],
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const dateStr = formatDateToYMD(dayElem.dateObj);
                if (isDateBooked(dateStr)) {
                    dayElem.classList.add('booked-date');
                    dayElem.title = "Already Booked / Unavailable";
                }
            }
        };

        fpCheckIn = flatpickr("#booking-checkin", {
            ...commonConfig,
            onChange: function(selectedDates, dateStr) {
                if (selectedDates[0]) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);
                    if (fpCheckOut) {
                        fpCheckOut.set("minDate", formatDateToYMD(nextDay));
                        const currentCheckout = fpCheckOut.selectedDates[0];
                        if (!currentCheckout || currentCheckout <= selectedDates[0]) {
                            fpCheckOut.setDate(nextDay, true);
                        }
                    }
                }
                updatePriceCalculation();
            }
        });

        fpCheckOut = flatpickr("#booking-checkout", {
            ...commonConfig,
            onChange: function(selectedDates, dateStr) {
                updatePriceCalculation();
            }
        });
    }

    function refreshCalendarAvailability() {
        if (fpCheckIn) fpCheckIn.redraw();
        if (fpCheckOut) fpCheckOut.redraw();
        updatePriceCalculation();
    }

    function goToStep(step) {
        const step1 = document.getElementById('form-step-1');
        const step2 = document.getElementById('form-step-2');
        const ind1 = document.getElementById('step-indicator-1');
        const ind2 = document.getElementById('step-indicator-2');

        if (step === 2) {
            const checkin = document.getElementById('booking-checkin');
            const checkout = document.getElementById('booking-checkout');
            if (checkin && !checkin.value) {
                if (fpCheckIn) fpCheckIn.open();
                else checkin.focus();
                return;
            }
            if (checkout && !checkout.value) {
                if (fpCheckOut) fpCheckOut.open();
                else checkout.focus();
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

    function updatePriceCalculation() {
        const stayType = document.getElementById('stay-type-input')?.value || 'Room';
        const checkinInput = document.getElementById('booking-checkin');
        const checkoutInput = document.getElementById('booking-checkout');
        const roomSelect = document.getElementById('room-type-select');

        const roomTitleEl = document.getElementById('summary-room-title');
        const roomRateEl = document.getElementById('summary-room-rate');
        const durationEl = document.getElementById('summary-duration');
        const totalDisplayEl = document.getElementById('summary-total-display');
        const step2TextEl = document.getElementById('step2-summary-text');
        const step2PriceEl = document.getElementById('step2-summary-price');

        let days = 1;
        if (checkinInput && checkoutInput && checkinInput.value && checkoutInput.value) {
            const d1 = new Date(checkinInput.value);
            const d2 = new Date(checkoutInput.value);
            const diffTime = d2.getTime() - d1.getTime();
            const diffDays = Math.round(diffTime / (1000 * 3600 * 24));
            days = Math.max(1, diffDays);
        }

        let title = 'Heritage Room';
        let unitPrice = 8000;
        let unitLabel = 'night';

        if (stayType === 'Garden Event') {
            title = 'Garden Event Sanctuary';
            unitPrice = 30000;
            unitLabel = 'day';
        } else if (roomSelect && roomSelect.selectedIndex >= 0) {
            const opt = roomSelect.options[roomSelect.selectedIndex];
            unitPrice = parseFloat(opt.getAttribute('data-price')) || 8000;
            title = opt.getAttribute('data-title') || opt.text.split('(')[0].trim();
        }

        const total = unitPrice * days;
        const formattedUnitPrice = 'LKR ' + unitPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const formattedTotal = 'LKR ' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const durationText = `${days} ${unitLabel}${days > 1 ? 's' : ''}`;

        if (roomTitleEl) roomTitleEl.textContent = title;
        if (roomRateEl) roomRateEl.textContent = `${formattedUnitPrice} / ${unitLabel}`;
        if (durationEl) durationEl.textContent = durationText;
        if (totalDisplayEl) totalDisplayEl.textContent = formattedTotal;

        if (step2TextEl) step2TextEl.textContent = `${title} • ${durationText}`;
        if (step2PriceEl) step2PriceEl.textContent = formattedTotal;
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

        refreshCalendarAvailability();
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
        refreshCalendarAvailability();
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
        const roomSelect = document.getElementById('room-type-select');
        const selectedRoomText = (roomSelect && roomSelect.selectedIndex >= 0) ? roomSelect.options[roomSelect.selectedIndex].text.trim() : '';
        const roomInfo = (stayType === 'Room' && selectedRoomText) ? `%0A*Room:* ${encodeURIComponent(selectedRoomText)}` : '';
        const totalAmountText = document.getElementById('summary-total-display')?.textContent.trim() || '';
        const durationText = document.getElementById('summary-duration')?.textContent.trim() || '';
        const costInfo = totalAmountText ? `%0A*Duration:* ${encodeURIComponent(durationText)}%0A*Total Amount:* ${encodeURIComponent(totalAmountText)}` : '';
        const msg = `Hello Rose Villa, I would like to request a reservation.%0A*Type:* ${stayType}${roomInfo}%0A*Check-in:* ${checkin}%0A*Check-out:* ${checkout}${costInfo}%0A*Name:* ${name}%0A*Phone:* ${phone}%0A*Email:* ${email}`;
        window.open(`https://wa.me/94771234567?text=${msg}`, '_blank');
    }

    function handleBookingSubmit(event) {
        const stayType = document.getElementById('stay-type-input')?.value;
        const form = document.getElementById('booking-form');
        if (stayType === 'Garden Event' && form) {
            form.action = "{{ route('garden.store') }}";
        } else if (form) {
            form.action = "{{ route('reservations.store') }}";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initFlatpickrCalendar();
        updatePriceCalculation();
    });
</script>
