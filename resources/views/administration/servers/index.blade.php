@extends('layouts.app')
@section('title', 'All Severs')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">All Servers</div>
            <div class="card-body">
               <table class="table-striped table-responsive table-bordered">
                   <thead>
                   <tr>
                       <th>Id</th>
                       <th>Title</th>
                       <th>Short Name</th>
                       <th>Scarcity Id</th>
                       <th>Economy Ore Id</th>
                       <th>Economy Ore Value</th>
                       <th>Economy Stone Modifier</th>
                       <th>Scaling Modifier</th>
                       <th>Asteroid Scarcity Modifier</th>
                       <th>Planet Scarcity Modifier</th>
                       <th>Base Modifier</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($servers as $server)
                       <tr>
                           <td>{{ $server->id }}</td>
                           <td>{{ $server->title }}</td>
                           <td>{{ $server->short_name }}</td>
                           <td>{{ $server->scarcity_id }}</td>
                           <td>{{ $server->economy_ore_id }}</td>
                           <td>{{ $server->economy_ore_value }}</td>
                           <td>{{ $server->economy_stone_modifier }}</td>
                           <td>{{ $server->scaling_modifier }}</td>
                           <td>{{ $server->asteroid_scarcity_modifier }}</td>
                           <td>{{ $server->planet_scarcity_modifier }}</td>
                           <td>{{ $server->base_modifier }}</td>
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
