@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Server notes messages </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('notes.create') }}" title="Create a notes"> <i class="fas fa-plus-circle"></i>
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
            <th>Note</th>
            <th>Date Created</th>
            <th>Date Last Updated</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($notes as $note)
            <tr>
                <td>{{ $note->id }}</td>
                <td>{{ $note->server_id }}</td>
                <td>{{ $note->message }}</td>
                <td>{{ date_format($note->created_at, 'jS M Y') }}</td>
                <td>{{ date_format($note->updated_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST">

                        <a href="{{ route('notes.show', $note->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('notes.edit', $note->id) }}">
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

    {!! $notes->links() !!}

@endsection
