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
    <main>
        {{ $slot }}
    </main>
    @livewireScripts
</body>

</html>
