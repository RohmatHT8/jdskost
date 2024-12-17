<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}" sizes="32x32">
    <title>{{ $title ?? 'JDS Kost' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-slate-100 dark:bg-slate-800">
    @auth
        @if (auth()->user()->role == 'admin')
            @livewire('partials.navbar')
        @else
            @livewire('partials.navbaruser')
        @endif
    @endauth
    <main class="relative">
        {{ $slot }}
        <a href="https://wa.me/628170056573?text=Halo,%20saya%20mau%20bertanya%20tentang:" class="fixed bottom-7 right-7 bg-green-600 w-14 h-14 rounded-full flex justify-center items-center hover:shadow-lg hover:bg-green-700">
            <svg class="w-10 h-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
            </svg>
        </a>
    </main>
    @livewireScripts
</body>

</html>
