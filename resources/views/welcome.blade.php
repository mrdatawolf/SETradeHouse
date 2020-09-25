<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon" />
        <title>SE Trading House</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-left links">
                    @auth
                        @extends('menu.menu')
                        @extends('ticker.tape')
                    @else
                        @extends('menu.notloggedin')
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    Space Engineers Trading House
                </div>
                <div class="flex-center">
                    @auth
                        Currently you are viewing trade data for {{ \App\Servers::find($currentUser->server_id)->title ?? '' }}
                    @endauth
                </div>
                <div class="links">

                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
