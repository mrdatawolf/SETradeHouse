@extends('layouts.app')
@section('content')
        <div id="app" class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Space Engineers Trading House
                </div>
                <div class="flex-center">
                    @auth
                        Currently you are viewing trade data for @livewire('active-server');
                    @endauth
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
@endsection
