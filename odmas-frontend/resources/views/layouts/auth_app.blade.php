<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ODMAS') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style type="text/css">
        i {
            font-size: 50px;
        }
        .nav-bg {
            background-color: #032746fc;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light nav-bg shadow-sm">
            <div class="container d-flex justify-content-center">
                <a class="navbar-brand " href="{{ url('/') }}">
                    <h4 class="fw-bold text-white">{{ config('app.name', 'ODMAS') }}</h4>
                </a>
            </div>
        </nav>
        <main class="py-4">
            @livewireScripts
            @yield('content')
            @livewireStyles
        </main>
    </div>
</body>

</html>
