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
                    Stores of {{ \App\Worlds::find((int) Session::get('worldId'))->title ?? '' }} in {{ \App\Servers::find((int) Session::get('serverId'))->title ?? '' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table-striped table-responsive-xl">
                <thead>
                    <tr>
                        <th>TZ Name</th>
                        <th>Owner</th>
                        <th>GPS</th>
                    </tr>
                </thead>
                <tbody>
                @foreach(\App\TradeZones::all() as $tradeZone)
                    <tr>
                        <td><a href="{{ route('store', ['id' => $tradeZone->id]) }}">{{ $tradeZone->title }}</a></td>
                        <td>{{ $tradeZone->owner }}</td>
                        <td>{{ $tradeZone->gps }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
