@php

@endphp
<x-jet-dropdown align="left" width="48">
    <x-slot name="trigger">
        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
            <span class="{{ $generalStaleClass }}" title="{{ $generalStaleness }} minutes old">{{ __('Data Status') }}</span>
        </button>
        <div class="ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="block px-4 py-2 text-xs text-gray-400">
            <span class="{{ $dbStaleClass }}">{{ __('Remote Import') }}: {{ $dbStaleness }} minutes ago</span>
        </div>
        <div class="block px-4 py-2 text-xs text-gray-400">
            <span class="{{ $syncStaleClass }}">{{ __('Internal Sync') }}: {{ $syncStaleness }} minutes ago</span>
        </div>
    </x-slot>
 </x-jet-dropdown>

