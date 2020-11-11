<div>
    <div>
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="select-planet">
            Planet:
        </label>
        <select wire:model="planetId" wire:change="planetIdChanged" class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="select-planet">
            @foreach($planets as $thisPlanet)
                <option value="{{ $thisPlanet->id }}">{{ ucfirst($thisPlanet->title) }}</option>
            @endforeach
        </select>
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="cargo-mass">
            Mass of Cargo (kg):
        </label>
        <input wire:model="cargoMass" wire:change="cargoMassChanged" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="cargo-mass" type="text">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="dry-weight">
            Dry Weight (Mass of Ship in kg):
        </label>
        <input wire:model="dryMass" wire:change="dryMassChanged" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="dry-weight" type="text">
    </div>
</div>
