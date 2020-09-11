@extends('layouts.pl.store')
@section('title', 'Server Stores')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @if(! empty($stores))
            @php $active = 'active'; @endphp
            <ul class="nav nav-tabs">
            @foreach($stores as $gridName => $gridData)
                    @php
                        $idName = str_replace(' ', '', $gridName);
                        $idName = str_replace('[', '', $idName);
                        $idName = str_replace(']', '', $idName);
                        $idName = str_replace('(', '', $idName);
                        $idName = str_replace(')', '', $idName);
                        $idName = htmlentities($idName);
                        $idName = htmlspecialchars($idName);
                    @endphp
                    <li class="nav-item">
                        <a href="#{{ $idName }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $gridName }}</a>
                    </li>
                    @php $active = ''; @endphp
            @endforeach
            </ul>
            <div class="tab-content">
            @php $specialClasses = 'show active'; @endphp
            @foreach($stores as $gridName => $gridData)
                    @php
                        $idName = str_replace(' ', '', $gridName);
                        $idName = str_replace('[', '', $idName);
                        $idName = str_replace(']', '', $idName);
                        $idName = str_replace('(', '', $idName);
                        $idName = str_replace(')', '', $idName);
                        $idName = htmlentities($idName);
                        $idName = htmlspecialchars($idName);
                    @endphp
                <div class="tab-pane fade {{ $specialClasses }}" id="{{ $idName }}">
                    <div class="card">
                        <div class="card-header">{{ $gridData['Info']['Owner'] }}</div>
                        <div class="card-body">
                            @include('partials.profitLossTable')
                        </div>
                        <div class="card-footer">
                            {{ $gridData['Info']['GPS'] }}
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