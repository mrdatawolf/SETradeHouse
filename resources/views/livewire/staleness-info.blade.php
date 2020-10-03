@php
    $npcStorageValue = \App\Models\NpcStorageValues::latest('origin_timestamp')->first();
    $newestDbRecord = (empty($npcStorageValue->origin_timestamp)) ? 'N/A' : $npcStorageValue->origin_timestamp . ' -7';
    $dbCarbonDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$npcStorageValue->origin_timestamp, 'America/Los_Angeles');
    $dbStaleness = (int) \Carbon\Carbon::now()->diffInHours($dbCarbonDate);
    $transaction = \App\Models\Transactions::latest('updated_at')->first();
    $newestSyncRecord = (empty($transaction->updated_at)) ? 'N/A' : $transaction->updated_at->toDateTimeString() . ' +0';
    $npcCarbonDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$transaction->updated_at);
    $syncStaleness = (int) \Carbon\Carbon::now()->diffInHours($npcCarbonDate);
    $generalStaleness = 0;
    if($dbStaleness > $generalStaleness) {
        $generalStaleness = (int) $dbStaleness;
    }
    if($syncStaleness > $generalStaleness) {
        $generalStaleness = (int) $syncStaleness;
    }
    $generalStaleClass = '';
    if($generalStaleness > 2 ) {
        $generalStaleClass = 'staleError';
    } elseif($generalStaleness > 1) {
         $generalStaleClass = 'staleWarn';
    }
    $dbStaleClass = '';
    if($dbStaleness > 2 ) {
        $dbStaleClass = 'staleError';
    } elseif($dbStaleness > 1) {
         $dbStaleClass = 'staleWarn';
    }
    $syncStaleClass = '';
    if($syncStaleness > 2 ) {
        $syncStaleClass = 'staleError';
    } elseif($syncStaleness > 1) {
         $syncStaleClass = 'staleWarn';
    }
@endphp
<x-jet-dropdown align="left" width="48">
    <x-slot name="trigger">
        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
            <span class="{{ $generalStaleClass }}" title="{{ $generalStaleness }} hours old">{{ __('Data Status') }}</span>
        </button>
        <div class="ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="block px-4 py-2 text-xs text-gray-400">
            <span class="{{ $dbStaleClass }}">{{ __('Remote Import') }}: {{ $dbStaleness }} hours ago</span>
        </div>
        <div class="block px-4 py-2 text-xs text-gray-400">
            <span class="{{ $syncStaleClass }}">{{ __('Internal Sync') }}: {{ $syncStaleness }} hours ago</span>
        </div>
    </x-slot>
 </x-jet-dropdown>

