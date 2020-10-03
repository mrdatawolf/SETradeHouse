@extends('layouts.app')
@section('title', 'Stock Levels')
@section('menu')
    @parent
@endsection
@section('content')
    @if(! empty($stockLevels))
<div class="flex-center position-ref full-height">
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
            <div class="card">
                <div class="card-header">NPC Data</div>
                <div class="card-body">
                    <table class="table-striped">
                        <thead>
                        <tr>
                            <th>Good</th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($stockLevels['npc'] as $goodType => $data)
                                <tr>
                                    <th colspan="2">{{ $goodType }}</th>
                                </tr>
                                @foreach($data as $good => $amount)
                                    <tr>
                                        <td>{{ $good }}</td>
                                        <td>{{ $amount }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($currentUser->roles->contains(8))
        <div class="tab-pane fade" id="user">
            <div class="card">
                <div class="card-header">User Data</div>
                <div class="card-body">
                    <table class="table-striped">
                        <thead>
                        <tr>
                            <th>Good</th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($stockLevels['user'] as $goodType => $data)
                            <tr>
                                <th colspan="2">{{ $goodType }}</th>
                            </tr>
                            @foreach($data as $good => $amount)
                                <tr>
                                    <td>{{ $good }}</td>
                                    <td>{{ $amount }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
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
@section('scripts')
    @parent
@endsection
