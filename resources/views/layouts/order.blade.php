<html>
<head>
    <title>Order - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/offer_order.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ticker.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @extends('menu.menu')
    @extends('ticker.tape')
    <div class="container">
        @include('partials.builder_panel_body')
        @include('partials.builder_panel_csv')
        @yield('content')
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script> -->
    <script src="/js/clipboard.min.js"></script>
    <script src="/js/offer_order.js"></script>
    <script src="/js/jquery.ticker.js"></script>
    <script>
        $(window).on('load', function () {
            exportTableTo();
        });
    </script>
@show
</body>
</html>
