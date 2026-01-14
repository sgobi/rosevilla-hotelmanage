<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $reservation->id }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC:wght@400;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        .font-serif { font-family: 'Alegreya SC', serif; }
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 min-h-screen">
    
    <div class="max-w-3xl mx-auto bg-white shadow-lg p-12 relative print:shadow-none print:p-0 print:max-w-none">
        <!-- Print Button -->
        <button onclick="window.print()" class="no-print absolute top-8 right-8 bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
            </svg>
            Print Invoice
        </button>

        <!-- Header -->
        <div class="flex justify-between items-start mb-16">
            <div>
                <h1 class="font-serif text-3xl text-gray-900 uppercase tracking-widest mb-2">Rose Villa</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest">Heritage Homes</p>
                <div class="mt-4 text-sm text-gray-600">
                    <p>{{ $content['contact_address'] ?? 'Jaffna, Sri Lanka' }}</p>
                    <p>{{ $content['contact_phone'] ?? '' }}</p>
                    <p>{{ $content['contact_email'] ?? '' }}</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-4xl font-light text-gray-200 uppercase tracking-widest">Invoice</h2>
                <p class="text-gray-500 mt-2">#INV-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-gray-500 text-sm">Date: {{ now()->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Bill To -->
        <div class="mb-12 border-b border-gray-100 pb-8">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Bill To</h3>
            <p class="text-lg font-semibold text-gray-800">{{ $reservation->guest_name }}</p>
            <p class="text-gray-600">{{ $reservation->email }}</p>
            <p class="text-gray-600">{{ $reservation->phone }}</p>
        </div>

        <!-- Line Items -->
        <table class="w-full mb-12">
            <thead>
                <tr class="border-b-2 border-gray-100">
                    <th class="text-left py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Description</th>
                    <th class="text-center py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Details</th>
                    <th class="text-right py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Amount</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr class="border-b border-gray-50">
                    <td class="py-6">
                        <p class="font-semibold text-gray-900">{{ $reservation->room->title ?? 'Accommodation' }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $reservation->check_in->format('M d') }} - {{ $reservation->check_out->format('M d, Y') }}
                        </p>
                    </td>
                    <td class="py-6 text-center">
                        Accommodation <br>
                        <span class="text-xs text-gray-400">Rate: LKR {{ number_format($reservation->room->price_per_night ?? 0, 2) }} per day</span>
                    </td>
                    <td class="py-6 text-right font-medium">
                        LKR {{ number_format($reservation->total_price ?? 0, 2) }}
                    </td>
                </tr>
                <!-- Optional extras could go here -->
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-end mb-20">
            <div class="w-64">
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">LKR {{ number_format($reservation->total_price, 2) }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-gray-600">Taxes (0%)</span>
                    <span class="font-medium">LKR 0.00</span>
                </div>
                <div class="flex justify-between py-4 text-xl font-bold text-gray-900">
                    <span>Total</span>
                    <span>LKR {{ number_format($reservation->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Signature -->
        @if($content['signature_path'] ?? null)
        <div class="flex justify-end mb-12">
            <div class="text-center">
                <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-16 mx-auto mb-2">
                <div class="w-48 border-t border-gray-300 pt-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Authorized Signature</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-center text-sm text-gray-400 pt-8 border-t border-gray-100">
            <p class="italic mb-2">"Thank you for choosing Rose Villa Heritage Homes."</p>
            <p>For inquiries, please contact us at {{ $content['contact_email'] ?? 'info@rosevilla.com' }}</p>
        </div>
    </div>

</body>
</html>
