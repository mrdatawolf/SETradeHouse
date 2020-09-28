@extends('layouts.administration.worlds')
@section('title', 'All Worlds')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">All Worlds</div>
            <div class="card-body">
               <table class="table-striped table-responsive table-bordered">
                   <thead>
                   <tr>
                       <th>Id</th>
                       <th>Title</th>
                       <th>Short Name</th>
                       <th>Server Id</th>
                       <th>Type Id</th>
                       <th>System Stock Weight</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($worlds as $world)
                       <tr>
                           <td>{{ $world->id }}</td>
                           <td>{{ $world->title }}</td>
                           <td>{{ $world->short_name }}</td>
                           <td>{{ $world->server_id }}</td>
                           <td>{{ $world->type_id }}</td>
                           <td>{{ $world->system_stock_weight }}</td>
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
