@php $specialClasses = 'show active';  $specialClasses2 = 'show active'; @endphp
<style>
    td {
        padding-right: 1em;
        font-family: Monospace;
    }
    .serverGroup, .storeGroup {
        text-align: center;
    }
    .serverGroup, .left-border, .right-border {
        border: 0;
    }
    .left-border {
        border-left: 1px solid #ccc;

    }
    .right-border {
        border-right: 1px solid #ccc;
    }
    .exposureAlert {
        color: #9a1313;
    }
</style>
<ul class="nav nav-tabs">
    @php $active = 'active'; @endphp
    @foreach(['Ore', 'Ingot','Component','Tool'] as $group)
            <li class="nav-item">
                <a href="#{{ $gridData->jsid }}_{{ $group }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $group }}</a>
            </li>
            @php $active = ''; @endphp
    @endforeach
</ul>
<div class="tab-content">
@foreach(['Ore', 'Ingot','Component','Tool'] as $group)
    <div class="tab-pane fade {{ $specialClasses }}" id="{{ $gridData->jsid }}_{{ $group }}">
        @if(! empty($gridData->$group))
            <table class="table-striped table-responsive-xl transaction-table" style="width:100%">
                <thead>
                <tr class="transaction-table-groups">
                    <th class="left-border"></th>
                    <th colspan="9" class="left-border right-border storeGroup">Stores Data</th>
                    <th colspan="4" class="left-border right-border serverGroup">Server ( limited to last {{ $hoursWindow }} hours)</th>
                </tr>
                <tr class="transaction-table-groups text-center">
                    <th class="left-border">Name</th>
                    <th colspan="2" class="left-border">Average Price</th>
                    <th colspan="2">Lowest Price</th>
                    <th colspan="2">Highest Price</th>
                    <th colspan="2">Amount</th>
                    <th class="right-border" title="If someone bought from you and sold to you how much would you lose (if you would lose)">Exposure</th>
                    <th class="left-border" colspan="2">Total Amount</th>
                    <th class="right-border" colspan="2">Average Price</th>
                </tr>
                <tr class="text-center">
                    <th class="left-border"></th>
                    <th class="left-border">Order</th>
                    <th>Offer</th>
                    <th>Order</th>
                    <th>Offer</th>
                    <th>Order</th>
                    <th>Offer</th>
                    <th>Order</th>
                    <th>Offer</th>
                    <th class="right-border"></th>
                    <th class="left-border">Orders</th>
                    <th>Offers</th>
                    <th >Orders</th>
                    <th class="right-border">Offers</th>
                </tr>
                </thead>
                <tbody>
                @foreach($gridData->$group as $good => $goodData)
                    @php
                        $stores = new App\Http\Controllers\Stores();
                        $order = $stores->getGlobalDataForGood(1, $group, $good, $hoursWindow)->first();
                        $offer = $stores->getGlobalDataForGood(2, $group, $good, $hoursWindow)->first();
                        $priceExposure = (empty($goodData->Orders) || empty($goodData->Offers)) ? 'n/a' : $goodData->Offers->avgPrice - $goodData->Orders->avgPrice;
                        $exposure = ($priceExposure >= 0) ? 0 : $priceExposure * $goodData->Orders->amount;
                        $exposureClass = ($exposure > 0) ? "exposureAlert" : "";
                    @endphp
                    <tr class="text-right">
                        <td class="left-border">{{ ucfirst($good) }}</td>
                        <td class="left-border">{{ number_format($goodData->Orders->avgPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Offers->avgPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Orders->minPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Offers->minPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Orders->maxPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Offers->maxPrice ?? 0) }}</td>
                        <td>{{ number_format($goodData->Orders->amount ?? 0) }}</td>
                        <td>{{ number_format($goodData->Offers->amount ?? 0) }}</td>
                        <td class="right-border {{ $exposureClass }}">{{ number_format($exposure) }}</td>
                        <td class="left-border">{{ number_format($order->amount ?? 0) }}</td>
                        <td>{{ number_format($offer->amount ?? 0) }}</td>
                        <td>{{ number_format($order->average ?? 0) }}</td>
                        <td class="right-border">{{ number_format($offer->average ?? 0) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        @endif
    </div>
    @php $specialClasses = 'hide'; @endphp
@endforeach
</div>
