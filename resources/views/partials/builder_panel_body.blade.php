<div class="panel-heading">
    <H2>{{ $header }}</H2>
    <div class="pull-right">
        <label for="set_amount">Override all amounts: </label><input id="set_amount" name="set_amount" type="text" value="{{ $defaultAmount }}"> <label for="set_modifier">Base Value Modifier: </label><input id="set_modifier" name="set_modifier" type="text" value="{{ $defaultMultiplier }}" readonly>
    </div>
    <div>
        <button onclick="exportTableTo('false', '{{ $transaction.'_'.$type.'.csv' }}', 'csv')">Make CSV File</button>
    </div>
</div>
<div class="panel-body">
    <table style="margin-top: 5em; font-size: smaller" class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Name</th>
            <th>Item</th>
            <th>Store Type</th>
            <th>Price Per</th>
            <th>Amount for sale</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            @if($item->se_name !== 'fillme')
                @if($item->getScarcityAdjustedValue() > 0 && $defaultMultiplier > 0)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->se_name }}</td>
                        <td>{{ ucfirst($type) }}</td>
                        <td><span class="value editable">{{ round($item->getScarcityAdjustedValue()*$defaultMultiplier) }}</span></td>
                        <td><span class="amount editable">{{ $defaultAmount }}</span></td>
                    </tr>
                @endif
            @endif
        @endforeach
        </tbody>
    </table>
</div>
