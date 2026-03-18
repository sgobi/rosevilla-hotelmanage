<x-app-layout>
    <div class="px-8 py-10 space-y-12 max-w-7xl mx-auto">
        <!-- Maintenance Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-10 border-b border-slate-100">
            <div>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-3 block">Security & Operations</span>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">System Maintenance</h1>
                <p class="text-sm text-slate-500 mt-2 font-medium max-w-xl leading-relaxed">Advanced tools for property data hygiene and core system management. Access is restricted to authorized administrative accounts only.</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-amber-50 rounded-full border border-amber-100">
                <div class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></div>
                <span class="text-[10px] font-black text-amber-900 uppercase tracking-widest leading-none">Admin Mode Active</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left: Main Operations -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Backup Card -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-xl shadow-slate-200/20 overflow-hidden group">
                    <div class="p-10 border-b border-slate-100 flex items-center justify-between bg-emerald-50/20">
                        <div class="flex items-center gap-6">
                            <div class="h-16 w-16 rounded-[1.25rem] bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase">Export Full Backup</h3>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Snapshot Generation</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.maintenance.backup') }}" 
                               class="px-8 py-4 bg-emerald-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all flex items-center gap-2">
                               <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                               Download SQLITE
                            </a>
                            <a href="{{ route('admin.maintenance.export-mysql') }}" 
                               class="px-8 py-4 bg-orange-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-orange-600/20 hover:bg-orange-700 transition-all flex items-center gap-2">
                               <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 13c-.77 1.333.192 3 1.732 3z"></path></svg>
                               Export to MYSQL
                            </a>
                        </div>
                    </div>
                    <div class="p-10">
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Highly recommended before any major system reset. This generates a complete downloadable image of your current database state including all reservations, rooms, and settings.</p>
                    </div>
                </div>

                <!-- Restore Card -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-xl shadow-slate-200/20 overflow-hidden group">
                    <div class="p-10 border-b border-slate-100 flex items-center gap-6 bg-indigo-50/20">
                        <div class="h-16 w-16 rounded-[1.25rem] bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase">Restore System State</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Version Reversion</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.maintenance.restore') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                        @csrf
                        <div class="p-8 border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50/50 hover:border-indigo-400 transition-all text-center">
                            <input type="file" name="backup_file" id="backup_file" class="hidden" accept=".sqlite">
                            <label for="backup_file" class="cursor-pointer">
                                <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-2">Upload Backup File</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Click to select a previously exported .sqlite file</p>
                            </label>
                        </div>

                        <div class="flex items-center gap-6 max-w-lg mx-auto">
                            <input type="password" name="password" placeholder="Admin Password" required
                                   class="flex-1 px-6 py-4 bg-white border border-slate-200 rounded-2xl text-center text-xs focus:bg-white focus:ring-1 focus:ring-indigo-600 transition-all font-bold">
                            <button type="submit" 
                                    onclick="return confirm('WARNING: This will OVERWRITE your current database. Recovery of lost current state will only be possible if you have a backup.')"
                                    class="shrink-0 px-10 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-black transition-all">
                                Perform Restore
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Wipe Card -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-xl shadow-slate-200/20 overflow-hidden group">
                    <div class="p-10 border-b border-slate-100 flex items-center gap-6 bg-rose-50/20">
                        <div class="h-16 w-16 rounded-[1.25rem] bg-rose-50 text-rose-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase">Wipe System Data</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Destructive Cleanup</p>
                        </div>
                    </div>
                    
                    <div class="p-10 space-y-10">
                        <div class="flex gap-4 p-6 bg-rose-50 rounded-2xl border border-rose-100/50">
                            <div class="shrink-0 mt-1">
                                <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center shadow-sm">
                                    <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-rose-900 uppercase tracking-widest mb-1">Critical Notice</h4>
                                <p class="text-sm text-rose-700/80 leading-relaxed font-medium">
                                    A backup will be created automatically before this action executes. Select target categories carefully. 
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('admin.maintenance.wipe-all') }}" method="POST" class="space-y-8">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Option: Room Reservations -->
                                <div class="p-1 bg-white rounded-3xl border border-slate-100 shadow-inner">
                                    <label class="flex flex-col gap-4 p-5 rounded-2xl hover:bg-slate-50 transition-all cursor-pointer group h-full text-center">
                                        <div class="flex items-center justify-center h-10 w-10 mx-auto rounded-xl bg-indigo-100 text-indigo-600">
                                            <input type="checkbox" name="include_rooms" value="1" class="peer hidden" checked>
                                            <svg class="w-5 h-5 peer-checked:text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Room Stays</p>
                                    </label>
                                </div>
                                <!-- Option: General Events -->
                                <div class="p-1 bg-white rounded-3xl border border-slate-100 shadow-inner text-center">
                                    <label class="flex flex-col gap-4 p-5 rounded-2xl hover:bg-slate-50 transition-all cursor-pointer h-full">
                                        <div class="flex items-center justify-center h-10 w-10 mx-auto rounded-xl bg-orange-100 text-orange-600">
                                            <input type="checkbox" name="include_events" value="1" class="peer hidden" checked>
                                            <svg class="w-5 h-5 peer-checked:text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Public Events</p>
                                    </label>
                                </div>
                                <!-- Option: Garden Bookings -->
                                <div class="p-1 bg-white rounded-3xl border border-slate-100 shadow-inner text-center">
                                    <label class="flex flex-col gap-4 p-5 rounded-2xl hover:bg-slate-50 transition-all cursor-pointer h-full">
                                        <div class="flex items-center justify-center h-10 w-10 mx-auto rounded-xl bg-emerald-100 text-emerald-600">
                                            <input type="checkbox" name="include_garden" value="1" class="peer hidden">
                                            <svg class="w-5 h-5 peer-checked:text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Nature Garden</p>
                                    </label>
                                </div>
                            </div>

                            <div class="max-w-md mx-auto space-y-6">
                                <input type="password" name="password" placeholder="Confirm Admin Password" required
                                       class="block w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-center text-xs focus:bg-white focus:border-rose-500/20 focus:ring-4 focus:ring-rose-500/5 transition-all shadow-inner font-bold">
                                <button type="submit" 
                                        onclick="return confirm('CRITICAL: ARE YOU SURE? System will auto-backup before clearing.')"
                                        class="w-full py-5 bg-rose-600 text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] shadow-xl shadow-rose-600/30 hover:bg-rose-700 hover:-translate-y-1 transition-all">
                                    Verify & Clear Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Info Panel -->
            <div class="space-y-8">
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-4">Protection Active</p>
                            <h4 class="text-xl font-black tracking-tight leading-tight uppercase">Security Defaults</h4>
                            <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium italic">Safety First: The system automatically triggers an immutable backup before every destructive operation.</p>
                        </div>
                        
                        <div class="pt-8 border-t border-slate-800 space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="h-8 w-8 rounded-lg bg-emerald-900/40 border border-emerald-800/50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Atomic Snapshots</p>
                            </div>
                            <div class="flex items-center gap-4 opacity-50">
                                <div class="h-8 w-8 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Cloud Sync (v2.5)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-[2.5rem] p-10 flex flex-col gap-6 shadow-inner">
                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Storage Location</h5>
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-900 uppercase">Engine</p>
                            <p class="text-[11px] text-slate-500 font-medium font-serif">SQLite v3.x</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
