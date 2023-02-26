<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/03221c46fa.js" crossorigin="anonymous"></script>{{-- aqui incluyo iconos de fontawesome --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @stack('css')

</head>

<body class="font-sans antialiased bg-gray-50 text-gray-700">
    <x-jet-banner />

    @php
        $links = [
            [
                'title' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
                'icon' => 'fa-solid fa-gauge-high',
            ],
            [
                'title' => 'Post',
                'url' => route('admin.post.index'),
                'active' => request()->routeIs('admin.post.*'),
                'icon' => 'fa-solid fa-blog'    
            ],
        ];
    @endphp

    <div class="flex" x-data="{ open: false, openSidebar: true }">
        <div :class="{ 'lg:block': openSidebar, }" class="w-64 flex-shrink-0 hidden lg:block">{{-- aqui se utilizo Alpine.js --}}
            @include('layouts.partials.admin.sidebar'){{-- aqui incluyo el sidebar que esta en sidebar.blade.php --}}
        </div>

        <div class=" flex-1">
            @include('layouts.partials.admin.navigation'){{-- aqui incluyo el menu de navegacion que esta en navigation.blade.php --}}


            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                {{ $slot }}{{-- Aqui va el texto dinamico que coloco en dashboard.blade.php que esta dentro de la carpeta admin --}}
            </div>
        </div>


    </div>
    @stack('modals')

    @livewireScripts

    @stack('js')
</body>

</html>
