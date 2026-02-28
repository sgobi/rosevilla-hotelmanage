<nav x-data="{ open: false }" class="bg-[#0a0a0a]/95 backdrop-blur-3xl border-b border-white/5 sticky top-0 z-50 shadow-[0_10px_40px_rgba(0,0,0,0.5)]" style="transform: translateZ(0); -webkit-font-smoothing: antialiased;">
    <!-- Top Accent Line -->
    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-rose-gold/30 to-transparent"></div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-[1700px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex h-24 items-center justify-between">
            
            <!-- Left Side: Logo & Main Nav -->
            <div class="flex items-center gap-4 lg:gap-8">
                <!-- Logo Area -->
                <div class="shrink-0 flex items-center pr-4 md:pr-6">
                    <a href="{{ route('dashboard') }}" class="transition-all duration-700 hover:scale-105 active:scale-95 group flex items-center">
                        <x-application-logo class="h-9 w-auto filter drop-shadow-[0_0_20px_rgba(179,142,93,0.3)] group-hover:drop-shadow-[0_0_30px_rgba(179,142,93,0.5)] transition-all duration-700" />
                        

                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-1 md:flex items-center">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="relative flex items-center gap-2 px-3 py-2.5 rounded-2xl transition-all duration-700 group {{ request()->routeIs('dashboard') ? 'bg-white/5 text-white border border-white/10 shadow-[0_0_30px_rgba(255,255,255,0.05)]' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <svg class="w-4 h-4 relative z-10 transition-all duration-700 {{ request()->routeIs('dashboard') ? 'text-rose-gold scale-110 drop-shadow-[0_0_8px_rgba(217,179,108,0.4)]' : 'text-gray-400 group-hover:text-rose-gold group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-[10px] uppercase font-black tracking-[0.2em] whitespace-nowrap relative z-10">{{ __('Dashboard') }}</span>
                        @if(request()->routeIs('dashboard'))
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-rose-gold rounded-full shadow-[0_0_10px_rgba(217,179,108,0.8)]"></div>
                        @endif
                    </x-nav-link>

                    <!-- Bookings Dropdown -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" 
                            class="inline-flex items-center px-3 py-2.5 border border-transparent text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all duration-700 gap-2 whitespace-nowrap {{ request()->routeIs('admin.reservations.*', 'admin.events.*', 'admin.reviews.*') ? 'bg-white/5 text-white border-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.reservations.*', 'admin.events.*', 'admin.reviews.*') ? 'text-rose-gold scale-110 drop-shadow-[0_0_8px_rgba(217,179,108,0.4)]' : 'text-gray-400 group-hover:text-rose-gold' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/></svg>
                            <span>Bookings</span>
                            <svg class="w-3 h-3 text-gray-500 transition-transform duration-500 group-hover:translate-y-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute left-0 mt-3 w-80 bg-[#0d0d0d]/95 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.7)] border border-white/5 py-6 overflow-hidden z-50">
                            
                            <div class="px-8 py-3 text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] mb-3 leading-none border-b border-white/5 pb-4">Operational Core</div>
                            <x-dropdown-link :href="route('admin.front-desk.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/5 hover:text-rose-gold transition-all duration-500 flex items-center gap-4 px-8 group/item">
                                <div class="h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,0.6)] group-hover/item:scale-125 transition-transform duration-500"></div>
                                <span class="text-gray-300 group-hover/item:text-white">Room Front Desk</span>
                            </x-dropdown-link>
                         

                            <x-dropdown-link :href="route('admin.event-front-desk.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/5 hover:text-rose-gold transition-all duration-500 flex items-center gap-4 px-8 group/item">
                                <div class="h-2 w-2 rounded-full bg-rose-gold shadow-[0_0_15px_rgba(217,179,108,0.6)] group-hover/item:scale-125 transition-transform duration-500"></div>
                                <span class="text-gray-300 group-hover/item:text-white">Event Front Desk</span>
                            </x-dropdown-link>
                          
                            
                            <div class="h-[1px] w-full bg-white/5 my-4"></div>
                            
                            <x-dropdown-link :href="route('admin.reservations.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-400">View Room Stays</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.events.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-400">View Event Bookings</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.reviews.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-400">Guest Experience</x-dropdown-link>
                        </div>
                    </div>
                    @endif

                    <!-- Resources Dropdown -->
                    @if(auth()->user()->isAdmin())
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" 
                            class="inline-flex items-center px-3 py-2.5 border border-transparent text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all duration-700 gap-2 whitespace-nowrap {{ request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*') ? 'bg-white/5 text-white border-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*', 'admin.content.*', 'admin.home-events.*') ? 'text-rose-gold scale-110 drop-shadow-[0_0_8px_rgba(217,179,108,0.4)]' : 'text-gray-400 group-hover:text-rose-gold' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Property</span>
                            <svg class="w-3 h-3 text-gray-500 transition-transform duration-500 group-hover:translate-y-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute left-0 mt-3 w-80 bg-[#0d0d0d]/95 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.7)] border border-white/5 py-6 overflow-hidden z-50">
                            
                            <div class="px-8 py-3 text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] mb-3 leading-none border-b border-white/5 pb-4">Infrastructure</div>
                            <x-dropdown-link :href="route('admin.rooms.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-300">Room Listing</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.gallery.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-300">Resort Gallery</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.landmarks.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-300">Local Landmarks</x-dropdown-link>
                            
                            <div class="px-8 py-3 text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] mb-3 leading-none border-t border-b border-white/5 mt-4 pb-4 pt-6">Brand & Content</div>
                            <x-dropdown-link :href="route('admin.content.edit')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-400">Identity & SEO</x-dropdown-link>
                            <x-dropdown-link :href="route('admin.home-events.index')" class="text-[11px] font-black uppercase tracking-wider py-4 hover:bg-white/10 hover:text-white transition-all duration-500 px-8 text-gray-400">Experience Cards</x-dropdown-link>
                        </div>
                    </div>
                    @endif

                    <!-- Reports & Finance -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" 
                            class="relative flex items-center gap-2 px-3 py-2.5 rounded-2xl transition-all duration-700 group {{ request()->routeIs('admin.reports.*') ? 'bg-white/5 text-white border border-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 transition-all duration-700 {{ request()->routeIs('admin.reports.*') ? 'text-amber-400 scale-110 drop-shadow-[0_0_8px_rgba(251,191,36,0.4)]' : 'text-gray-400 group-hover:text-amber-400 group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span class="text-[11px] font-black uppercase tracking-[0.2em] whitespace-nowrap">{{ __('Finance') }}</span>
                            @if(request()->routeIs('admin.reports.*'))
                                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-amber-400 rounded-full shadow-[0_0_10px_rgba(251,191,36,0.8)]"></div>
                            @endif
                        </x-nav-link>
                    @endif

                    <!-- User Management -->
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" 
                            class="relative flex items-center gap-2 px-3 py-2.5 rounded-2xl transition-all duration-700 group {{ request()->routeIs('admin.users.*') ? 'bg-white/5 text-white border border-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 transition-all duration-700 {{ request()->routeIs('admin.users.*') ? 'text-blue-400 scale-110 drop-shadow-[0_0_8px_rgba(96,165,250,0.4)]' : 'text-gray-400 group-hover:text-blue-400 group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="text-[11px] font-black uppercase tracking-[0.2em] whitespace-nowrap">{{ __('Team') }}</span>
                            @if(request()->routeIs('admin.users.*'))
                                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-[2px] bg-blue-400 rounded-full shadow-[0_0_10px_rgba(96,165,250,0.8)]"></div>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex items-center gap-2 lg:gap-4">
                <!-- VISIT LIVE SITE BUTTON -->
                <a href="{{ route('home') }}" target="_blank" 
                   class="relative overflow-hidden px-4 md:px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.2em] text-white rounded-2xl flex items-center gap-2 group transition-all duration-700 active:scale-95 shadow-[0_10px_30px_rgba(217,179,108,0.2)]">
                    <div class="absolute inset-0 bg-rose-gold transition-all duration-700 group-hover:scale-110"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent"></div>
                    
                    <div class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </div>
                    <span class="relative z-10 whitespace-nowrap uppercase">{{ __('Live Site') }}</span>
                    <svg class="w-3.5 h-3.5 relative z-10 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>



                <x-dropdown align="right" width="72">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 py-2 px-3 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 group transition-all duration-700 shadow-2xl h-[52px]">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-tr from-rose-gold/0 to-rose-gold/0 rounded-xl group-hover:from-rose-gold/20 group-hover:to-transparent transition-all duration-700"></div>
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-11 w-11 rounded-xl object-cover shadow-2xl ring-1 ring-white/10 group-hover:ring-rose-gold/50 transition-all duration-700 relative z-10">
                                @else
                                    <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-rose-accent/40 to-rose-accent/10 border border-rose-accent/30 flex items-center justify-center text-rose-accent font-black text-sm uppercase shadow-inner relative z-10">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-500 rounded-full border-[3px] border-[#0a0a0a] shadow-[0_0_10px_rgba(34,197,94,0.6)] z-20">
                                    <div class="w-full h-full rounded-full animate-pulse bg-green-400/50"></div>
                                </div>
                            </div>
                            <div class="text-left hidden 2xl:block truncate max-w-[160px]">
                                <p class="text-[12px] font-black text-white leading-none uppercase tracking-[0.15em] truncate drop-shadow-md">{{ Auth::user()->name }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="h-1 w-1 rounded-full bg-rose-gold"></div>
                                    <p class="text-[7.5px] text-gray-400 font-black uppercase tracking-[0.3em] leading-none">{{ Auth::user()->role }} Center</p>
                                </div>
                            </div>
                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-500 group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
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
            <div class="md:hidden">
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-[#161616] border-t border-white/5 pb-16 animate-fade-in-down">
        <div class="pt-8 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white font-black text-xs uppercase tracking-[0.2em] px-10 py-5 border-none hover:bg-white/5">DASHBOARD</x-responsive-nav-link>
            
            <!-- Mobile Section: Operations -->
            <div class="px-10 mt-10 mb-5 flex items-center gap-4">
                <span class="text-[9px] font-black text-rose-accent uppercase tracking-[0.4em] whitespace-nowrap">OPERATIONS</span>
                <span class="h-px w-full bg-white/5"></span>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <x-responsive-nav-link :href="route('admin.front-desk.index')" :active="request()->routeIs('admin.front-desk.*')" class="text-indigo-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-indigo-500 transition-colors py-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    Room Front Desk (Check In/Out)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.event-front-desk.index')" :active="request()->routeIs('admin.event-front-desk.*')" class="text-amber-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-amber-500 transition-colors py-4 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    Event Front Desk (Arrival/Compl.)
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Room Reservations</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Event Bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 hover:text-white transition-colors py-4">Guest Reviews</x-responsive-nav-link>
            @endif

            <!-- Mobile Section: Management -->
            @if(auth()->user()->isAdmin())
                <div class="px-10 mt-12 mb-5 flex items-center gap-4">
                    <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.4em] whitespace-nowrap">MANAGEMENT</span>
                    <span class="h-px w-full bg-white/5"></span>
                </div>
                <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Room Listing</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Infrastructure Gallery</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.landmarks.index')" :active="request()->routeIs('admin.landmarks.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Nearby Landmarks</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.content.edit')" :active="request()->routeIs('admin.content.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">General Content</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.home-events.index')" :active="request()->routeIs('admin.home-events.*')" class="text-gray-400 font-bold text-[11px] uppercase tracking-wider px-14 py-4">Home Experience Cards</x-responsive-nav-link>
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
