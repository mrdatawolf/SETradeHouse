<div>
    <div>
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-ship-size">
            Ship Size:
        </label>
        <select wire:model="shipSize" wire:change="shipSizeChanged" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-ship-size">
            <option value="small" selected>Small</option>
            <option value="large">Large</option>
        </select>

        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-ship-size">
            Thruster Size:
        </label>
        <select wire:model="thrusterSize" wire:change="thrusterSizeChanged" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-thruster-size">
            @foreach($thrusterSizes as $thrusterSize)
                <option value="{{ $thrusterSize }}">{{ucfirst($thrusterSize) }}</option>
            @endforeach
        </select>
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-ship-size">
            Thruster Type:
        </label>
        <select wire:model="thrusterType" wire:change="thrusterTypeChanged" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-thruster-type">
            @foreach($thrusterTypes as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
</div>
