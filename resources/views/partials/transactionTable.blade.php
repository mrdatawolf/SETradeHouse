@php $specialClasses = 'show active';  $specialClasses2 = 'show active'; @endphp
<style>
    td {
        padding-right: 1em;
        font-family: Monospace;
        font-size: smaller;
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
                        <th colspan="10" class="left-border right-border storeGroup">Stores Data</th>
                        <th colspan="4" class="left-border right-border serverGroup">Server</th>
                    </tr>
                    <tr class="transaction-table-groups text-center">
                        <th class="left-border">Name</th>
                        <th colspan="2" class="left-border">Average Prices</th>
                        <th colspan="2">Lowest Prices</th>
                        <th colspan="2">Highest Prices</th>
                        <th colspan="2">Amount</th>
                        <th colspan="2" class="right-border" title=" Difference from the average market price">Variances</th>
                        <th class="left-border" colspan="2">Total Amounts</th>
                        <th colspan="2" class="right-border">Average Prices</th>
                    </tr>
                    <tr class="text-center">
                        <th class="left-border"></th>
                        <th class="left-border">Orders</th>
                        <th>Offers</th>
                        <th>Orders</th>
                        <th>Offers</th>
                        <th>Orders</th>
                        <th>Offers</th>
                        <th>Orders</th>
                        <th>Offers</th>
                        <th title="If order is a + number then they are paying more then the average selling price of the market.">Order</th>
                        <th class="right-border" title="If offer is a + number then they are selling below the avg order market price">Offer</th>
                        <th class="left-border">Orders</th>
                        <th>Offers</th>
                        <th>Orders</th>
                        <th class="right-border">Offers</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gridData->$group as $good => $goodData)
                        @php
                            $storeOrders = new \App\Http\Controllers\Stores();
                            $globalOrderAverages = $storeOrders->getGlobalDataForGood(1, $group, $good, $hoursAgo = 36);
                            $storeOffers = new \App\Http\Controllers\Stores();
                            $globalOfferAverages = $storeOffers->getGlobalDataForGood(2, $group, $good, $hoursAgo = 36);
                            $globalOrder = $globalOrderAverages->where('title',strtolower($good))->first();
                            $globalOffer = $globalOfferAverages->where('title',strtolower($good))->first();
                            $orderVariance = (empty($goodData->Orders) || empty($globalOffer)) ? 'n/a' : round($goodData->Orders->avgPrice - $globalOffer->average, 2);
                            $offerVariance = (empty($goodData->Offers) || empty($globalOrder)) ? 'n/a' : round($globalOrder->average - $goodData->Offers->avgPrice, 2);
                        @endphp
                        <tr class="text-center">
                            <td class="left-border">{{ ucfirst($good) }}</td>
                            <td class="left-border">{{ number_format($goodData->Offers->avgPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Orders->avgPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Orders->minPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Offers->minPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Orders->maxPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Offers->maxPrice ?? 0) }}</td>
                            <td>{{ number_format($goodData->Orders->amount ?? 0) }}</td>
                            <td>{{ number_format($goodData->Offers->amount ?? 0) }}</td>
                            <td>{{ (is_int($orderVariance)) ? number_format($orderVariance) : $orderVariance }}</td>
                            <td class="right-border">{{ (is_int($offerVariance)) ? number_format($offerVariance) : $offerVariance }}</td>
                            <td class="left-border">{{ number_format($globalOrder->amount ?? 0) }}</td>
                            <td>{{ number_format($globalOffer->amount ?? 0) }}</td>
                            <td>{{ number_format($globalOrder->average ?? 0) }}</td>
                            <td class="right-border">{{ number_format($globalOffer->average ?? 0) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @php $specialClasses = 'hide'; @endphp
    @endforeach
</div>
