<div x-data="{ open: false }" 
     @open-mobile-menu.window="open = true" 
     x-show="open" 
     class="fixed inset-0 z-[100] lg:hidden" 
     x-cloak>
    <!-- Backdrop -->
    <div x-show="open" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="open = false" 
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

    <!-- Menu Content -->
    <div x-show="open" 
         x-transition:enter="transition ease-in-out duration-300 transform" 
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in-out duration-300 transform" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="-translate-x-full" 
         class="relative flex w-full max-w-xs flex-col bg-slate-900 h-full shadow-2xl overflow-y-auto">
        
        <div class="flex items-center justify-between px-6 h-16 bg-slate-950/50 shrink-0">
            <x-application-logo class="h-8 filter brightness-0 invert" />
            <button @click="open = false" class="p-2 text-slate-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-6">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-6 h-6 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-bold uppercase tracking-widest text-xs">Dashboard</span>
            </a>

            <!-- Operative Core -->
            <div class="space-y-3">
                <div class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Operational Core</div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('admin.front-desk.index')" class="text-indigo-400 font-bold text-xs uppercase tracking-wider px-4 flex items-center gap-3">Room Front Desk</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.event-front-desk.index')" class="text-emerald-400 font-bold text-xs uppercase tracking-wider px-4 flex items-center gap-3">Event Front Desk</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.reservations.index')" class="text-slate-400 px-4">View Stays</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.events.index')" class="text-slate-400 px-4">View Events</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.garden-bookings.index')" class="text-slate-400 px-4">Garden Bookings</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.garden.calendar')" class="text-slate-400 px-4 italic">Garden Calendar</x-responsive-nav-link>
                </div>
            </div>

            <!-- Property -->
            @if(auth()->user()->isAdmin())
            <div class="space-y-3">
                <div class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Property</div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('admin.rooms.index')" class="text-slate-400 px-4">Rooms</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.garden-profile.edit')" class="text-slate-400 px-4">Garden</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.gallery.index')" class="text-slate-400 px-4">Gallery</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.landmarks.index')" class="text-slate-400 px-4">Landmarks</x-responsive-nav-link>
                </div>
            </div>
            @endif

            <!-- Account -->
            <div class="pt-6 border-t border-slate-800 space-y-4">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-wider">My Account</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 text-red-500 hover:text-red-400 transition-colors w-full text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider">Log Out</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</div>
