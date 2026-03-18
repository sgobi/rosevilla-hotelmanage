<header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-30 flex items-center justify-between px-6 shrink-0 shadow-sm" x-data="{ mobileOpen: false }">
    <!-- Left: Mobile Menu Trigger & Global Search -->
    <div class="flex items-center gap-4 flex-1 max-w-xl">
        <button @click="$dispatch('open-mobile-menu')" class="lg:hidden p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div class="hidden sm:flex-1 sm:block">
            <form action="{{ route('admin.reservations.index') }}" method="GET">
                <label for="search" class="sr-only">Search everything</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="block w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl leading-5 text-sm placeholder-slate-400 focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all duration-300" 
                           placeholder="Search bookings, rooms, clients...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-[10px] font-mono font-bold text-slate-400 opacity-60">
                        <span class="px-1.5 py-0.5 bg-white border border-slate-200 rounded shadow-sm">⌘K</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right: Account & Notifications -->
    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
            <button @click="open = !open" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors relative">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if($unreadCount > 0)
                    <span class="absolute top-1.5 right-1.5 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
                @endif
            </button>
            <div x-show="open" @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl py-4 z-50 overflow-hidden" x-cloak>
                <div class="px-6 pb-2 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 py-3">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Notifications</h3>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.markRead') }}" method="POST">
                            @csrf
                            <button class="text-[10px] text-indigo-600 hover:text-indigo-800 font-bold uppercase tracking-tighter">Mark all read</button>
                        </form>
                    @endif
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ route('notifications.read', $notification->id) }}" class="block px-6 py-4 hover:bg-slate-50 border-b border-slate-50 transition-colors">
                            <div class="flex gap-3">
                                <div class="shrink-0 mt-1">
                                    <span class="h-2 w-2 rounded-full bg-indigo-500 inline-block"></span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-700 leading-snug">{{ $notification->data['message'] ?? 'Notification' }}</p>
                                    <p class="text-[10px] text-slate-400 mt-1 font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-10 text-center text-slate-400 italic text-sm">No new notifications</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-2 p-1 pl-3 rounded-full hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200 {{ Auth::user()->profile_photo_path ? '' : 'bg-slate-50' }}">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">{{ Auth::user()->role }}</p>
                </div>
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="h-8 w-8 rounded-full border border-slate-200 object-cover" />
                @else
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">{{ substr(Auth::user()->name, 0, 1) }}</div>
                @endif
                <svg class="w-4 h-4 text-slate-400 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-[1.25rem] shadow-xl py-2 z-50 overflow-hidden" x-cloak>
                <div class="px-4 py-2 border-b border-slate-100 mb-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Workspace</p>
                    <p class="text-xs font-bold text-slate-900 mt-1">Rose Villa Heritage</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    My Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
