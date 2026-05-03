<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($isProforma ?? false) ? 'Quotation / Proforma Invoice' : 'Reservation Confirmation' }} #{{ $reservation->id }} - Rose Villa</title>
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
                padding: 5mm 10mm;
            }
            .no-print { display: none !important; }
        }
        .double-line {
            border-top: 3px double #000;
            margin: 15px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 140px 1fr 140px 1fr;
            gap: 10px 20px;
            margin-bottom: 30px;
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
            padding: 2px 0;
            font-size: 13px;
        }
        .details-label {
            font-weight: 700;
        }
        .details-separator {
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="print:hidden no-print fixed top-6 right-6 z-50 flex gap-4">
        <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 border border-gray-200 px-6 py-2 rounded-lg font-bold shadow-lg flex items-center gap-2 hover:bg-gray-50 transition">
            Back to Dashboard
        </a>
        <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-2 rounded-lg font-bold shadow-lg flex items-center gap-2 hover:bg-black transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print {{ ($isProforma ?? false) ? 'Proforma' : 'Confirmation' }}
        </button>
    </div>

    @if($isProforma ?? false)
    <div class="fixed top-24 left-1/2 -translate-x-1/2 bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest no-print z-50 shadow-sm border border-yellow-200">
        Proforma Invoice Mode
    </div>
    @endif

    <div class="invoice-container">
        {{-- Header Section --}}
        <div class="flex justify-between items-start mb-4">
            <div class="flex flex-col items-center">
                <img src="{{ asset('storage/logos/invoice logo.png') }}" alt="Rose Villa Logo" class="w-64 h-auto">
            </div>
            <div class="grid grid-cols-[auto_auto_auto] gap-x-2 gap-y-1 text-[10px] leading-relaxed mt-4 uppercase tracking-widest font-black text-black ml-auto w-fit">
                <div class="text-right">TEL</div>
                <div>:</div>
                <div class="text-left">{{ $content['contact_phone'] ?? '+94 76 319 3311' }}</div>
                
                <div class="text-right">EMAIL</div>
                <div>:</div>
                <div class="text-left uppercase">{{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</div>
                
                <div class="text-right">WEBSITE</div>
                <div>:</div>
                <div class="text-left uppercase">www.rosevillaheritagehomes.com</div>
            </div>
        </div>

        {{-- Meta Data --}}
        <div class="space-y-1 mb-4">
            <div class="flex gap-4">
                <span class="info-label w-32">Date</span>
                <span class="info-label">:</span>
                <span class="info-value">{{ now()->format('d m Y') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-4">
                    <span class="info-label w-32">From</span>
                    <span class="info-label">:</span>
                    <span class="info-value">Reservation Office</span>
                </div>
                <div class="flex gap-4 mr-[120px]">
                    <span class="info-label w-24">Contact No.</span>
                    <span class="info-label">:</span>
                    <span class="info-value whitespace-nowrap">{{ $content['contact_phone'] ?? '+94 76 319 3311' }}</span>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex gap-4">
                    <span class="info-label w-32">Subject</span>
                    <span class="info-label">:</span>
                    <span class="info-value">{{ ($isProforma ?? false) ? 'Quotation / Proforma Invoice' : 'Reservation Confirmation' }}</span>
                </div>
                <div class="flex gap-4 mr-[120px]">
                    <span class="info-label w-24">Pages</span>
                    <span class="info-label">:</span>
                    <span class="info-value">1</span>
                </div>
            </div>
        </div>

        <div class="border-t border-black mb-4"></div>

        {{-- Greeting --}}
        <div class="mb-4 text-[13px] leading-relaxed">
            <p>Thank you for choosing <strong>Rose Villa Heritage Homes</strong>. We are pleased to provide the {{ ($isProforma ?? false) ? 'quotation / proforma invoice' : 'confirmation details' }} for your upcoming stay.</p>
        </div>

        {{-- Main Details --}}
        <div class="details-list space-y-1">
            <div class="details-row">
                <span class="details-label">Confirmation Number</span>
                <span>: <strong>{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
            </div>
            <div class="details-row">
                <span class="details-label">Guest Name</span>
                <span class="capitalize">: {{ strtolower($reservation->guest_name) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Check-in</span>
                <span class="col-span-3">: {{ $reservation->check_in->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Check-out</span>
                <span class="col-span-3">: {{ $reservation->check_out->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Name of Rooms</span>
                <span class="col-span-3">: {{ $reservation->rooms()->pluck('title')->implode(', ') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Number of Persons</span>
                <span>: {{ $reservation->guests }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Room Rate</span>
                <span>: LKR {{ number_format($reservation->total_price, 2) }}</span>
            </div>
            
            @if($reservation->tax_amount > 0)
                <div class="details-row">
                    <span class="details-label">Taxes ({{ number_format($reservation->tax_percentage, 1) }}%)</span>
                    <span>: LKR {{ number_format($reservation->tax_amount, 2) }}</span>
                </div>
            @endif

            @if($reservation->discount_percentage > 0 && $reservation->discount_status === 'approved')
                <div class="details-row text-black">
                    <span class="details-label">Discount ({{ $reservation->discount_percentage }}%)</span>
                    <span>: - LKR {{ number_format(($reservation->total_price * $reservation->discount_percentage) / 100, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="border-t border-black my-2"></div>
        <div class="details-row py-1 font-bold text-[15px]">
            <span>Gross Amount</span>
            <span>: LKR {{ number_format($reservation->final_price, 2) }}</span>
        </div>
        <div class="border-b border-black mb-4"></div>

        @if($reservation->advance_amount > 0)
            <div class="details-row text-black">
                <span class="details-label">Advance Paid</span>
                <span>: - LKR {{ number_format($reservation->advance_amount, 2) }}</span>
            </div>
            <div class="details-row font-bold mb-4">
                <span class="details-label">Balance Payable</span>
                <span>: LKR {{ number_format($reservation->final_price - $reservation->advance_amount, 2) }}</span>
            </div>
        @endif

        <div class="text-[12px] leading-relaxed space-y-2 text-black italic">
            <p>Should you need to cancel your booking, please do so up to 72 hours prior to your scheduled arrival day to avoid late cancellation or no-show charges (one night charge of room, tax and service charge against the guarantee deposit).</p>
            
            <div class="not-italic">
                <p class="font-bold mb-1">Note:</p>
                <p>1. Early arrival requests are based on an availability of serviced rooms on the day of arrival only. Early arrival fees may apply.</p>
                <p>2. Late check-out requests are based on room availability on the day of departure only. Late check-out fees may apply.</p>
            </div>

            <p class="not-italic">If you require any information prior to your arrival, please visit our website <a href="https://www.rosevillaheritagehomes.com" class="text-black font-semibold">www.rosevillaheritagehomes.com</a> or contact our customer service at <span class="font-semibold">{{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</span>.</p>
            
            <p class="font-bold not-italic">We are looking forward to welcoming you to the Rose Villa Heritage Homes.</p>
        </div>

        {{-- Footer Signature --}}
        <div class="mt-2">
            <p class="font-bold text-[13px]">Reservation Officer</p>
            @if($content['signature_path'] ?? null)
                <div class="mt-1">
                    <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-12 w-auto object-contain">
                </div>
            @else
                <div class="h-12"></div> {{-- Placeholder space --}}
            @endif
            <div class="mt-2 pt-2 border-t border-gray-200">
                <div class="grid grid-cols-[auto_auto_auto] gap-x-2 gap-y-0.5 text-[9px] uppercase tracking-widest text-black font-bold w-fit">
                    <div class="text-right">TEL</div>
                    <div>:</div>
                    <div class="text-left">{{ $content['contact_phone'] ?? '+94 76 319 3311' }}</div>
                    
                    <div class="text-right">EMAIL</div>
                    <div>:</div>
                    <div class="text-left">{{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}</div>
                    
                    <div class="text-right">WWW</div>
                    <div>:</div>
                    <div class="text-left">www.rosevillaheritagehomes.com</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
