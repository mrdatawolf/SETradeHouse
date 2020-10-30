<div style="font-size: smaller">
    <div class="block px-4 py-2 text-xs text-gray-400">
        <span class="{{ $dbStaleClass }}">{{ __('Remote Import') }}: {{ $dbStaleness }} minutes ago</span>
    </div>
    <div class="block px-4 py-2 text-xs text-gray-400">
        <span class="{{ $syncStaleClass }}">{{ __('Internal Sync') }}: {{ $syncStaleness }} minutes ago</span>
    </div>
</div>

