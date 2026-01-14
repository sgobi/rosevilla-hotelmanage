<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sales Reports
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Daily -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-blue-500 p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Today's Sales</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">LKR {{ number_format($today, 2) }}</div>
                </div>

                <!-- Weekly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-green-500 p-6 relative group">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Week</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">LKR {{ number_format($week, 2) }}</div>
                            <div class="text-xs text-gray-400 mt-1">Mon - Sun</div>
                        </div>
                        <a href="{{ route('admin.reports.print', ['period' => 'week']) }}" target="_blank" class="text-gray-400 hover:text-gray-600 print-btn" title="Print Weekly Report">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Monthly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-purple-500 p-6 relative group">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Month</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">LKR {{ number_format($month, 2) }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</div>
                        </div>
                        <a href="{{ route('admin.reports.print', ['period' => 'month']) }}" target="_blank" class="text-gray-400 hover:text-gray-600 print-btn" title="Print Monthly Report">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Yearly -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-l-4 border-amber-500 p-6 relative group">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Year</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">LKR {{ number_format($year, 2) }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ now()->format('Y') }}</div>
                        </div>
                        <a href="{{ route('admin.reports.print', ['period' => 'year']) }}" target="_blank" class="text-gray-400 hover:text-gray-600 print-btn" title="Print Yearly Report">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Custom Report Form -->
            <div class="bg-white px-6 py-4 rounded-xl shadow-sm border border-gray-100 flex items-end gap-4">
                <div>
                   <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date</label> 
                   <input type="date" form="custom-report" name="start_date" required class="border-gray-200 rounded-md text-sm focus:ring-rose-gold focus:border-rose-gold">
                </div>
                <div>
                   <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">End Date</label> 
                   <input type="date" form="custom-report" name="end_date" required class="border-gray-200 rounded-md text-sm focus:ring-rose-gold focus:border-rose-gold">
                </div>
                <form id="custom-report" action="{{ route('admin.reports.print') }}" method="GET" target="_blank">
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-xs uppercase tracking-wider font-semibold hover:bg-gray-700 transition">
                        Print Custom Report
                    </button>
                </form>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Approved Sales</h3>
                    <a href="{{ route('admin.reservations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Guest</th>
                                <th class="px-6 py-3">Room</th>
                                <th class="px-6 py-3 text-right">Amount</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentSales as $sale)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $sale->created_at->format('M d, H:i') }}</td>
                                    <td class="px-6 py-3">
                                        <div class="font-medium text-gray-900">{{ $sale->guest_name }}</div>
                                        <div class="text-xs text-gray-500">#{{ $sale->id }}</div>
                                    </td>
                                    <td class="px-6 py-3">{{ $sale->room->title ?? '-' }}</td>
                                    <td class="px-6 py-3 text-right font-medium text-green-600">
                                        LKR {{ number_format($sale->total_price, 2) }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <a href="{{ route('admin.invoices.show', $sale) }}" target="_blank" class="text-gray-400 hover:text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 001.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No approved sales to report yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
