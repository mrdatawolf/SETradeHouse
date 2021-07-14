@extends($layout)
@section('title', 'TLDR News')
@section('menu')
    @parent
@endsection
@section('content')
    <style>
        td {
            text-align: right;
        }
    </style>

    @livewire('news.tldr')

@endsection
