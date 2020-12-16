@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Server mods messages </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('mods.create') }}" title="Create a mods"> <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Id</th>
            <th>Server Id</th>
            <th>Mod</th>
            <th>Description</th>
            <th>Mod Type</th>
            <th>Mod Number</th>
            <th>Date Created</th>
            <th>Date Last Updated</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mods as $mod)
            <tr>
                <td>{{ $mod->id }}</td>
                <td>{{ $mod->server_id }}</td>
                <td>{{ $mod->message }}</td>
                <td>{{ $mod->description }}</td>
                <td>{{ $mod->mod_type }}</td>
                <td>{{ $mod->mod_number }}</td>
                <td>{{ date_format($mod->created_at, 'jS M Y') }}</td>
                <td>{{ date_format($mod->updated_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('mods.destroy', $mod->id) }}" method="POST">

                        <a href="{{ route('mods.show', $mod->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('mods.edit', $mod->id) }}">
                            <i class="fas fa-edit  fa-lg"></i>

                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>

                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $mods->links() !!}

@endsection
