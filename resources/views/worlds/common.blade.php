@extends('layouts.app')
@section('content')
    @if(empty($worldId))
        @php $worldId=''; @endphp
    @endif
    <livewire:worlds.datatables.show
        searchable="id, servers.title"
        sort="title|asc"
        with="servers.title, rarity.title, types.title"
        search="{{ $worldId }}"
        exportable
    />
@endsection
