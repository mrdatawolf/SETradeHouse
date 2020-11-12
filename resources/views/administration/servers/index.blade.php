@extends('layouts.app')
@section('title', 'All Severs')

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
            <h1 style="font-size: 2em;"><b>Servers</b></h1>
        </div>
        <br />
        <div class="flex mb-6">
            <livewire:datatable
                model="App\Models\Servers"
                include="id, title, scarcity_id, economy_ore_id, economy_stone_modifier, scaling_modifier, economy_ore_value, asteroid_scarcity_modifier, planet_scarcity_modifier, base_modifier, short_name, created_at, updated_at"
                dates="updated_at, created_at"
                searchable="title, short_name" exportable
            />
        </div>
    </div>
@endsection
