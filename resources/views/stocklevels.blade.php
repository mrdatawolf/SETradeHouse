@extends('layouts.app')
@section('title', 'Stock Levels')
@section('menu')
    @parent
@endsection
@section('content')
<style>
    @media (min-width: 576px) {
        .card-columns {
            column-count: 2;
        }
    }

    @media (min-width: 768px) {
        .card-columns {
            column-count: 3;
        }
    }

    @media (min-width: 992px) {
        .card-columns {
            column-count: 4;
        }
    }

    @media (min-width: 1200px) {
        .card-columns {
            column-count: 5;
        }
    }
</style>
@if(! empty($stockLevels))
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="#npc" class="nav-link active" data-toggle="tab">NPCs</a>
        </li>
        @if($currentUser->roles->contains(8))
        <li class="nav-item">
            <a href="#user" class="nav-link" data-toggle="tab">Users</a>
        </li>
        @endif
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="npc">
            @livewire('stocklevels.npc', ['stockLevels' => $stockLevels])
        </div>
        @if($currentUser->roles->contains(8))
        <div class="tab-pane fade" id="user">
            @livewire('stocklevels.users', ['stockLevels' => $stockLevels])
        </div>
        @endif

    </div>
@else
<div class="card">
    <div class="card-header">Error</div>
    <div class="card-body">
    No Data Found
    </div>
</div>
@endif
@endsection
