<div>
    <div>
        <span>
            <label for="set_amount" title="Changing this resets the values on Amount for sale.">Override all amounts: </label>
            <input wire:model="amount" id="set_amount" type="text">
        </span>
        <span>
            <label for="set_modifier" title="Changing this resets the value on Price Per.">Base Value Modifier: </label>
            <input wire:model="modifier" id="set_modifier" type="text">
        </span>
    </div>
    <div>
        <table style="margin-top: 5em; font-size: smaller; padding-bottom: .1em" class="table table-bordered table-striped table-condensed">
            <thead>
            <tr>
                <th>Name</th>
                <th>Price Per</th>
                <th>Amount for sale</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods as $good)
                <tr>
                    <td>{{ ucfirst($good->title) }}</td>
                    <td>
                        @livewire('transactions.builder.row-value', ['good' => $good, 'modifier' => $modifier], key('value'.$good->id))
                    </td>
                    <td>
                        @livewire('transactions.builder.row-amount', ['amount' => $amount], key('amount'.$good->id))
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div>
        @livewire('transactions.builder.csv-area', ['goods' => $goods, 'modifier' => $modifier, 'amount' => $amount, 'transactionType' => $transactionType], key('areaKey'))
    </div>
</div>
