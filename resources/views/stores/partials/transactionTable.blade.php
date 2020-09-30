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
    @foreach(['Ore', 'Ingot','Component','Tool'] as $goodType)
        <li class="nav-item">
            <a href="#{{ $gridData->jsid }}_{{ $goodType }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $goodType }}</a>
        </li>
        @php $active = ''; @endphp
    @endforeach
</ul>
<div class="tab-content">
    @foreach(\App\GoodTypes::pluck('title') as $goodType)
        <div class="tab-pane fade {{ $specialClasses }}" id="{{ $gridData->jsid }}_{{ $goodType }}">
            @if(! empty($gridData->goods->$goodType))
                <table class="table-striped table-responsive-xl transaction-table" style="width:100%">
                    <thead>
                    <tr class="transaction-table-groups">
                        <th class="left-border"></th>
                        <th colspan="4" class="left-border right-border storeGroup">This Store's Data</th>
                        <th colspan="5" class="left-border right-border storeGroup" title="If you bought from this store and sold to the current store.">Best store to order from</th>
                        <th colspan="5" class="left-border right-border storeGroup" title="If you sold to this store after buying from the current store.">Best store to offer to</th>
                    </tr>
                    <tr class="transaction-table-groups text-center">
                        <th class="left-border">Name</th>
                        <th class="left-border">Order<br>Prices</th>
                        <th>Offer<br>Prices</th>
                        <th>Order<br>Amount</th>
                        <th class="right-border">Offer<br>Amount</th>
                        <!-- Order-->
                        <th class="left-border">Name</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Profit</th>
                        <th class="right-border">Distance</th>
                        <!-- Offer -->
                        <th class="left-border">Name</th>
                        <th >Price</th>
                        <th>Amount</th>
                        <th>Profit</th>
                        <th class="right-border">Distance</th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="8" class="left-border right-border"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gridData->goods->$goodType as $good => $goodData)
                        <tr class="text-center">
                            <td class="left-border">{{ ucfirst($good) }}</td>
                            <td class="left-border">{{ number_format($goodData->store->orders->avgPrice) }}</td>
                            <td>{{ number_format($goodData->store->offers->avgPrice) }}</td>
                            <td>{{ number_format($goodData->store->orders->amount) }}</td>
                            <td class="right-border">{{ number_format($goodData->store->offers->amount) }}</td>
                            <!-- order from -->
                            <td class="left-border">{{ $goodData->orderFrom->tradeZoneTitle }}</td>
                            <td>{{ number_format($goodData->orderFrom->bestValue)  }}</td>
                            <td>{{ number_format($goodData->orderFrom->bestAmount) }}</td>
                            <td>{{ number_format($goodData->orderFrom->profit) }}</td>
                            <td class="right-border">{{ $goodData->orderFrom->distance }}</td>
                            <!-- offer to -->
                            <td class="left-border">{{ $goodData->offerTo->tradeZoneTitle }}</td>
                            <td>{{ number_format($goodData->offerTo->bestValue) }}</td>
                            <td>{{ number_format($goodData->offerTo->bestAmount) }}</td>
                            <td>{{ number_format($goodData->offerTo->profit) }}</td>
                            <td class="right-border">{{ number_format(round($goodData->offerTo->distance/1000, 2)) }} KM</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @php $specialClasses = 'hide'; @endphp
    @endforeach
</div>
