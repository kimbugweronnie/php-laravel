<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes">

    <meta name="author" content="Cryptosavannah">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/ucmb_logo.png') }}" width="20" alt=" memo image" />
    

    <title>ODMAS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .sidebar-link, a.sidebar-link {
            background: none;
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>

<body>

<div class="wrapper">
        @include('layouts.partials.sidebar')

    <div class="main">
        @include('layouts.partials.nav')

        <main class="content">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>

@livewireScripts
@stack('scripts')
</body>

</html>
