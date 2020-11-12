<div class="container mx-auto space-y-4 p-4 sm:p-0">
    <style>
        .card {
            padding-bottom: 3em;
        }
    </style>
    <ul class="flex flex-col sm:flex-row sm:space-x-8 sm:items-center">
        <li>
            <input type="checkbox" value="average" wire:model="types" id="average-checkbox"/>
            <label for="average-checkbox" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">average</label>
        </li>
        <li>
            <input type="checkbox" value="amount" wire:model="types" id="amount-checkbox"/>
            <label for="amount-checkbox" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">amount</label>
        </li>
        <li>
            <input type="checkbox" value="sum" wire:model="types" id="sum-checkbox"/>
            <label for="sum-checkbox" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">sum</label>
        </li>
        <li>
            <input type="checkbox" value="count" wire:model="types" id="count-checkbox"/>
            <label for="count-checkbox" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">count</label>
        </li>
        <li><--- these checkboxes are very fragile right now.  When you check or uncheck wait for them to finish updating before checking the next one</li>
    </ul>
    <ul class="flex flex-col sm:flex-row sm:space-x-8 sm:items-center">
        <li>
            <label for="transactionType" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">Transaction Type</label>
            <select wire:model="transactionTypeId" id="transactionType" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                @foreach($transactionTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <label for="goodType" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">Good Type</label>
            <select wire:model="goodTypeId" id="goodType" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                @foreach($goodTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <label for="good" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">Good</label>
            <select wire:model="goodId" id="good" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                @foreach($goods as $good)
                    <option value="{{ $good->id }}" wire:key="{{ $good->id }}"  {{ ($good->id === $goodId) ? 'selected="selected"' : '' }}>{{ $good->title }}</option>
                @endforeach
            </select>
        </li>
        <li>
            <label for="from-date" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">From:</label>
            <input type="text" wire:model="fromDate" id="from-date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
        </li>
        <li>
            <label for="to-date" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="select-ship-size">To:</label>
            <input type="text" wire:model="toDate" id="to-date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
        </li>
    </ul>

    <div class="card-columns">
        @if(! empty($lineChartModelAverage))
            <div class="card">
                <div class="card-header">
                    Average
                </div>
                <div class="card-body">
                    <livewire:livewire-line-chart
                        key="{{ $lineChartModelAverage->reactiveKey() }}"
                        :line-chart-model="$lineChartModelAverage"
                    />
                </div>
            </div>
        @endif
        @if(! empty($lineChartModelAmount))
            <div class="card">
                <div class="card-header">
                    Amount
                </div>
                <div class="card-body">
                    <livewire:livewire-line-chart
                        key="{{ $lineChartModelAmount->reactiveKey() }}"
                        :line-chart-model="$lineChartModelAmount"
                    />
                </div>
            </div>
        @endif
        @if(! empty($lineChartModelSum))
            <div class="card">
                <div class="card-header">
                    Sum
                </div>
                <div class="card-body">
                    <livewire:livewire-line-chart
                        key="{{ $lineChartModelSum->reactiveKey() }}"
                        :line-chart-model="$lineChartModelSum"
                    />
                </div>
            </div>
        @endif
        @if(! empty($lineChartModelCount))
            <div class="card">
                <div class="card-header">
                    Count
                </div>
                <div class="card-body">
                    <livewire:livewire-line-chart
                        key="{{ $lineChartModelCount->reactiveKey() }}"
                        :line-chart-model="$lineChartModelCount"
                    />
                </div>
            </div>
        @endif
    </div>
</div>

