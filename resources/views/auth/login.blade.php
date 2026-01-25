<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Welcome Back</h1>
        <p class="text-gray-500 font-medium">Please sign in to your dashboard</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-rose-800 uppercase tracking-widest mb-2 px-1">Email Address</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-rose-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com"
                       class="block w-full pl-12 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all duration-300 font-medium text-gray-700 placeholder-gray-300 shadow-sm">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2 px-1">
                <label for="password" class="block text-xs font-bold text-rose-800 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-rose-600 hover:text-rose-800 uppercase tracking-wider transition-colors" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-rose-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                       class="block w-full pl-12 pr-4 py-4 bg-gray-50/50 border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-400 transition-all duration-300 font-medium text-gray-700 placeholder-gray-300 shadow-sm">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center px-1">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-rose-600 shadow-sm focus:ring-rose-500 transition-all cursor-pointer" name="remember">
                <span class="ms-3 text-sm font-medium text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Remember for 30 days') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-rose-900 text-white py-4 rounded-2xl font-bold text-sm uppercase tracking-widest hover:bg-rose-950 focus:ring-4 focus:ring-rose-900/20 transition-all duration-300 shadow-lg shadow-rose-900/20 active:scale-95">
                {{ __('Sign In to Dashboard') }}
            </button>
        </div>
    </form>
</x-guest-layout>
