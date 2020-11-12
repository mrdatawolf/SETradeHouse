@extends('layouts.app')
@section('title', 'All Worlds')

@section('content')
    <style>
        .rounded-lg, .rounded-b-none
        {
            width: 1140px;
        }

        .form-input
        {
            width: 450px;
            height: 30px;
        }
    </style>
    <div class="container mx-auto">
        <br />
        <div class="flex items-center markdown">
            <h1 style="font-size: 2em;"><b>Worlds</b></h1>
        </div>
        <br />
        <div class="flex mb-4">
            <livewire:worlds.data-table searchable="title, short_name, rarity" exportable />
        </div>
    </div>
@endsection
