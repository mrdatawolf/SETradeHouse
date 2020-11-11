@extends($layout)
@section('title', 'Thrust Calc')
@section('menu')
    @parent
@endsection
@section('content')
    <style>
        td {
            text-align: right;
        }
    </style>

    @livewire('calculator.thrust')

@endsection
