<div class="world_select">
    <label for="selectWorld" class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">Select World:</label>
    <select id="selectWorld" wire:model="worldId"  class="appearance-none block bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-2">
        @foreach($worlds as $world)
            <option value="{{ $world->id }}">{{ $world->title }}</option>
        @endforeach
    </select>
</div>
