@extends('layouts.app')
@section('title', 'All Users')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">All Users</div>
            <div class="card-body">
               <table class="table-striped table-responsive table-bordered">
                   <thead>
                   <tr>
                       @foreach($users->first()->toArray() as $title => $value)
                           @if($title !== 'email')
                            <th>{{ $title }}</th>
                           @endif
                       @endforeach
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($users as $user)
                       <tr>
                           @foreach($user->toArray() as $title => $value)
                               @if($title !== 'email')
                           <td>{{ $value }}</td>
                               @endif
                           @endforeach
                       </tr>
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
