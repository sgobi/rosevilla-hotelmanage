<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Confirmation #{{ $event->id }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body { 
            font-family: 'Inter', sans-serif;
            color: #000000;
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
        }
        .invoice-container {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 25mm 20mm;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            position: relative;
        }
        .serif {
            font-family: 'Crimson Pro', serif;
        }
        @media print {
            body { background: white; margin: 0; }
            .invoice-container { 
                box-shadow: none; 
                margin: 0;
                width: 100%;
                padding: 15mm 15mm;
            }
            .no-print { display: none; }
        }
        .double-line {
            border-top: 3px double #000;
            margin: 15px 0;
        }
        .info-label {
            font-weight: 700;
            font-size: 13px;
        }
        .info-value {
            font-size: 13px;
        }
        .details-list {
            margin-top: 20px;
            margin-bottom: 25px;
        }
        .details-row {
            display: grid;
            grid-template-columns: 200px 1fr 150px 1fr;
            padding: 6px 0;
            font-size: 14px;
        }
        .details-label {
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="no-print fixed top-6 right-6 z-50 flex gap-4">
        <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 border border-gray-200 px-6 py-2 rounded-lg font-bold shadow-lg flex items-center gap-2 hover:bg-gray-50 transition">
            Back to Dashboard
        </a>
        <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-2 rounded-lg font-bold shadow-lg flex items-center gap-2 hover:bg-black transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Confirmation
        </button>
    </div>

    <div class="invoice-container">
        {{-- Header Section --}}
        <div class="flex justify-between items-start mb-10">
            <div class="flex flex-col items-center">
                <img src="{{ asset('storage/logos/invoice logo.png') }}" alt="Rose Villa Logo" class="w-72 h-auto">
            </div>
            <div class="text-right text-[10px] leading-relaxed mt-4 uppercase tracking-widest font-black text-black">
                <div class="flex justify-end gap-2">
                    <span class="w-20 text-right">HOTEL TEL</span>
                    <span>:</span>
                    <span class="w-48 text-left">{{ $content['contact_phone'] ?? '+94 76 319 3311' }}</span>
                </div>
                <div class="flex justify-end gap-2">
                    <span class="w-20 text-right">EMAIL</span>
                    <span>:</span>
                    <span class="w-48 text-left uppercase">{{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</span>
                </div>
                <div class="flex justify-end gap-2">
                    <span class="w-20 text-right">WEBSITE</span>
                    <span>:</span>
                    <span class="w-48 text-left uppercase">www.rosevillaheritagehomes.com</span>
                </div>
            </div>
        </div>

        {{-- Meta Data --}}
        <div class="space-y-1 mb-6">
            <div class="flex gap-4">
                <span class="info-label w-32">Date</span>
                <span class="info-label">:</span>
                <span class="info-value">{{ now()->format('d m Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-4">
                    <span class="info-label w-32">From</span>
                    <span class="info-label">:</span>
                    <span class="info-value">Events Department</span>
                </div>
                <div class="flex gap-4 mr-[140px]">
                    <span class="info-label w-24">Contact No.</span>
                    <span class="info-label">:</span>
                    <span class="info-value">{{ $content['contact_phone'] ?? '+94 76 319 3311' }}</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-4">
                    <span class="info-label w-32">Subject</span>
                    <span class="info-label">:</span>
                    <span class="info-value">Event Booking Confirmation</span>
                </div>
                <div class="flex gap-4 mr-[140px]">
                    <span class="info-label w-24">Pages</span>
                    <span class="info-label">:</span>
                    <span class="info-value">1</span>
                </div>
            </div>
        </div>

        <div class="border-t border-black mb-6"></div>

        {{-- Greeting --}}
        <div class="mb-6 text-[14px] leading-relaxed">
            <p>Thank you for choosing <strong>Rose Villa Heritage Homes</strong> for your event. We are happy to confirm the following details</p>
        </div>

        {{-- Main Details --}}
        <div class="details-list space-y-1">
            <div class="details-row">
                <span class="details-label">Confirmation Number</span>
                <span>: <strong>E-{{ str_pad($event->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
            </div>
            <div class="details-row">
                <span class="details-label">Customer Name</span>
                <span class="capitalize">: {{ strtolower($event->customer_name) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Event Date</span>
                <span>: {{ $event->event_date->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Event Type</span>
                <span>: {{ $event->event_type }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Number of Guests</span>
                <span>: {{ $event->guests }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Base Rental Rate</span>
                <span>: LKR {{ number_format($event->total_price, 2) }}</span>
            </div>
            
            @if($event->tax_amount > 0)
                <div class="details-row">
                    <span class="details-label">Taxes ({{ number_format($event->tax_percentage, 1) }}%)</span>
                    <span>: LKR {{ number_format($event->tax_amount, 2) }}</span>
                </div>
            @endif

            @if($event->discount_amount > 0)
                <div class="details-row text-black">
                    <span class="details-label">Discount</span>
                    <span>: - LKR {{ number_format($event->discount_amount, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="border-t border-black my-4"></div>
        <div class="details-row py-1 font-bold text-[16px]">
            <span>Gross Amount</span>
            <span>: LKR {{ number_format($event->final_price, 2) }}</span>
        </div>
        <div class="border-b border-black mb-8"></div>

        @if($event->advance_amount > 0)
            <div class="details-row text-black">
                <span class="details-label">Deposit Paid</span>
                <span>: - LKR {{ number_format($event->advance_amount, 2) }}</span>
            </div>
            <div class="details-row font-bold mb-8">
                <span class="details-label">Balance Payable</span>
                <span>: LKR {{ number_format($event->final_price - $event->advance_amount, 2) }}</span>
            </div>
        @endif

        <div class="text-[13px] leading-relaxed space-y-4 text-black italic">
            <p>Please note that event bookings are subject to our standard event policies. Cancellations must be made at least 14 days in advance to be eligible for a partial refund of the deposit.</p>
            
            <div class="not-italic">
                <p class="font-bold mb-1">Note:</p>
                <p>1. Setup time must be coordinated with the management at least 48 hours prior to the event.</p>
                <p>2. Any additional services or catering requested on the day will be billed separately.</p>
            </div>

            <p class="not-italic">If you require any information prior to your event, please visit our website <a href="https://www.rosevillaheritagehomes.com" class="text-black font-semibold">www.rosevillaheritagehomes.com</a> or contact our events team at <span class="font-semibold">{{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</span>.</p>
            
            <p class="font-bold not-italic">We are looking forward to hosting your event at Rose Villa Heritage Homes.</p>
        </div>

        {{-- Footer Signature --}}
        <div class="mt-8">
            <p class="font-bold text-[14px]">Events Manager</p>
            @if($content['signature_path'] ?? null)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-16 w-auto object-contain">
                </div>
            @else
                <div class="h-16"></div> {{-- Placeholder space --}}
            @endif
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="text-[10px] uppercase tracking-widest text-black font-bold space-y-1">
                    <p>Hotel Tel : {{ $content['contact_phone'] ?? '+94 76 319 3311' }}</p>
                    <p>Email : {{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</p>
                    <p>WWW : www.rosevillaheritagehomes.com</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
