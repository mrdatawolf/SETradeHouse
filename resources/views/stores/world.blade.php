@extends('layouts.app')
@section('title', 'World Stores')
@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @livewire('stores.worlds.select-world',[ 'serverId'  => $serverId, 'worldId' =>  $worldId ])
        @if(! empty($stores))
            @php $active = 'active'; @endphp
            <ul class="nav nav-tabs">
                @foreach($stores as $gridName => $gridData)
                    <li class="nav-item">
                        <a href="#{{ $gridData->jsid }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $gridName }}</a>
                    </li>
                    @php $active = ''; @endphp
                @endforeach
            </ul>
            <div class="tab-content">
                @php $specialClasses = 'show active'; @endphp
                @foreach($stores as $gridName => $gridData)
                    <div class="tab-pane fade {{ $specialClasses }}" id="{{ $gridData->jsid }}">
                        <div class="card">
                            <div class="card-header">{{ $gridData->owner }}</div>
                            <div class="card-body">
                                @include('stores.partials.transactionTable')
                            </div>
                            <div class="card-footer">
                                {{ $gridData->GPS }}
                            </div>
                        </div>
                    </div>
                    @php $specialClasses = ''; @endphp
                @endforeach
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    @parent
@endsection
