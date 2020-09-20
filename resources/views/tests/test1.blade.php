@extends('layouts.tests')
@section('title', 'Test 1')
@section('menu')
    @parent
@endsection
@section('content')
@if(! empty($orders))
    @foreach($orders as $typeId => $typeData)
        <div style="padding-bottom: 1em">
            <h4>Offer - {{ \App\GoodTypes::find($typeId)->title }}</h4><br>
        <table class="table-striped">
            <thead>
            <title> Order - {{ \App\GoodTypes::find($typeId)->title }}</title>
            <tr>
                <th>
                    GoodId
                </th>
                <th>
                    Item
                </th>
                <th>
                    Sum Amount
                </th>
                <th>
                    Total Amount
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
                            {{ $data['sumAmount'] }}
                        </td>
                        <td>
                            {{ $data['sumPrice'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endforeach
@endif

@if(! empty($offers))
    @foreach($offers as $typeId => $typeData)
        <div style="padding-bottom: 1em">
            <h4>Offer - {{ \App\GoodTypes::find($typeId)->title }}</h4><br>
            <table class="table-striped">

                <thead>
                <tr>
                    <th>
                        GoodId
                    </th>
                    <th>
                        Item
                    </th>
                    <th>
                        Sum Amount
                    </th>
                    <th>
                        Total Amount
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
                            {{ $data['sumAmount'] }}
                        </td>
                        <td>
                            {{ $data['sumPrice'] }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endif
@endsection
@section('scripts')
    @parent
@endsection
