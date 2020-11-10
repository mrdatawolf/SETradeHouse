<div>
    <div class="md:w-1/3">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-ship-size">
            Thruster Size:
        </label>
    </div>
    <div class="md:w-2/3">
        <select wire:model="thrusterSize" wire:change="thrusterSizeChanged" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-thruster-size">
            @foreach($thrusterSizes as $thrusterSize)
                <option value="{{ $thrusterSize }}">{{ $thrusterSize }}</option>
            @endforeach
        </select>
    </div>
</div>
