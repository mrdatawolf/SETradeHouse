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
                    Stores @livewire('active-world') in @livewire('active-server')
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:home.datatable
                        searchable="title, owner"
                        per-page="25"
                        exportable
                        sort="title|asc"
                    />
                </div>
        </div>
    </div>
</div>
@endsection
