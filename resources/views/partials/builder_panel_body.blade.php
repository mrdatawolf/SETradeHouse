<div class="panel-heading">
    <div class="pull-right">
        <label for="set_amount">Override all amounts: </label><input id="set_amount" name="set_amount" type="text" value="{{ $defaultAmount }}"> <label for="set_modifier">Base Value Modifier: </label><input id="set_modifier" name="set_modifier" type="text" value="{{ $defaultMultiplier }}">
        <br><i>note: changing either of these resets the values on the column they effect. The first will update all Amounts for sale. The second will update the Price Per.</i>
    </div>
    <div>
        <button onclick="exportTableTo('false', '{{ $transactionType.'_'.$goodType.'.csv' }}', 'csv')">Make CSV File</button>
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
        @foreach($goods as $good)
            @if($good->se_name !== 'fillme')
                @if($defaultMultiplier > 0)
                    <tr>
                        <td>{{ ucfirst($good->title) }}</td>
                        <td>{{ $good->se_name }}</td>
                        <td>{{ ucfirst($transactionType) }}</td>
                        <td><span class="value editable" data-original-value="{{ round($good->getScarcityAdjustedValue()) }}">{{ round($good->getScarcityAdjustedValue()*$defaultMultiplier) }}</span></td>
                        <td><span class="amount editable">{{ $defaultAmount }}</span></td>
                    </tr>
                @endif
            @endif
        @endforeach
        </tbody>
    </table>
</div>
