<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @extends('menu.menu')

        <main class="py-4">
            @if($errors->any())
                <div class="col-md-8">
                    <div class="card error">
                        <div class="card-header">Errors</div>
                        <div class="card-body">
                            <h4>{{$errors->first()}}</h4>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
        @auth
            @extends('ticker.tape')
        @endauth
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
