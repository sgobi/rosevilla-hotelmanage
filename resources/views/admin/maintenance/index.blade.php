<x-app-layout>
    <div class="px-8 py-10 space-y-10">
        <!-- Maintenance Header -->
        <div class="flex items-end justify-between border-b border-slate-100 pb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">System Maintenance</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Core administrative tools and data management.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Data Management Card -->
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                <div class="p-8 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
                    <div class="h-12 w-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest">Wipe System Data</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-tight">Total reset of bookings and inquiries</p>
                    </div>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-700 font-medium">
                                    This action will permanently delete all **Room Reservations**, **Garden Bookings**, and **Event Records**. This cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.maintenance.wipe-all') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Confirm Admin Password</label>
                            <input type="password" name="password" required
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-all">
                        </div>
                        <button type="submit" 
                                onclick="return confirm('CRITICAL ACTION: Are you absolutely sure you want to delete EVERY transactional record in the system?')"
                                class="w-full py-4 bg-rose-600 text-white rounded-xl text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition-all active:scale-95">
                            Wipe Entire System
                        </button>
                    </form>
                </div>
            </div>

            <!-- Coming Soon Features -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col p-8 items-center justify-center border-dashed text-slate-400 space-y-4">
                <div class="h-20 w-20 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <div class="text-center">
                    <p class="font-black uppercase tracking-widest text-sm text-slate-900">Advanced Settings</p>
                    <p class="text-xs font-medium italic mt-1">Additional maintenance tools coming soon.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
