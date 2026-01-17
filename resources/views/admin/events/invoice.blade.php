<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Invoice #{{ $event->id }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); }
        .font-display { font-family: 'Playfair Display', serif; }
        .invoice-container { width: 210mm; min-height: 297mm; background: white; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15); margin: 0 auto; }
        .gradient-header { background: linear-gradient(135deg, #b8860b 0%, #8b4513 100%); }
        .rose-accent { background: linear-gradient(135deg, #d4af37 0%, #aa8b56 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .total-highlight { background: linear-gradient(135deg, #d4af37 0%, #aa8b56 100%); color: white; padding: 1.5rem; border-radius: 12px; }
        @media print { .no-print { display: none !important; } .invoice-container { box-shadow: none !important; margin: 0; } }
    </style>
</head>
<body class="p-10">
    <div class="invoice-container p-12 relative">
        <button onclick="window.print()" class="no-print absolute top-8 right-8 bg-gray-800 text-white px-6 py-2 rounded-lg flex items-center gap-2 font-medium">
            Print Invoice
        </button>

        <div class="gradient-header -mx-12 -mt-12 px-12 pt-12 pb-10 mb-10 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="font-display text-5xl font-bold mb-2">Rose Villa</h1>
                    <p class="text-sm uppercase tracking-widest opacity-90">Heritage Homes & Events</p>
                    <div class="mt-5 text-sm opacity-90">
                        <p>{{ $content['contact_address'] ?? 'Jaffna, Sri Lanka' }}</p>
                        <p>{{ $content['contact_phone'] ?? '' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-5xl font-display font-bold uppercase mb-3">Event Invoice</h2>
                    <p class="text-xl font-semibold opacity-90">#E-INV-{{ str_pad($event->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm mt-3">{{ now()->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-10 pb-6 border-b-2 border-gray-100 grid grid-cols-2 gap-10">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Bill To</h3>
                <p class="text-2xl font-semibold text-gray-900 mb-1">{{ $event->customer_name }}</p>
                <p class="text-gray-600">{{ $event->customer_email }}</p>
                <p class="text-gray-600">{{ $event->customer_phone }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Event Info</h3>
                <p class="text-xl font-semibold text-gray-900 mb-1">{{ $event->event_type }}</p>
                <p class="text-gray-600">{{ $event->event_date->format('M d, Y') }}</p>
                <p class="text-gray-600">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
            </div>
        </div>

        <table class="w-full mb-10">
            <thead>
                <tr class="border-b-2 border-gray-200 text-left">
                    <th class="py-4 text-xs font-bold text-gray-500 uppercase">Description</th>
                    <th class="py-4 text-center text-xs font-bold text-gray-500 uppercase">Guests</th>
                    <th class="py-4 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr>
                    <td class="py-8">
                        <p class="font-semibold text-xl text-gray-900 mb-1">Villa Garden Rental</p>
                        <p class="text-gray-500">{{ $event->event_type }} Package</p>
                        @if($event->message)
                            <p class="text-xs text-gray-400 mt-2 italic max-w-sm">{{ $event->message }}</p>
                        @endif
                    </td>
                    <td class="py-8 text-center text-lg font-medium text-gray-700">
                        {{ $event->guests }}
                    </td>
                    <td class="py-8 text-right font-bold text-xl text-gray-900">
                        LKR {{ number_format($event->total_price ?? 0, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end mb-12">
            <div class="w-80 space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span class="font-semibold">LKR {{ number_format($event->total_price ?? 0, 2) }}</span>
                </div>
                @if($event->discount_amount > 0)
                <div class="flex justify-between text-emerald-600 font-medium">
                    <span>Discount ({{ number_format($event->discount_percentage, 0) }}%)</span>
                    <span>- LKR {{ number_format($event->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-gray-600">
                    <span>Tax (0%)</span>
                    <span class="font-semibold">LKR 0.00</span>
                </div>
                <div class="total-highlight mt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold">Total Payable</span>
                        <span class="text-3xl font-extrabold">LKR {{ number_format($event->final_price ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($content['signature_path'] ?? null)
        <div class="flex justify-end mt-12 pb-12">
            <div class="text-center">
                <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" class="h-16 mx-auto mb-2">
                <div class="w-48 border-t-2 border-gray-300 pt-2">
                    <p class="text-[10px] font-bold text-gray-500 uppercase">Manager Signature</p>
                </div>
            </div>
        </div>
        @endif

        <div class="text-center text-sm text-gray-400 pt-8 border-t border-gray-100">
            <p class="font-display text-xl italic mb-2 text-gray-700">"Celebrate your special moments with us."</p>
            <p>Rose Villa Heritage Homes & Events</p>
        </div>
    </div>
</body>
</html>
