<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transition hover:opacity-80">
                        <x-application-logo class="block h-10 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-2 lg:flex items-center">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2 group">
                        <svg class="w-4 h-4 transition group-hover:text-rose-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="font-semibold tracking-wide">{{ __('DASHBOARD') }}</span>
                    </x-nav-link>

                    <!-- Bookings Dropdown -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <div class="relative pt-1">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold uppercase tracking-widest text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2 {{ request()->routeIs('admin.reservations.*', 'admin.events.*', 'admin.reviews.*', 'admin.events-calendar') ? 'text-rose-accent border-b-2 border-rose-accent' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"/></svg>
                                    <span>Bookings</span>
                                    <svg class="ml-1 w-3 h-3 transition-transform group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.reservations.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">🏨</span> Room Reservations</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.events.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">🎉</span> Event Bookings</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.events.calendar')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">📅</span> Event Calendar</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.reviews.index')" class="text-xs font-bold uppercase tracking-wider py-3 group flex items-center"><span class="mr-2 opacity-50">⭐</span> Guest Reviews</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    <!-- Property Dropdown -->
                    @if(auth()->user()->isAdmin())
                    <div class="relative pt-1">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold uppercase tracking-widest text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2 {{ request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*') ? 'text-rose-accent border-b-2 border-rose-accent' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span>Property</span>
                                    <svg class="ml-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.rooms.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">🛏️</span> Rooms & Suites</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.gallery.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">📸</span> gallery Listing</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.landmarks.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">📍</span> Nearby Visits</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    <!-- Website Dropdown -->
                    @if(auth()->user()->isAdmin())
                    <div class="relative pt-1">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-bold uppercase tracking-widest text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2 {{ request()->routeIs('admin.content.*', 'admin.home-events.*') ? 'text-rose-accent border-b-2 border-rose-accent' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                    <span>Website</span>
                                    <svg class="ml-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.content.edit')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">⚙️</span> Page Contents</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.home-events.index')" class="text-xs font-bold uppercase tracking-wider py-3"><span class="mr-2 opacity-50">✨</span> homepage Cards</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    <!-- Finance & Users -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:text-rose-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span class="font-bold tracking-widest">{{ __('REPORTS') }}</span>
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:text-rose-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="font-bold tracking-widest">{{ __('TEAM') }}</span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Profile & Public Link (Desktop) -->
            <div class="hidden lg:flex items-center gap-6">
                <!-- Public Link -->
                <a href="{{ route('home') }}" target="_blank" class="px-5 py-2 text-xs font-black uppercase tracking-widest text-[#7d4281] bg-purple-50 rounded-full hover:bg-[#7d4281] hover:text-white transition-all duration-300 shadow-sm border border-purple-100 flex items-center gap-2 group">
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Visit Site
                </a>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 p-1 rounded-full border border-gray-50 hover:bg-gray-50 transition-all group">
                            <div class="relative">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-11 w-11 rounded-full object-cover shadow-md ring-2 ring-white group-hover:ring-rose-accent transition-all">
                                @else
                                    <div class="h-11 w-11 rounded-full bg-[#7d4281] flex items-center justify-center text-white font-black text-sm shadow-md ring-2 ring-white group-hover:ring-rose-accent transition-all uppercase">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-0.5 -right-0.5 h-4 w-4 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                            </div>
                            <div class="text-left hidden xl:block pr-2">
                                <p class="text-xs font-black text-gray-900 leading-tight uppercase tracking-wide">{{ Auth::user()->name }}</p>
                                <div class="flex items-center gap-1 mt-0.5">
                                    <span class="inline-block w-2 h-2 rounded-full bg-rose-accent opacity-50"></span>
                                    <p class="text-[9px] text-gray-500 font-black uppercase tracking-widest italic">{{ Auth::user()->role }}</p>
                                </div>
                            </div>
                            <svg class="h-4 w-4 text-gray-300 transition-colors group-hover:text-rose-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 bg-gray-50/50 border-b border-gray-100 flex items-center gap-3">
                             <div class="shrink-0">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-[#7d4281] text-white flex items-center justify-center font-bold text-xs uppercase">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                @endif
                             </div>
                             <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter leading-none">Logged in as</p>
                                <p class="text-xs font-bold text-gray-800">{{ Auth::user()->email }}</p>
                             </div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs font-bold uppercase tracking-widest py-3 flex items-center gap-2 hover:bg-rose-50 hover:text-rose-accent">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-xs font-bold uppercase tracking-widest py-3 text-red-600 flex items-center gap-2 hover:bg-red-50" onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-gray-500 hover:text-rose-accent hover:bg-rose-50 transition duration-300 focus:outline-none ring-1 ring-gray-100 shadow-sm border border-transparent active:scale-95">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white border-t border-gray-50 animate-fade-in-down pb-10">
        <div class="pt-4 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-xs font-black uppercase tracking-widest hover:pl-6 transition-all duration-300">Dashboard</x-responsive-nav-link>
            
            <div class="px-6 py-4 text-[10px] font-black text-rose-accent uppercase tracking-[0.3em] mt-2 border-l-4 border-rose-accent ml-4 bg-rose-50/30">Management</div>
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                <x-responsive-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Room Reservations</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Event Bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Guest Reviews</x-responsive-nav-link>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="px-6 py-4 text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mt-4 border-l-4 border-indigo-400 ml-4 bg-indigo-50/30">Property Assets</div>
                <x-responsive-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Rooms & Suites</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Gallery Images</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.landmarks.index')" :active="request()->routeIs('admin.landmarks.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Nearby Visits</x-responsive-nav-link>
                
                <div class="px-6 py-4 text-[10px] font-black text-amber-500 uppercase tracking-[0.3em] mt-4 border-l-4 border-amber-500 ml-4 bg-amber-50/30">Website & SEO</div>
                <x-responsive-nav-link :href="route('admin.content.edit')" :active="request()->routeIs('admin.content.*')" class="text-xs font-bold uppercase tracking-wider pl-10">General Content</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.home-events.index')" :active="request()->routeIs('admin.home-events.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Homepage Cards</x-responsive-nav-link>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
                <div class="px-6 py-4 text-[10px] font-black text-green-500 uppercase tracking-[0.3em] mt-4 border-l-4 border-green-500 ml-4 bg-green-50/30">Finance & Data</div>
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="text-xs font-bold uppercase tracking-wider pl-10">Sales Reports</x-responsive-nav-link>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mt-4 border-l-4 border-gray-400 ml-4 bg-gray-50/30">Administration</div>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-xs font-bold uppercase tracking-wider pl-10">User Management</x-responsive-nav-link>
            @endif
        </div>

        <!-- Mobile User Info -->
        <div class="mt-8 mx-4 p-6 bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 active:scale-[0.98]">
            <div class="flex items-center gap-4">
                <div class="shrink-0">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="h-14 w-14 rounded-2xl object-cover shadow-md ring-4 ring-white">
                    @else
                        <div class="h-14 w-14 rounded-2xl bg-[#7d4281] flex items-center justify-center text-white font-black text-xl shadow-md ring-4 ring-white uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-black text-gray-900 uppercase tracking-wide leading-none select-none">{{ Auth::user()->name }}</div>
                    <p class="text-[10px] font-black text-rose-accent uppercase tracking-widest mt-1.5 italic select-none">{{ Auth::user()->role }} Access Granted</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-3">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center gap-2 py-3 px-4 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-600 active:bg-gray-50 shadow-sm transition-all">
                   <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> 
                   Profile
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 py-3 px-4 bg-purple-50 rounded-xl text-[10px] font-black uppercase tracking-widest text-[#7d4281] shadow-sm border border-purple-100 active:bg-purple-100 transition-all">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                   Live Site
                </a>
                <form method="POST" action="{{ route('logout') }}" class="col-span-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 px-4 bg-red-50 text-red-600 rounded-xl text-[11px] font-black uppercase tracking-[0.2em] shadow-sm border border-red-100 active:bg-red-100 transition-all mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Safe Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
