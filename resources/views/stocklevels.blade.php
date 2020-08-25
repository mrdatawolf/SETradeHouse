@extends('layouts.stocklevels')
@section('title', 'Stock Levels')
@section('menu')
    @parent
@endsection
@section('content')
    <table class="table-striped">
        <thead>
        <tr>
            <th>
                Item
            </th>
            <th>
                Total Amount
            </th>
        </tr>
        </thead>
        <tbody>
        @if(! empty($stockLevels))
            @foreach($stockLevels as $type => $data)
                <tr>
                    <th colspan="2">
                        {{ $type }}
                    </th>
                </tr>
                @foreach($data as $item => $amount)
                <tr>
                    <td>
                        {{ $item }}
                    </td>
                    <td>
                        {{ $amount }}
                    </td>
                </tr>
                @endforeach
            @endforeach
        @endif
        </tbody>
    </table>

@endsection
@section('scripts')
    @parent
@endsection
