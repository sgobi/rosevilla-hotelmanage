<nav x-data="{ open: false }" class="bg-[#111111] border-b border-white/5 sticky top-0 z-50 shadow-2xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex h-20 items-center justify-between">
            
            <!-- Left Side: Logo & Main Nav -->
            <div class="flex items-center gap-8">
                <!-- Logo Area -->
                <div class="shrink-0 flex items-center border-r border-white/10 pr-8 mr-2">
                    <a href="{{ route('dashboard') }}" class="transition-transform duration-300 hover:scale-105 active:scale-95">
                        <x-application-logo class="block h-10 w-auto drop-shadow-[0_2px_10px_rgba(255,255,255,0.15)]" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-1 xl:flex items-center">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-black' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-4 h-4 transition-colors group-hover:text-rose-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-[10px] uppercase font-black tracking-[0.15em] whitespace-nowrap">{{ __('Dashboard') }}</span>
                    </x-nav-link>

                    <!-- Bookings Dropdown -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <div class="relative">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border-none text-[10px] font-black uppercase tracking-[0.15em] rounded-lg transition-all duration-300 gap-2 whitespace-nowrap {{ request()->routeIs('admin.reservations.*', 'admin.events.*', 'admin.reviews.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/></svg>
                                    <span>Bookings</span>
                                    <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="bg-white rounded-xl shadow-2xl py-2 overflow-hidden border border-gray-100">
                                    <x-dropdown-link :href="route('admin.reservations.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50"><span class="mr-2 opacity-50">🏨</span> Room Reservations</x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.events.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50"><span class="mr-2 opacity-50">🎉</span> Event Bookings</x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.reviews.index')" class="text-[10px] font-black uppercase tracking-wider py-3 border-t border-gray-100 hover:bg-gray-50"><span class="mr-2 opacity-50">⭐</span> Guest Reviews</x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    <!-- Resources Dropdown -->
                    @if(auth()->user()->isAdmin())
                    <div class="relative">
                        <x-dropdown align="left" width="60">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border-none text-[10px] font-black uppercase tracking-[0.15em] rounded-lg transition-all duration-300 gap-2 whitespace-nowrap {{ request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>Resources</span>
                                    <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="bg-white rounded-xl shadow-2xl py-2 overflow-hidden border border-gray-100">
                                    <div class="px-5 py-2 text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-50/50 mb-1 leading-none pt-4 border-b pb-2">Property Assets</div>
                                    <x-dropdown-link :href="route('admin.rooms.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50">Room Listing</x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.gallery.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50">Infrastructure Gallery</x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.landmarks.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50">Nearby Landmarks</x-dropdown-link>
                                    
                                    <div class="px-5 py-2 text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-50/50 mb-1 leading-none pt-4 border-t border-b mt-2 pb-2">Website Tools</div>
                                    <x-dropdown-link :href="route('admin.content.edit')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50">General Content</x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.home-events.index')" class="text-[10px] font-black uppercase tracking-wider py-3 hover:bg-gray-50">Home Experience Cards</x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    <!-- Reports & Finance -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" 
                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 group {{ request()->routeIs('admin.reports.*') ? 'bg-white/10 text-white font-black' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 transition-colors group-hover:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em] whitespace-nowrap">{{ __('Finance') }}</span>
                        </x-nav-link>
                    @endif

                    <!-- User Management -->
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" 
                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 group {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white font-black' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 transition-colors group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em] whitespace-nowrap">{{ __('Team') }}</span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right Side: Actions & Profile -->
            <div class="hidden xl:flex items-center gap-6">
                <!-- VISIT LIVE SITE BUTTON -->
                <a href="{{ route('home') }}" target="_blank" 
                   class="px-6 py-3 text-[10px] font-black uppercase tracking-[0.25em] text-white bg-white/5 hover:bg-white/15 border border-white/10 rounded-xl transition-all duration-300 flex items-center gap-3 group whitespace-nowrap">
                    <div class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-gold opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-gold"></span>
                    </div>
                    LIVE SITE
                </a>

                <!-- User Interface Card -->
                <div class="h-10 w-px bg-white/10 mx-1"></div>

                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-4 py-1.5 px-2 rounded-xl bg-white/5 border border-white/5 hover:border-white/15 hover:bg-white/10 transition-all duration-300 group">
                            <div class="relative">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-lg object-cover shadow-2xl ring-2 ring-white/5 group-hover:ring-rose-accent transition-all duration-500">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-rose-accent/20 border border-rose-accent/30 flex items-center justify-center text-rose-accent font-black text-sm uppercase">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-green-500 rounded-full border-2 border-[#111111]"></div>
                            </div>
                            <div class="text-left hidden 2xl:block truncate max-w-[120px]">
                                <p class="text-[11px] font-black text-white leading-none uppercase tracking-widest truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[8px] text-gray-500 font-black uppercase tracking-[0.2em] mt-1.5 italic">{{ Auth::user()->role }} Account</p>
                            </div>
                            <svg class="h-4 w-4 text-gray-600 transition-transform group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white rounded-2xl shadow-[0_25px_70px_rgba(0,0,0,0.35)] border border-gray-100 overflow-hidden">
                            <div class="px-6 py-6 bg-gray-50/80 border-b border-gray-100 flex items-center gap-4">
                                 <div class="shrink-0">
                                    @if(Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="h-12 w-12 rounded-xl object-cover shadow-lg border-2 border-white">
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-rose-accent text-[#111111] flex items-center justify-center font-black text-lg shadow-lg border-2 border-white uppercase">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                    @endif
                                 </div>
                                 <div class="overflow-hidden">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] leading-none mb-1.5">Connected session</p>
                                    <p class="text-[11px] font-black text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                 </div>
                            </div>
                            
                            <div class="p-3 space-y-1">
                                <x-dropdown-link :href="route('profile.edit')" class="text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl flex items-center gap-3 hover:bg-rose-50 hover:text-rose-accent transition-all">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Account Settings
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl text-red-600 hover:bg-red-50 flex items-center gap-3 transition-all" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Log Out System
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="xl:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3.5 rounded-xl text-white/60 hover:text-white hover:bg-white/10 transition-all border border-white/5 active:scale-90">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden xl:hidden bg-[#161616] border-t border-white/5 pb-16 animate-fade-in-down">
        <div class="pt-8 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white font-black text-xs uppercase tracking-[0.2em] px-10 py-5 border-none hover:bg-white/5">DASHBOARD</x-responsive-nav-link>
            
            <!-- Mobile Section: Operations -->
            <div class="px-10 mt-10 mb-5 flex items-center gap-4">
                <span class="text-[9px] font-black text-rose-accent uppercase tracking-[0.4em] whitespace-nowrap">OPERATIONS</span>
                <span class="h-px w-full bg-white/5"></span>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <x-responsive-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Reservations</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Event Bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Guest Feedback</x-responsive-nav-link>
            @endif

            <!-- Mobile Section: Management -->
            @if(auth()->user()->isAdmin())
                <div class="px-10 mt-12 mb-5 flex items-center gap-4">
                    <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.4em] whitespace-nowrap">MANAGEMENT</span>
                    <span class="h-px w-full bg-white/5"></span>
                </div>
                <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Rooms Manager</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Gallery Vault</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.landmarks.index')" :active="request()->routeIs('admin.landmarks.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Nearby Landmarks</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.content.edit')" :active="request()->routeIs('admin.content.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">General CMS</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.home-events.index')" :active="request()->routeIs('admin.home-events.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Experience Cards</x-responsive-nav-link>
            @endif

            <!-- Mobile Section: Systems -->
            @if(auth()->user()->isAdmin())
                <div class="px-10 mt-12 mb-5 flex items-center gap-4">
                    <span class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] whitespace-nowrap">SYSTEMS</span>
                    <span class="h-px w-full bg-white/5"></span>
                </div>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Team Personnel</x-responsive-nav-link>
            @endif
        </div>

        <!-- User Signature Panel -->
        <div class="mt-16 mx-10 p-10 bg-white shadow-2xl rounded-[2.5rem] border border-gray-100 flex flex-col items-center text-center">
            <div class="relative mb-6">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="h-20 w-20 rounded-[1.5rem] object-cover shadow-2xl border-4 border-white">
                @else
                    <div class="h-20 w-20 rounded-[1.5rem] bg-rose-accent text-[#111111] flex items-center justify-center font-black text-3xl shadow-2xl border-4 border-white uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="absolute -bottom-1 -right-1 h-6 w-6 bg-green-500 rounded-full border-[6px] border-white shadow-lg"></div>
            </div>
            
            <div class="font-black text-gray-900 uppercase tracking-[0.1em] text-xl mb-1">{{ Auth::user()->name }}</div>
            <p class="text-[10px] font-black text-rose-accent uppercase tracking-[0.4em] italic">{{ Auth::user()->role }} PROFILE</p>
            
            <div class="h-px w-10 bg-gray-100 my-8"></div>
            
            <div class="grid grid-cols-1 w-full gap-4">
                <a href="{{ route('home') }}" target="_blank" class="w-full py-4 px-4 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.4em] shadow-xl hover:bg-black transition-all active:scale-95">VISIT SITE</a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-4 px-4 bg-rose-50 text-rose-accent border border-rose-100 rounded-2xl text-[10px] font-black uppercase tracking-[0.4em] active:scale-95 transition-all">SIGN OUT</button>
                </form>
            </div>
        </div>
    </div>
</nav>
