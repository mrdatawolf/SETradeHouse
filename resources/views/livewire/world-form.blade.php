<div>
    @livewire('server.worlds.status-table')
    <form wire:submit.prevent="saveWorld">
        <div class="form-group">
            <label for="inputName" title="Name of the world being added">Title</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Enter title" wire:model="title"wire:change="titleChange">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="inputShortName" title="Short version of the worlds name... maybe 3 characters long">Short Name</label>
            <input type="text" class="form-control" id="inputShortName" placeholder="Enter short title" wire:model="shortName">
            @error('shortName') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="inputServerId" title="This is the server you are adding the world to. this is set for you.">Server ID</label>
            <input type="text" class="form-control" id="inputServerId" value="{{ $serverId }}" wire:model="serverId" readonly>
            @error('serverId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="inputTypeId" title="The world type. A single world can only have a limited ore selection. Here you pick the special ore.">World Type</label>
            <select id="inputTypeId" class="form-control" wire:model="worldTypes.id">
                <option value="">-- Select World Type --</option>
                @foreach($worldTypes as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('worldTypes') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="inputWorldRarityTypesAllowed" title="The world rarity type. A single world can only have a limited ore selection. Here you pick the special ore, if available.">Rare resource</label>
            <select id="inputWorldRarityTypesAllowed" class="form-control" wire:model="rarityTypesAllowed.id">
                <option value="">-- Select Resource Type --</option>
                @foreach($rarityTypesAllowed as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('rarityTypesAllowed') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="inputSystemStockWeight" title="This decides how much weight the local system resources have on the automated pricing. For now read only">System Stock Weight</label>
            <input type="text" class="form-control" id="inputSystemStockWeight" value="1" wire:model="systemStockWeight" readonly>
            @error('systemStockWeight') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save World</button>
    </form>
</div>
