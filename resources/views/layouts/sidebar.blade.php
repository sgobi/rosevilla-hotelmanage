<aside x-data="{ 
    expanded: false, 
    activeMenu: '{{ request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('admin.reservations.*', 'admin.front-desk.*', 'admin.events.*', 'admin.garden-bookings.*', 'admin.event-front-desk.*') ? 'bookings' : (request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*', 'admin.content.*', 'admin.home-events.*', 'admin.garden-profile.*') ? 'property' : (request()->routeIs('admin.reports.*') ? 'finance' : (request()->routeIs('admin.users.*') ? 'team' : '')))) }}'
}" 
    @mouseenter="expanded = true" 
    @mouseleave="expanded = false"
    class="hidden lg:flex flex-col bg-slate-900 h-screen sticky top-0 z-40 transition-all duration-300 ease-in-out group"
    :class="expanded ? 'w-64' : 'w-20'">
    
    <!-- Logo -->
    <div class="h-16 flex items-center bg-slate-950/50 shrink-0 overflow-hidden px-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-8 w-8 min-w-[2rem] filter brightness-0 invert" />
            <span x-show="expanded" x-transition:enter="transition opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="text-white font-bold tracking-tight text-lg whitespace-nowrap">Rose Villa</span>
        </a>
    </div>

    <!-- Nav Links -->
    <div class="flex-1 px-3 py-6 space-y-2 overflow-y-auto custom-scrollbar overflow-x-hidden">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Dashboard</span>
        </a>

        <!-- Price Calculator -->
        <a href="{{ route('admin.price-calculator.index') }}" 
           class="flex items-center gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.price-calculator.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Price Calculator</span>
        </a>

        <!-- Bookings -->
        @php
            $isBookingsActive = request()->routeIs('admin.reservations.*', 'admin.front-desk.*', 'admin.events.*', 'admin.garden-bookings.*', 'admin.event-front-desk.*');
        @endphp
        <div class="space-y-1">
            <button @click="activeMenu = activeMenu === 'bookings' ? '' : 'bookings'" 
               class="w-full flex items-center justify-between gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ $isBookingsActive ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <div class="flex items-center gap-4">
                    <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Bookings</span>
                </div>
                <svg x-show="expanded" class="w-4 h-4 transition-transform duration-200" :class="activeMenu === 'bookings' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="expanded && activeMenu === 'bookings'" x-collapse class="pl-12 pr-4 space-y-1">
                @php
                    $bookingLinks = [
                        ['label' => 'Room Front Desk', 'route' => 'admin.front-desk.index'],
                        ['label' => 'Event Front Desk', 'route' => 'admin.event-front-desk.index'],
                        ['label' => 'View Room Stays', 'route' => 'admin.reservations.index'],
                        ['label' => 'View Events', 'route' => 'admin.events.index'],
                        ['label' => 'Garden Bookings', 'route' => 'admin.garden-bookings.index'],
                        ['label' => 'Guest Experience', 'route' => 'admin.reviews.index'],
                    ];
                @endphp
                @foreach($bookingLinks as $link)
                    <a href="{{ route($link['route']) }}" class="block py-2 text-xs font-medium {{ request()->routeIs($link['route']) ? 'text-indigo-400' : 'text-slate-500 hover:text-slate-300' }} transition-colors whitespace-nowrap">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>


        <!-- Property Management -->
        @if(auth()->user()->isAdmin())
            @php
                $isPropertyActive = request()->routeIs('admin.rooms.*', 'admin.gallery.*', 'admin.landmarks.*', 'admin.content.*', 'admin.home-events.*', 'admin.garden-profile.*');
            @endphp
            <div class="space-y-1">
                <button @click="activeMenu = activeMenu === 'property' ? '' : 'property'" 
                   class="w-full flex items-center justify-between gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ $isPropertyActive ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <div class="flex items-center gap-4">
                        <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Property</span>
                    </div>
                    <svg x-show="expanded" class="w-4 h-4 transition-transform duration-200" :class="activeMenu === 'property' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="expanded && activeMenu === 'property'" x-collapse class="pl-12 pr-4 space-y-1">
                    @php
                        $propertyLinks = [
                            ['label' => 'Room Listing', 'route' => 'admin.rooms.index'],
                            ['label' => 'Garden Profile', 'route' => 'admin.garden-profile.edit'],
                            ['label' => 'Resort Gallery', 'route' => 'admin.gallery.index'],
                            ['label' => 'Local Landmarks', 'route' => 'admin.landmarks.index'],
                            ['label' => 'Identity & SEO', 'route' => 'admin.content.edit'],
                            ['label' => 'Experience Cards', 'route' => 'admin.home-events.index'],
                        ];
                    @endphp
                    @foreach($propertyLinks as $link)
                        <a href="{{ route($link['route']) }}" class="block py-2 text-xs font-medium {{ request()->routeIs($link['route']) ? 'text-indigo-400' : 'text-slate-500 hover:text-slate-300' }} transition-colors whitespace-nowrap">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Finance -->
        @if(auth()->user()->isAdmin() || auth()->user()->isAccountant())
            <a href="{{ route('admin.reports.index') }}" 
               class="flex items-center gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Finance</span>
            </a>
        @endif

        <!-- Team -->
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Team</span>
            </a>
            
            <!-- Maintenance -->
            <a href="{{ route('admin.maintenance.index') }}" 
               class="flex items-center gap-4 px-3 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.maintenance.index') ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span x-show="expanded" class="font-medium text-sm whitespace-nowrap">Maintenance</span>
            </a>
        @endif
    </div>

    <!-- Footer Area (User Profile etc may go here in expanded mode) -->
    <div class="p-4 bg-slate-950/20 shrink-0">
        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 px-3 py-2 rounded-xl text-slate-400 hover:text-white transition-all hover:bg-slate-800">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            <span x-show="expanded" class="text-xs font-semibold whitespace-nowrap">View Live Site</span>
        </a>
    </div>
</aside>
