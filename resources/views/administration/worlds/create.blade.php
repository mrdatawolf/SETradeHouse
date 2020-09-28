@extends('layouts.administration.create')
@section('title', 'Create World')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">Create a world</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.worlds.add') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" aria-describedby="titleHelp" placeholder="Enter title">
                        <small id="titleHelp" class="form-text text-muted">The full name of the world</small>
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short_hand">Abreviation</label>
                        <input type="text" class="form-control @error('short_name') is-invalid @enderror" name="short_name" id="shortHand" aria-describedby="short_handHelp" placeholder="Enter abreviation">
                        <small id="short_handHelp" class="form-text text-muted">A short version of the full title</small>
                        @error('short_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="server_idFormControlSelect">Server</label>
                        <select class="form-control @error('server_id') is-invalid @enderror" name="server_id" id="server_idFormControlSelect" aria-describedby="server_idHelp">
                            @foreach(\App\Servers::all() as $server)
                            <option value="{{ $server->id }}">{{ $server->title }}</option>
                            @endforeach
                        </select>
                        <small id="scarcityHelp" class="form-text text-muted">Name of the server the world is part of.</small>
                        @error('server_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type_idFormControlSelect">World Type</label>
                        <select class="form-control @error('type_id') is-invalid @enderror" name="type_id" id="type_idFormControlSelect" aria-describedby="type_idHelp">
                            @foreach(\App\WorldTypes::all() as $world)
                                <option value="{{ $world->id }}">{{ $world->title }}</option>
                            @endforeach
                        </select>
                        <small id="type_idHelp" class="form-text text-muted">Type of world.</small>
                        @error('type_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="system_stock_weight">System Stock Weight</label>
                        <input type="text" class="form-control @error('system_stock_weight') is-invalid @enderror" name="system_stock_weight" id="system_stock_weight" aria-describedby="system_stock_weightHelp" value="1">
                        <small id="system_stock_weightHelp" class="form-text text-muted">As a good reaches deisred level adjust the weight. Defaults to 1.</small>
                        @error('system_stock_weight')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
