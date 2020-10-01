@extends('layouts.administration.users')
@section('title', 'All Owners')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">Player Owners</div>
            <div class="card-body">
               <table class="table-striped table-responsive table-bordered">
                   <thead>
                   <tr>
                       @foreach($owners->first()->toArray() as $title => $value)
                            <th>{{ $title }}</th>
                       @endforeach
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($owners as $owner)
                       @if(substr($owner->owner_title,0,3) !== 'NPC')
                       <tr>
                           @foreach($owner->toArray() as $title => $value)
                               <td>{{ $value }}</td>
                           @endforeach
                       </tr>
                       @endif
                   @endforeach
                   </tbody>
               </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">NPC Owners</div>
            <div class="card-body">
                <table class="table-striped table-responsive table-bordered">
                    <thead>
                    <tr>
                        @foreach($owners->first()->toArray() as $title => $value)
                            <th>{{ $title }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($owners as $owner)
                        @if(substr($owner->owner_title,0,3) === 'NPC')
                            <tr>
                                @foreach($owner->toArray() as $title => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
