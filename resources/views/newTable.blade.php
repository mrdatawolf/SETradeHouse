@extends('layouts.app')
@section('content')
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <livewire:stores.personal.datatable
            searchable="owner, value, amount"
            with="tradezones.title, servers.title, transactions_type.title"
            exportable
        />
    </div>
@endsection
