@extends('layouts.app')
@section('title', $goodType)
@section('content')
    <div class="container">
        @include('partials.builder_panel_body')
        @include('partials.builder_panel_csv')
        @yield('content')
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(window).on('load', function () {
            exportTableTo();
        });
    </script>
@endsection
