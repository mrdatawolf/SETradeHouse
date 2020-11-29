@extends('layouts.app')
@section('content')
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <livewire:worlds.datatables.index
            searchable="title, short_name"
            exportable
        />
    </div>
@endsection
