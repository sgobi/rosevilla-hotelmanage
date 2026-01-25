<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $reservation->id }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body { 
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            background-color: #f3f4f6;
        }
        .invoice-page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            font-weight: 600;
        }
        .header-title {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 10px;
            color: #111827;
        }
        .header-meta {
            text-align: center;
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 30px;
        }
        .section-title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 10px;
        }
        @media print {
            body { background: white; }
            .invoice-page { 
                box-shadow: none; 
                margin: 0;
                width: 100%;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print fixed top-6 right-6 z-50">
        <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-2 rounded-lg font-bold shadow-lg flex items-center gap-2 hover:bg-black transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Invoice
        </button>
    </div>

    <div class="invoice-page">
        {{-- Logo Section --}}
        <div class="flex justify-center mb-4">
            <h2 class="text-2xl font-black uppercase tracking-[0.1em] text-gray-900 border-b-2 border-gray-900 pb-2">Rosevilla Heritage Homes</h2>
        </div>

        {{-- Title --}}
        <h1 class="header-title">Invoice</h1>
        <div class="header-meta">
            <strong>Invoice Number:</strong> {{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }} | 
            <strong>Invoice Date:</strong> {{ now()->format('F d, Y') }}
        </div>

        {{-- Customer Info Table --}}
        <table>
            <thead>
                <tr>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Customer Address</th>
                    <th class="text-center">Contact Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center font-bold text-lg">{{ $reservation->guest_name }}</td>
                    <td class="text-center text-gray-600">{{ $reservation->address ?? 'N/A' }}</td>
                    <td class="text-center font-bold">{{ $reservation->phone }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Service Breakdown Table --}}
        <table>
            <thead>
                <tr>
                    <th>Service Description and Charges</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $checkIn = \Carbon\Carbon::parse($reservation->check_in);
                    $checkOut = \Carbon\Carbon::parse($reservation->check_out);
                    $nights = $checkIn->diffInDays($checkOut);
                    if($nights < 1) $nights = 1;
                @endphp
                <tr>
                    <td>
                        <div class="font-bold text-gray-900">Room Accommodation ({{ $nights }} nights)</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $reservation->room->title ?? 'Base Suite' }} &times; {{ $nights }} nights @ LKR {{ number_format($reservation->room->price_per_night ?? 0, 2) }}</div>
                    </td>
                    <td class="text-right font-medium">LKR {{ number_format($reservation->total_price, 2) }}</td>
                </tr>
                {{-- Dynamic rows can be added here in future --}}
                <tr class="font-bold bg-gray-50/30">
                    <td>Subtotal</td>
                    <td class="text-right">LKR {{ number_format($reservation->total_price, 2) }}</td>
                </tr>
                
                @if($reservation->discount_status === 'approved' && $reservation->discount_percentage > 0)
                    @php 
                        $discount = ($reservation->total_price * $reservation->discount_percentage) / 100;
                        $final = $reservation->total_price - $discount;
                    @endphp
                    <tr>
                        <td class="text-emerald-700">Discount ({{ $reservation->discount_percentage }}%)</td>
                        <td class="text-right text-emerald-700">- LKR {{ number_format($discount, 2) }}</td>
                    </tr>
                @else
                    @php $final = $reservation->total_price; @endphp
                @endif

                <tr>
                    <td>Tax ({{ number_format($reservation->tax_percentage, 1) }}%)</td>
                    <td class="text-right">LKR {{ number_format($reservation->tax_amount, 2) }}</td>
                </tr>
                <tr class="font-bold border-t-2 border-gray-400 bg-gray-50">
                    <td class="text-lg">Total Amount Due</td>
                    <td class="text-right text-lg">LKR {{ number_format($final, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Payment Information Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Payment Information</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment Method</td>
                    <td class="font-medium">Direct Transfer / Cash</td>
                </tr>
                <tr>
                    <td>Payment Due</td>
                    <td class="font-medium">Upon Check-in</td>
                </tr>
            </tbody>
        </table>

        {{-- Terms and Conditions --}}
        <div class="mt-8">
            <h4 class="section-title">Terms and Conditions:</h4>
            <div class="text-sm text-gray-600 space-y-2 leading-relaxed">
                <p>All prices are subject to change without notice. Payment is due upon arrival. Cancellations must be made 48 hours in advance to avoid charges. For any inquiries, please contact <strong>{{ \App\Models\ContentSetting::getValue('site_title', 'Rose Villa Heritage') }}</strong> at <strong>{{ $content['contact_email'] ?? 'info@rosevilla.com' }}</strong>.</p>
            </div>
        </div>

        {{-- Signature --}}
        @if($content['signature_path'] ?? null)
            <div class="mt-12 flex justify-end">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-16 mx-auto mb-2 opacity-90">
                    <div class="border-t border-gray-300 pt-2 px-8">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Authorized Signature</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Footer Branding --}}
        <div class="mt-16 pt-8 border-t border-gray-100 text-center text-[10px] text-gray-400 uppercase tracking-widest">
            Rose Villa Heritage Homes - Jaffna, Sri Lanka
        </div>
    </div>

</body>
</html>
