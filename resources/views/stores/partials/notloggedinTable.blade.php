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
    @foreach(\App\GoodTypes::pluck('title') as $group)
        <div class="tab-pane fade {{ $specialClasses }}" id="{{ $gridData->jsid }}_{{ $group }}">
            @if(! empty($gridData->$group))
                <table class="table-striped table-responsive-xl transaction-table" style="width:100%">
                    <thead>
                    <tr class="transaction-table-groups">
                        <th class="left-border"></th>
                        <th colspan="2" class="left-border right-border storeGroup">This Store's Data</th>
                        <th colspan="4" class="left-border right-border storeGroup" title="If you sold to this store after buying from the current store.">Sell to</th>
                    </tr>
                    <tr class="transaction-table-groups text-center">
                        <th class="left-border">Name</th>
                        <th class="left-border">Order<br>Prices</th>
                        <th>Offer<br>Prices</th>
                        <!-- Offer -->
                        <th class="left-border">Name</th>
                        <th >Price</th>
                        <th>Amount</th>
                        <th class="right-border">Profit</th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="8" class="left-border right-border"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gridData->$group as $good => $goodData)
                        @php
                        $stores = new \App\Http\Controllers\Stores();
                        $ordersAvgPrice = (empty($goodData->Orders->avgPrice)) ? 0 : $goodData->Orders->avgPrice;
                        $orderAmount = (empty($goodData->Orders->amount)) ? 0 : $goodData->Orders->amount;
                        $offerAvgPrice = (empty($goodData->Offers->avgPrice)) ? 0 : $goodData->Offers->avgPrice;
                        $offerAmount = (empty($goodData->Offers->amount)) ? 0 : $goodData->Offers->amount;
                        if(! empty($goodData->Orders)) {
                            $orderGoodId = $goodData->Orders->goodId;
                            $orderGoodTypeId = $goodData->Orders->goodTypeId;
                            $orderServerId = $goodData->Orders->serverId;
                            $bestOrderFrom = $stores->getLowestOfferForGoodOnServer($orderGoodId, $goodData->Orders->goodTypeId, $orderServerId);
                            $bestOrderFromValue = (empty($bestOrderFrom->get('value'))) ? 0 : (int) $bestOrderFrom->get('value');
                            $bestOrderFromAmount = (empty($bestOrderFrom->get('amount'))) ? 0 : (int) $bestOrderFrom->get('amount');
                            $bestAvailableOrderFromAmount = ($bestOrderFromAmount < $offerAmount) ? $bestOrderFromAmount : $offerAmount;
                            $orderFromTradeZone = \App\TradeZones::find($bestOrderFrom->get('trade_zone_id'));
                        } else {
                            $bestOrderFromValue = 0;
                            $bestOrderFromAmount = 0;
                            $bestAvailableOrderFromAmount = 0;
                            $orderFromTradeZone = 'n/a';
                        }
                        if(! empty($goodData->Offers)) {
                            $offerGoodId = $goodData->Offers->goodId;
                            $offerGoodTypeId = $goodData->Offers->goodTypeId;
                            $offerServerId = $goodData->Offers->serverId;
                            $bestOfferTo = $stores->getHighestOrderForGoodOnServer($offerGoodId, $offerGoodTypeId, $offerServerId);
                            $bestOfferToValue = (empty($bestOfferTo->get('value'))) ? 0 : (int) $bestOfferTo->get('value');
                            $bestOfferToAmount = (empty($bestOfferTo->get('amount'))) ? 0 : (int) $bestOfferTo->get('amount');
                            $bestAvailableOfferToAmount = ($bestOfferToAmount < $orderAmount) ? $bestOfferToAmount : $orderAmount;
                            $offerToTradeZone = \App\TradeZones::find($bestOfferTo->get('trade_zone_id'));
                        }
                        else {
                            $bestOfferToValue = 0;
                            $bestOfferToAmount = 0;
                            $bestAvailableOfferToAmount = 0;
                            $offerToTradeZone = 'n/a';
                        }
                        $orderFromProfitRaw =($ordersAvgPrice - $bestOrderFromValue) * $bestAvailableOrderFromAmount;
                        $orderFromProfit =($orderFromProfitRaw > 0) ? $orderFromProfitRaw : 0;
                        $offerToProfitRaw = ($bestOfferToValue - $offerAvgPrice) * $bestAvailableOfferToAmount;
                        $offerToProfit = ($offerToProfitRaw > 0) ? $offerToProfitRaw : 0;
                        @endphp
                        <tr class="text-center">
                            <td class="left-border">{{ ucfirst($good) }}</td>
                            <td class="left-border">{{ (empty($ordersAvgPrice)) ? 'n/a' : number_format($ordersAvgPrice) }}</td>
                            <td>{{ (empty($offerAvgPrice)) ? 'n/a' : number_format($offerAvgPrice) }}</td>
                            <!-- offer to -->
                            <td class="left-border">{{ $offerToTradeZone->title ?? 'n/a' }}</td>
                            <td>{{ $bestOfferToValue ?? 'n/a'}}</td>
                            <td>{{ $bestOfferToAmount ?? 'n/a'}}</td>
                            <td class="right-border">{{ empty($offerToProfit) ? 'n/a' : number_format($offerToProfit) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @php $specialClasses = 'hide'; @endphp
    @endforeach
</div>
