@extends($layout)
@section('title', 'AUN News')
@section('menu')
    @parent
@endsection
@section('content')
    <style>
        td {
            text-align: right;
        }
    </style>

    @livewire('news.aun')

@endsection
