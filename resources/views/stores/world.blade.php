@extends('layouts.app')
@section('title', 'World Stores')
@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @livewire('stores.worlds.select-world',[ 'serverId'  => $serverId, 'worldId' =>  $worldId ])
        @livewire('worlds.stores',[ 'serverId'  => $serverId, 'worldId' =>  $worldId ])
    </div>
@endsection
@section('scripts')
    @parent
@endsection
