<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php $favicon = \App\Models\ContentSetting::getValue('favicon_path'); @endphp
        @if($favicon)
            <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
        @endif

        <title>{{ \App\Models\ContentSetting::getValue('site_title', 'Rose Villa') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .premium-gradient {
                background: radial-gradient(circle at top right, #fff5f5 0%, #fdf2f2 30%, #f9fafb 100%);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 25px 50px -12px rgba(159, 18, 57, 0.1);
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased premium-gradient">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8 transform hover:scale-105 transition-transform duration-500">
                <a href="/">
                    <x-application-logo class="w-32 h-auto" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 glass-card overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>

            <!-- Footer Decorative Element -->
            <div class="mt-8 text-rose-300 pointer-events-none opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
        </div>
    </body>
</html>
