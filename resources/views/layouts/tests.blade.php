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
    @extends('ticker.tape')
    <div class="container">
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
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
@show
</body>
</html>
