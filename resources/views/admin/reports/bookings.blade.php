<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-900 leading-tight tracking-tight uppercase">Booking Status Terminal</h2>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mt-1 italic">Active, Pending & Cancelled Logic</p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.reports.index') }}" class="group bg-white/80 px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 group-hover:bg-gray-900 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Back to Intelligence</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filters & Search -->
            <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-4">
                <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-100">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" 
                       class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $status === 'all' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-400 hover:text-gray-900' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" 
                       class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-lg' : 'text-gray-400 hover:text-emerald-600' }}">
                        Active
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
                       class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-lg' : 'text-gray-400 hover:text-amber-500' }}">
                        Pending
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}" 
                       class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $status === 'cancelled' ? 'bg-rose-600 text-white shadow-lg' : 'text-gray-400 hover:text-rose-600' }}">
                        Cancelled
                    </a>
                </div>

                <div class="flex-1 w-full relative group">
                    <form action="{{ route('admin.reports.bookings') }}" method="GET">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Search display name, notes, or cancellation reason..." 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border-transparent rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all border-none">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white shadow-[0_20px_50px_-20px_rgba(0,0,0,0.05)] rounded-[2rem] border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ __('Booking Records & Notes') }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-0.5">Found {{ $bookings->total() }} matches</p>
                    </div>
                    
                    <button onclick="window.print()" class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition-all shadow-lg active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Export Report
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold">
                            <tr>
                                <th class="px-6 py-4">Client & Details</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Booking Dates</th>
                                <th class="px-6 py-4">Operational Notes</th>
                                <th class="px-6 py-4">Special Requests</th>
                                <th class="px-6 py-4 text-rose-600">Cancellation Logic</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-xs {{ $booking->type === 'Room' ? 'bg-indigo-50 text-indigo-600' : 'bg-rose-50 text-rose-600' }}">
                                                {{ substr($booking->type, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-black text-gray-900 leading-none">{{ $booking->display_name }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter mt-1">{{ $booking->type }}: {{ $booking->details }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                            {{ $booking->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : 
                                               ($booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600') }}">
                                            <span class="w-1 h-1 rounded-full mr-1.5 
                                                {{ $booking->status === 'approved' ? 'bg-emerald-400' : 
                                                   ($booking->status === 'pending' ? 'bg-amber-400' : 'bg-rose-400') }}"></span>
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-[10px] font-black text-gray-600">{{ $booking->date }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($booking->notes)
                                            <p class="text-xs text-gray-600 line-clamp-2 italic leading-relaxed">"{{ $booking->notes }}"</p>
                                        @else
                                            <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">No Notes</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($booking->special)
                                            <p class="text-xs text-indigo-600 font-medium leading-relaxed">{{ $booking->special }}</p>
                                        @else
                                            <span class="text-[10px] text-gray-300">---</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($booking->status === 'cancelled')
                                            <div class="bg-rose-50 p-3 rounded-xl border border-rose-100">
                                                <p class="text-[10px] text-rose-600 font-bold leading-tight">{{ $booking->cancellation_reason ?? 'No reason provided.' }}</p>
                                            </div>
                                        @else
                                            <span class="text-[10px] text-gray-200">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-gray-400 font-medium tracking-tight">No records found matching these criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                    {{ $bookings->links() }}
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .bg-white { box-shadow: none !important; border: none !important; }
            .rounded-\[2rem\] { border-radius: 0 !important; }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl, .shadow-2xl { box-shadow: none !important; }
        }
    </style>
</x-app-layout>
