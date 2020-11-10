@extends('layouts.guest')
@section('title', 'Server Stores')

@section('content')
    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4" onclick="location.href='/register'">Register</button>
    <x-jet-button class="ml-4" onclick="location.href='/login'">
        {{ __('Login') }}
    </x-jet-button>
    <div id="app" class="flex-center position-ref full-height">
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
                                @include('stores.partials.notloggedinTable')
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
