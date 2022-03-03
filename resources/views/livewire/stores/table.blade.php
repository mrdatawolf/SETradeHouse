<?php
if(! function_exists ('bd_nice_number')) {
    /**
     * @param $n
     * @param bool $showM
     * @param int $roundTo
     * Output easy-to-read numbers
     * by james at bandit.co.nz
     *
     * @return false|string
     */
    function bd_nice_number($n, bool $showM = true, int $roundTo = 0) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));

        // is this a number?
        if(!is_numeric($n)) return false;

        // now filter it;
        if($n>1000000000000) return number_format(round(($n/1000000000000),$roundTo)).' T';
        elseif($n>1000000000) return number_format(round(($n/1000000000),$roundTo)).' B';
        elseif($n>1000000 && $showM) return number_format(round(($n/1000000),$roundTo)).' M';
        elseif($n>1000) return number_format(round(($n/1000),$roundTo)).' K';

        return number_format($n);
    }
}
?>
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
        <th class="right-border">Order<br>Amount</th>
        <th>Offer<br>Prices</th>
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
    <?php $goodRow = json_decode($goodRow); ?>
    @foreach($goodRow->Goods->$goodType as $good => $goodData)
        <tr class="text-center @if($goodData->orderFrom->profit > 0 || $goodData->offerTo->profit > 0) draw_attention_border @endif">
            <td class="left-border @if($goodData->orderFrom->profit > 0 || $goodData->offerTo->profit > 0) draw_attention @endif">{{ ucfirst($good) }}</td>
            <td class="left-border" title="{{ $goodData->store->orders->avgPrice }}">{{ bd_nice_number($goodData->store->orders->avgPrice, true, 2) }}</td>
            <td class="right-border" title="{{ $goodData->store->orders->amount }}">{{ bd_nice_number($goodData->store->orders->amount) }}</td>
            <td title="{{ $goodData->store->offers->avgPrice }}">{{ bd_nice_number($goodData->store->offers->avgPrice, true, 2) }}</td>
            <td class="right-border" title="{{ $goodData->store->offers->amount }}">{{ bd_nice_number($goodData->store->offers->amount) }}</td>
            <!-- order from -->
            <td class="left-border">{{ $goodData->orderFrom->tradeZoneTitle }}</td>
            <td title="{{ $goodData->orderFrom->bestValue }}">{{ bd_nice_number($goodData->orderFrom->bestValue, true, 2) }}</td>
            <td title="{{ $goodData->orderFrom->bestAmount }}">{{ bd_nice_number($goodData->orderFrom->bestAmount) }}</td>
            <td class=" @if($goodData->orderFrom->profit > 0) draw_attention @endif" title="{{ $goodData->orderFrom->profit }}">{{ bd_nice_number($goodData->orderFrom->profit, true, 2) }}</td>
            <td class="right-border" title="{{ $goodData->orderFrom->distance }}">{{ bd_nice_number(round($goodData->orderFrom->distance), false) }}M</td>
            <!-- offer to -->
            <td class="left-border">{{ $goodData->offerTo->tradeZoneTitle }}</td>
            <td title="{{ $goodData->offerTo->bestValue }}">{{ bd_nice_number($goodData->offerTo->bestValue, true, 2) }}</td>
            <td title="{{ $goodData->offerTo->bestAmount }}">{{ bd_nice_number($goodData->offerTo->bestAmount) }}</td>
            <td class="@if($goodData->offerTo->profit > 0) draw_attention @endif" title="{{ $goodData->offerTo->profit }}">{{ bd_nice_number($goodData->offerTo->profit, true, 2) }}</td>
            <td class="right-border" title="{{ $goodData->offerTo->distance }}">{{ bd_nice_number(round($goodData->offerTo->distance), false) }}M</td>
        </tr>
    @endforeach
    </tbody>
</table>
