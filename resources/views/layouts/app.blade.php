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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style> 
            [x-cloak] { display: none !important; } 
            body { font-family: 'Inter', sans-serif; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased text-slate-900">
        <!-- Mobile Menu Slide-over -->
        @include('layouts.mobile-menu')

        <div class="min-h-screen bg-slate-50 flex">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Header -->
                @include('layouts.admin-header')

                <!-- Page Content -->
                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr('input[type="date"]', {
                    altInput: true,
                    altFormat: "d/m/Y",
                    dateFormat: "Y-m-d",
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.altInput) {
                            instance.altInput.className = instance.input.className;
                        }
                    }
                });
            });
        </script>
    </body>
</html>
