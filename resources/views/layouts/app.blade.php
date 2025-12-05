<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

    <!-- jQuery UI CSS (Opsional, jika dipakai) -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui/jquery-ui.min.css') }}">

    <!-- Additional Styles from Pages -->
    @stack('styles')


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            @yield('content') {{-- untuk view biasa --}}
            @isset($slot)
                {{ $slot }} {{-- untuk Livewire + x-app-layout --}}
            @endisset
        </main>
    </div>

    <!-- jQuery UI JS (Opsional, jika dipakai) -->
    <script src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>



    <!-- Additional Scripts from Pages -->
    @stack('scripts')
</body>

</html>
