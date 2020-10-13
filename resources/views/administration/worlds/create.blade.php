@extends('layouts.app')
@section('title', 'Create World')

@section('content')
    <div class="card">
        <div class="card-header">
            Create a world
        </div>
        <div class="card-body">
            @livewire('world-form')
        </div>
    </div>
@endsection
