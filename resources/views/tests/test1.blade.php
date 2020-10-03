@extends('layouts.tests')
@section('title', 'Test 1')
@section('menu')
    @parent
@endsection
@section('content')
    <style>
        td {
            text-align: right;
        }
    </style>
@if(! empty($transactions))
    @foreach($transactions as $transType => $transData)
        @foreach($transData as $typeId => $typeData)
            <div style="padding-bottom: 1em">
                <h4>{{ $transType }} - {{ \App\Models\GoodTypes::find($typeId)->title }}</h4><br>
            <table class="table-striped" border="1">
                <thead>
                <tr>
                    <th>
                        GoodId
                    </th>
                    <th>
                        Item
                    </th>
                    <th>
                        Sum
                    </th>
                    <th>
                        Average Price
                    </th>
                    <th>
                        Count
                    </th>
                    <th>
                        Prices
                    </th>
                    <th>
                        Qtys
                    </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($typeData as $goodId => $data)
                        <tr>
                            <td>
                                {{ $goodId }}
                            </td>
                            <td>
                                {{ $data['title'] }}
                            </td>
                            <td>
                                {{ $data['sum'] }}
                            </td>
                            <td>
                                {{ round($data['average'], 2) }}
                            </td>
                            <td>
                                {{ $data['count'] }}
                            </td>
                            <td>
                                {{ implode(',', $data['prices']) }}
                            </td>
                            <td>
                                {{ implode(',', $data['qtys']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endforeach
    @endforeach
@endif

@endsection
@section('scripts')
    @parent
@endsection
