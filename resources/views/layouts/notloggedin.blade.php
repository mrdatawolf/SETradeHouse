<!doctype html>
<html>
<head>
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon" />
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/store.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    @yield('style')
</head>
<body>
<div id="app">
    @extends('menu.menu')
    <div class="container">
        @yield('content')
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script> -->
    <script src="{{asset('js/clipboard.min.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@show
</body>
</html>
