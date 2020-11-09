<div>
    <div class="md:w-1/3">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-ship-size">
            Ship Size:
        </label>
    </div>
    <div class="md:w-2/3">
        <select wire:model="shipSize" wire:change="updatedShipSize" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-ship-size">
            <option value="small" selected>small</option>
            <option value="large">large</option>
        </select>
    </div>
</div>
