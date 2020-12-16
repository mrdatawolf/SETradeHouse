@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Server welcome messages </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('welcome.create') }}" title="Create a welcome"> <i class="fas fa-plus-circle"></i>
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
            <th>Message</th>
            <th>Date Created</th>
            <th>Date Last Updated</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($welcomes as $welcome)
            <tr>
                <td>{{ $welcome->id }}</td>
                <td>{{ $welcome->server_id }}</td>
                <td>{{ $welcome->message }}</td>
                <td>{{ date_format($welcome->created_at, 'jS M Y') }}</td>
                <td>{{ date_format($welcome->updated_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('welcome.destroy', $welcome->id) }}" method="POST">

                        <a href="{{ route('welcome.show', $welcome->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('welcome.edit', $welcome->id) }}">
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

    {!! $welcomes->links() !!}

@endsection
