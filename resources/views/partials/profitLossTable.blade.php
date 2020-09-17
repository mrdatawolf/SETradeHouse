@php $specialClasses = 'show active';  $specialClasses2 = 'show active'; @endphp
<style>
    td {
        padding-right: 1em;
    }
    .serverGroup, .left-border, .right-border {
        border: 1px solid #ccc;
    }
    .left-border, .right-border {
        border-top: 0;
        border-bottom: 0;
    }
    .serverGroup {
        border-bottom: 0;
        text-align: center;
    }
    .left-border {
        border-right: 0;

    }
    .right-border {
        border-left: 0;
    }
    .negative {
        color: red;
    }
    .diffNote {
        font-size: smaller;
        font-style: italic;
    }
</style>
<ul class="nav nav-tabs">
    @php $active = 'active'; @endphp
    @foreach($gridData['Data'] as $group => $groupData)
            <li class="nav-item">
                <a href="#{{ $idName }}_{{ $group }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $group }}</a>
            </li>
            @php $active = ''; @endphp
    @endforeach
</ul>
<div class="tab-content">
@foreach($gridData['Data'] as $group => $groupData)
    <div class="tab-pane fade {{ $specialClasses }}" id="{{ $idName }}_{{ $group }}">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Offers" class="nav-link active" data-toggle="pill">Offers</a>
            </li>
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Orders" class="nav-link" data-toggle="pill">Orders</a>
            </li>
        </ul>
        <div class="tab-content">
            @foreach(['Offers', 'Orders'] as $transactionType)
                <div class="tab-pane fade {{ $specialClasses2 }}" id="{{ $idName }}_{{ $group }}_{{ $transactionType }}">
                    <table class="table-striped table-responsive-xl transaction-table" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th></th>
                                <th colspan="3">Average Prices</th>
                                <th></th>
                                <th>Store</th>
                                <th colspan="2"></th>
                                <th></th>
                            </tr>
                            <tr class="text-center">
                                <th class="text-left">Name</th>
                                <th title="This stores average price based on all of it's {{ $transactionType }} transactions">Store</th>
                                <th title="Servers average price based on all of the {{ $transactionType }} transactions">Server</th>
                                <th title="Difference between the store and servers average transaction prices">+/-</th>
                                <th title="How many of the goods the store has said it has put up" class="right-border">Transaction(s)</th>
                                <th title="The stores average Offer transacations versus the stores Orders transactions">Avg Loss</th>
                                <th title="If someone bought this from you and sold it back how much would you lose.">Exposure</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupData[$transactionType] as $item => $itemData)
                            @php
                                $storeAmount            = $gridData['Totals'][$group][$transactionType][$item]['Amount'] ?? 0;
                                $storeAvgPrice          = $gridData['Averages'][$group][$transactionType][$item]['Price']?? 0;
                                $storeAvgOfferPrice     = $gridData['Averages'][$group]['Offer'][$item]['Price']?? 0;
                                $storeAvgOrderPrice     = $gridData['Averages'][$group]['Order'][$item]['Price']?? 0;
                                $groupAvgPrice          = $globalAverages[$group][$transactionType][$item]['average'] ?? 0;
                                $globalOrdersAverages   = $globalAverages[$group]['Orders'][$item]['average'] ?? 0;
                                $globalOffersAverages   = $globalAverages[$group]['Offers'][$item]['average'] ?? 0;
                                $oppositeAvgPrice       = ($transactionType === 'Offers') ? $globalOrdersAverages : $globalOffersAverages;
                                $diffPrice              = ($groupAvgPrice === 0) ? 0 : $storeAvgPrice - $groupAvgPrice;
                                $plValue                = $storeAvgOfferPrice - $storeAvgOrderPrice;
                                $exposure               = $plValue * $storeAmount;
                                $diffPriceClass         = ($diffPrice < 0)  ? 'negative' : '';
                                $plPriceClass           = ($plValue   < 0)  ? 'negative' : '';
                                $exposureClass          = ($exposure  < 0)  ? 'negative' : '';
                                //format for display
                                 $diffPriceFormatted    = ($diffPrice < 0) ? "(" . number_format(abs($diffPrice)) . ")" : number_format($diffPrice);
                                 $plValueFormatted      = ($plValue < 0) ? "(" . number_format(abs($plValue)) . ")" : number_format($plValue);
                                 $exposureFormatted     = ($exposure < 0) ? "(" . number_format(abs($exposure)) . ")" : 0;
                            @endphp
                            <tr class="text-right">
                                <td class="text-left">{{ ucfirst($item) }}</td>
                                <td>{{ number_format( $storeAvgPrice) }}</td>
                                <td>{{ number_format($groupAvgPrice) }}</td>
                                <td><span class="diffNote {{ $diffPriceClass }}">{{ $diffPriceFormatted }}</span></td>
                                <td class="right-border">{{ number_format($storeAmount) }}</td>
                                <td><span class="diffNote {{ $plPriceClass }}">{{ $plValueFormatted }}</span></td>
                                <td><span class="diffNote {{ $exposureClass }}">{{ $exposureFormatted }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @php $specialClasses2 = 'hide'; @endphp
            @endforeach
        </div>
    </div>
    @php $specialClasses = 'hide'; @endphp
@endforeach
</div>
