@extends('layouts.app')
@section('content')
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <livewire:stores.personal.datatable
            searchable="value, amount"
            exportable
        />
    </div>
@endsection
