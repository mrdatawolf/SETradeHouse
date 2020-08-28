@extends('layouts.store')
@section('title', 'Server Stores')
@section('menu')
    @parent
@endsection
@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @if(! empty($stores))
            @foreach($stores as $gridName => $gridData)
                <div class="card" style="margin-bottom: 2em;">
                    <div class="card-header">{{ $gridName }} - {{ $gridData['Info']['Owner'] }}</div>
                    <div class="card-body">
                        @include('partials.transactionTable')
                    </div>
                    <div class="card-footer">
                        {{ $gridData['Info']['GPS'] }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
@section('scripts')
    @parent
    <script>
    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    </script>
@endsection
