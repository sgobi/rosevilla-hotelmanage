<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $reservation->id }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* A4 Paper Specifications */
        @page {
            size: A4;
            margin: 0;
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        }
        
        .font-display { font-family: 'Playfair Display', serif; }
        
        /* A4 dimensions: 210mm × 297mm */
        .invoice-container {
            width: 210mm;
            min-height: 297mm;
            background: linear-gradient(to bottom, #ffffff 0%, #fefefe 100%);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
            margin: 0 auto;
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #b8860b 0%, #8b4513 50%, #722f37 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .corner-ornament {
            position: absolute;
            width: 60px;
            height: 60px;
            border-style: solid;
            border-color: #d4af37;
        }
        
        .corner-tl { top: 0; left: 0; border-width: 3px 0 0 3px; }
        .corner-tr { top: 0; right: 0; border-width: 3px 3px 0 0; }
        .corner-bl { bottom: 0; left: 0; border-width: 0 0 3px 3px; }
        .corner-br { bottom: 0; right: 0; border-width: 0 3px 3px 0; }
        
        .rose-accent {
            background: linear-gradient(135deg, #d4af37 0%, #aa8b56 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .table-row:hover {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.05) 0%, rgba(212, 175, 55, 0.1) 50%, rgba(212, 175, 55, 0.05) 100%);
            transform: translateX(4px);
            transition: all 0.3s ease;
        }
        
        .print-btn {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        
        .signature-box {
            border: 2px solid #d4af37;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05) 0%, rgba(212, 175, 55, 0.1) 100%);
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }
        
        .total-highlight {
            background: linear-gradient(135deg, #d4af37 0%, #aa8b56 100%);
            color: white;
            padding: 0.875rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        @media print {
            .no-print { display: none !important; }
            
            body { 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background: white !important;
                margin: 0;
                padding: 0;
            }
            
            .invoice-container {
                width: 210mm;
                height: 297mm;
                box-shadow: none !important;
                margin: 0;
                page-break-after: always;
            }
            
            .table-row:hover {
                transform: none;
                background: transparent;
            }
        }
        
        @media screen {
            body {
                padding: 20px;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="invoice-container p-12 relative print:p-12">
        <!-- Corner Ornaments -->
        <div class="corner-ornament corner-tl no-print"></div>
        <div class="corner-ornament corner-tr no-print"></div>
        <div class="corner-ornament corner-bl no-print"></div>
        <div class="corner-ornament corner-br no-print"></div>
        
        <!-- Print Button -->
        <button onclick="window.print()" class="no-print absolute top-8 right-8 print-btn text-white px-6 py-3 rounded-lg flex items-center gap-2 font-medium z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Print Invoice
        </button>

        <!-- Gradient Header -->
        <div class="gradient-header -mx-12 -mt-12 px-12 pt-12 pb-10 mb-10">
            <div class="flex justify-between items-start text-white">
                <div>
                    <h1 class="font-display text-5xl font-bold mb-2 tracking-wide">Rose Villa</h1>
                    <p class="text-sm uppercase tracking-[0.3em] opacity-90">Heritage Homes</p>
                    <div class="mt-5 text-sm opacity-90 space-y-1">
                        <p>{{ $content['contact_address'] ?? 'Jaffna, Sri Lanka' }}</p>
                        <p>{{ $content['contact_phone'] ?? '' }}</p>
                        <p>{{ $content['contact_email'] ?? '' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-6xl font-display font-bold uppercase tracking-wider mb-3">Invoice</h2>
                    <div class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 rounded-lg inline-block">
                        <p class="text-lg font-semibold">#INV-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <p class="text-sm mt-3 opacity-90">{{ now()->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="mb-10 pb-6 border-b-2 border-gray-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 rose-accent">Bill To</h3>
            <p class="text-2xl font-semibold text-gray-900 mb-2">{{ $reservation->guest_name }}</p>
            <p class="text-gray-600 text-lg">{{ $reservation->email }}</p>
            <p class="text-gray-600 text-lg">{{ $reservation->phone }}</p>
        </div>

        <!-- Line Items -->
        <table class="w-full mb-10">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="text-left py-4 text-xs font-bold text-gray-500 uppercase tracking-[0.15em]">Description</th>
                    <th class="text-center py-4 text-xs font-bold text-gray-500 uppercase tracking-[0.15em]">Details</th>
                    <th class="text-right py-4 text-xs font-bold text-gray-500 uppercase tracking-[0.15em]">Amount</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-b border-gray-100 table-row">
                    <td class="py-6">
                        <p class="font-semibold text-gray-900 text-lg mb-1">{{ $reservation->room->title ?? 'Accommodation' }}</p>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            {{ $reservation->check_in->format('M d') }} - {{ $reservation->check_out->format('M d, Y') }}
                        </p>
                    </td>
                    <td class="py-6 text-center">
                        <span class="font-medium text-gray-800">Accommodation</span><br>
                        <span class="text-xs text-gray-400 mt-1 inline-block">Rate: LKR {{ number_format($reservation->room->price_per_night ?? 0, 2) }} per day</span>
                    </td>
                    <td class="py-6 text-right font-semibold text-lg text-gray-900">
                        LKR {{ number_format($reservation->total_price ?? 0, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-end mb-12">
            <div class="w-80">
                <div class="flex justify-between py-3 border-b border-gray-200 text-gray-700">
                    <span class="font-medium">Subtotal</span>
                    <span class="font-semibold">LKR {{ number_format($reservation->total_price, 2) }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-200 text-gray-700">
                    <span class="font-medium">Taxes (0%)</span>
                    <span class="font-semibold">LKR 0.00</span>
                </div>
                <div class="total-highlight mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold">Total Amount</span>
                        <span class="text-3xl font-bold">LKR {{ number_format($reservation->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signature -->
        @if($content['signature_path'] ?? null)
        <div class="flex justify-end mb-10">
            <div class="signature-box text-center">
                <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-16 mx-auto mb-2">
                <div class="w-56 border-t-2 border-gray-400 pt-2 mx-auto">
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-[0.2em]">Authorized Signature</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500 pt-8 border-t-2 border-gray-200">
            <p class="font-display text-lg italic mb-2 text-gray-700">"Thank you for choosing Rose Villa Heritage Homes."</p>
            <p class="text-gray-600">For inquiries, please contact us at <span class="rose-accent font-semibold">{{ $content['contact_email'] ?? 'info@rosevilla.com' }}</span></p>
        </div>
    </div>

</body>
</html>
