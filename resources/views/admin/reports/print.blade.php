<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Rose Villa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8 font-sans text-gray-900">
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center border-b-2 border-gray-800 pb-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold uppercase tracking-wider">Rose Villa Heritage Homes</h1>
                <h2 class="text-lg text-gray-600 mt-1">{{ $title }}</h2>
            </div>
            <div class="text-right text-sm">
                <p>Printed on: {{ now()->format('M d, Y H:i') }}</p>
                <button onclick="window.print()" class="no-print bg-gray-800 text-white px-4 py-2 rounded text-xs uppercase tracking-wider hover:bg-gray-700 mt-2">Print Report</button>
            </div>
        </div>

        <!-- Sales Table -->
        <table class="w-full text-sm text-left mb-8">
            <thead>
                <tr class="border-b border-gray-300 uppercase text-xs text-gray-500">
                    <th class="py-2">Date</th>
                    <th class="py-2">Type</th>
                    <th class="py-2">Client / ID</th>
                    <th class="py-2">Description</th>
                    <th class="py-2 text-right">Gross (LKR)</th>
                    <th class="py-2 text-right text-emerald-700">Discount</th>
                    <th class="py-2 text-right text-rose-700">Tax</th>
                    <th class="py-2 text-right">Net Revenue (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr class="border-b border-gray-100 italic">
                        <td class="py-3">{{ $sale->created_at->format('M d, Y') }}</td>
                        <td class="py-3 font-bold text-[10px] uppercase">
                            <span class="{{ $sale->report_type === 'Room' ? 'text-blue-600' : 'text-purple-600' }}">
                                {{ $sale->report_type }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="font-medium">{{ $sale->report_name }}</div>
                            <div class="text-[10px] text-gray-400">#{{ $sale->id }}</div>
                        </td>
                        <td class="py-3 italic">{{ $sale->report_desc }}</td>
                        <td class="py-3 text-right">
                            {{ number_format($sale->total_price, 2) }}
                        </td>
                        <td class="py-3 text-right text-emerald-700">
                            -{{ number_format($sale->report_discount, 2) }}
                        </td>
                        <td class="py-3 text-right text-rose-700">
                            +{{ number_format($sale->tax_amount, 2) }}
                        </td>
                        <td class="py-3 text-right font-bold">
                            {{ number_format($sale->final_price, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 italic">No sales found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-gray-400">
                    <td colspan="4" class="py-2 text-right pr-4 font-semibold">Total Gross Booking Value</td>
                    <td class="py-2 text-right font-semibold">LKR {{ number_format($totalSubtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="py-2 text-right pr-4 text-emerald-700 font-semibold">Total Discounts Given</td>
                    <td class="py-2 text-right text-emerald-700 font-semibold">- LKR {{ number_format($totalDiscount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="py-2 text-right pr-4 text-rose-700 font-semibold">Total Tax Collected</td>
                    <td class="py-2 text-right text-rose-700 font-semibold">+ LKR {{ number_format($totalTax, 2) }}</td>
                </tr>
                <tr class="border-t-4 border-double border-gray-800 font-bold text-xl bg-gray-50">
                    <td colspan="4" class="py-4 text-right pr-4 uppercase tracking-wider">Net Sales Revenue</td>
                    <td class="py-4 text-right">LKR {{ number_format($totalNet, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-12 pt-4 border-t border-gray-100">
            <p>Rose Villa Heritage Homes - Internal Sales Document</p>
        </div>
    </div>

    <script>
        // Auto-print when loaded
        window.onload = function() {
            // window.print(); // Optional: uncomment if auto-print is desired
        }
    </script>
</body>
</html>
