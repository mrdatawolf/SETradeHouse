@extends('layouts.app')
@section('title', 'Server Stores')
@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @livewire('server.stores',[ 'serverId'  => $serverId])
    </div>
@endsection
@section('scripts')
    @parent
@endsection
