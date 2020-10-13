<div>
    <table class="table-striped table-responsive-xl border">
        <tr class="text-center">
            <th>Common</th>
            <th>UnCommon</th>
            <th colspan="3">Rare</th>
            <th colspan="3">UltraRare</th>
        </tr>
        <tr class="text-center">
            <th colspan="2">&nbsp;</th>
            <th>Gold</th>
            <th>Platinum</th>
            <th>Uranium</th>
            <th>Naquandah</th>
            <th>Neutronium</th>
            <th>Trinium</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #0e9f6e !important;">==Desired percentages==</th>
        </tr>
        <tr>
            <th>{{ $ratio->common }}%</th>
            <th>{{ $ratio->uncommon }}%</th>
            <th>{{ $ratio->rare }}%</th>
            <th>{{ $ratio->rare }}%</th>
            <th title="Uranium can only be gathered from asteroid worlds">{{ $ratio->rare * 2 }}% *</th>
            <th>{{ $ratio->ultra_rare }}%</th>
            <th>{{ $ratio->ultra_rare }}%</th>
            <th>{{ $ratio->ultra_rare }}%</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #0e9f6e !important;">==Current percentages for world types==</th>
        </tr>
        <tr>
            <th>{{ $this->rarityPercentages->where('title', 'common')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'uncommon')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'gold')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'platinum')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'uranium')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'naquandah')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'neutronium')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $this->rarityPercentages->where('title', 'trinium')->first()['percentage'] ?? 0 }}%</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #0e9f6e !important;">==Current amounts on {{ $worldsCount }} worlds==</th>
        </tr>
        <tr>
            <th>{{ $this->rarity->where('title', 'common')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'uncommon')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'gold')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'platinum')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'uranium')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'naquandah')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'neutronium')->first()['total'] ?? 0 }}</th>
            <th>{{ $this->rarity->where('title', 'trinium')->first()['total'] ?? 0 }}</th>
        </tr>
    </table>
</div>

<form wire:submit.prevent="submit">
    <div class="form-group">
        <label for="inputName" title="Name of the world being added">Title</label>
        <input type="text" class="form-control" id="inputTitle" placeholder="Enter title" wire:model="title">
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
        <select id="inputTypeId" class="form-control" wire:model="worldTypesAllowed">
            @foreach($worldTypesAllowed as $id => $type)
                <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('typeId') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="inputSystemStockWeight" title="This decides how much weight the local system resources have on the automated pricing. For now read only">System Stock Weight</label>
        <input type="text" class="form-control" id="inputSystemStockWeight" value="1" wire:model="systemStockWeight" readonly>
        @error('systemStockWeight') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save World</button>
</form>
