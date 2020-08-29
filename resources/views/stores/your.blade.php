@extends('layouts.store')
@section('title', 'Your Stores')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        @if(! empty($stores))
            @php $active = 'active'; @endphp
            <ul class="nav nav-tabs">
                @foreach($stores as $gridName => $gridData)
                    @php $searchUsername = $currentUser->server_username ?? $currentUser->username; @endphp
                    @if(strtolower($gridData['Info']['Owner']) === strtolower($searchUsername))
                        @php $idName = str_replace(' ', '', $gridName); @endphp
                        <li class="nav-item">
                            <a href="#{{ $idName }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $gridName }}</a>
                        </li>
                        @php $active = ''; @endphp
                    @endif
                @endforeach
            </ul>
            <div class="tab-content">
                @php $specialClasses = 'show active'; @endphp
                @foreach($stores as $gridName => $gridData)
                    @php $searchUsername = $currentUser->server_username ?? $currentUser->username; @endphp
                    @if(strtolower($gridData['Info']['Owner']) === strtolower($searchUsername))
                        @php $idName = str_replace(' ', '', $gridName); @endphp
                        <div class="tab-pane fade {{ $specialClasses }}" id="{{ $idName }}">
                            <div class="card">
                                <div class="card-header">{{ $gridData['Info']['Owner'] }}</div>
                                <div class="card-body">
                                    @include('partials.transactionTable')
                                </div>
                                <div class="card-footer">
                                    {{ $gridData['Info']['GPS'] }}
                                </div>
                            </div>
                        </div>
                        @php $specialClasses = ''; @endphp
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    @parent
@endsection