@extends('layouts.app')

@section('content')
<style>
    .card {
        margin-bottom: 1em;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Space Engineers Trading House</div>
                <div class="card-body">
                    Stores of @livewire('active-world') in @livewire('active-server')
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @livewire('trade-zones-list-table')
        </div>
    </div>
</div>
@endsection
