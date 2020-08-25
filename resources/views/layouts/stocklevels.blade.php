<html>
<head>
    <title>Order - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @extends('menu.menu')
    @extends('ticker.tape')
    <div class="container">
        @yield('content')
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script> -->
    <script src="{{asset('js/default.js')}}"></script>
    <script src="{{asset('js/clipboard.min.js')}}"></script>
@show
</body>
</html>
