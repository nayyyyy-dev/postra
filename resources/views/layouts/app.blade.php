<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Postra') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800">

    <!-- Gradient Background -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-blue-50 via-white to-sky-100"></div>

    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @isset($header)
                <header class="mb-8 float-in">
                    <div class="text-2xl font-bold text-slate-800">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if (session('success'))
                <div data-alert class="mb-6 float-in rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-900">
                    {{ session('success') }}
                </div>
            @endif

            <main class="float-in">
                {{ $slot }}
            </main>

            <footer class="mt-12 text-center text-xs text-slate-500">
                © {{ now()->year }} Postra • Surat digital berbasis PDF
            </footer>
        </div>
    </div>
</body>
</html>
