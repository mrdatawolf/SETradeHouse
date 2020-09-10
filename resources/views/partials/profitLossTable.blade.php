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
                                <th class="text-left">Name</th>
                                <th title="This stores averages price based on all of it's {{ $transactionType }}">Store Avg Price</th>
                                <th title="Servers average price based on all of the {{ $transactionType }}">Server Avg Price</th>
                                <th title="Difference between the store and server average price">Diff</th>
                                <th title="How many of the goods the store has said it has put up" class="right-border">Store Transaction(s)</th>
                                <th title="The stores average price versus the servers opposite transactions">Avg P/L</th>
                                <th title="The average p/l times the amount of the good">Exposure</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupData[$transactionType] as $item => $itemData)
                            @php
                                $diffPriceFormatted = "";
                                $plValueFormatted = "";
                                $exposureFormatted = "";
                                $storeAmount            = $gridData['Totals'][$group][$transactionType][$item]['Amount'] ?? 0;
                                $storeAvgPrice          = $gridData['Averages'][$group][$transactionType][$item]['Price']?? 0;
                                $groupAvgPrice          = $globalAverages[$group][$transactionType][$item]['average'] ?? 0;
                                $globalOrdersAverages   = $globalAverages[$group]['Orders'][$item]['average'] ?? 0;
                                $globalOffersAverages   = $globalAverages[$group]['Offers'][$item]['average'] ?? 0;
                                $opositeAvgPrice        = ($transactionType === 'Offers') ? $globalOrdersAverages : $globalOffersAverages;
                                $diffPrice              = ($groupAvgPrice === 0) ? 0 : $storeAvgPrice - $groupAvgPrice;
                                $plValue                = $storeAvgPrice - $opositeAvgPrice;
                                $exposure               = $plValue * $storeAmount;
                                $diffPriceClass         = ($diffPrice < 0)  ? 'negative' : '';
                                $plPriceClass           = ($plValue   < 0)  ? 'negative' : '';
                                $exposureClass          = ($exposure  < 0)  ? 'negative' : '';
                                //format for display
                                if($diffPrice < 0) {
                                     $diffPriceFormatted = "(" . number_format(abs($diffPrice)) . ")";
                                } elseif($diffPrice > 0) {
                                    $diffPriceFormatted = number_format($diffPrice);
                                }
                                if($plValue < 0) {
                                     $plValueFormatted = "(" . number_format(abs($plValue)) . ")";
                                } elseif($plValue > 0) {
                                    $plValueFormatted = number_format($plValue);
                                }
                                if($exposure < 0) {
                                     $exposureFormatted = "(" . number_format(abs($exposure)) . ")";
                                } elseif($exposure > 0) {
                                    $exposureFormatted = number_format($exposure);
                                }
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
