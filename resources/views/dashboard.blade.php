@extends('layouts.app')

@section('content')
    <style>
        .card {
            margin-bottom: 1em;
        }
        ul {
            list-style-type: circle;
        }
    </style>
    <div class="container">
        <div class="card-deck">
            @livewire('server.welcome')
            @livewire('server.information')
            @livewire('server.rules')
            @livewire('server.gps')
            @livewire('server.commands')
            @livewire('server.mods')
            @livewire('server.notes')
        </div>
    </div>

@endsection
