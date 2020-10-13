<div>
    Desired ratios:
    <table class="table-striped table-responsive-xl">
        <tr>
            <th>Common</th>
            <th>UnCommon</th>
            <th colspan="3">Rare</th>
            <th colspan="3">UltraRare</th>
        </tr>
        <tr>
            <th>Common</th>
            <th>UnCommon</th>
            <th>Gold</th>
            <th>Platinum</th>
            <th>Uranium</th>
            <th>Naquandah</th>
            <th>Neutronium</th>
            <th>Trinium</th>
        </tr>
        <tr>
            <th>{{ $ratio->common }}</th>
            <th>{{ $ratio->uncommon }}</th>
            <th>{{ $ratio->rare }}</th>
            <th>{{ $ratio->rare }}</th>
            <th>{{ $ratio->rare * 2 }}</th>
            <th>{{ $ratio->ultra_rare }}</th>
            <th>{{ $ratio->ultra_rare }}</th>
            <th>{{ $ratio->ultra_rare }}</th>
        </tr>
    </table>
    Current amounts on {{ $worldsCount }} worlds:
    <table class="table-striped table-responsive-xl">
        <tr>
            <th>Common</th>
            <th>UnCommon</th>
            <th>Gold</th>
            <th>Platinum</th>
            <th>Uranium</th>
            <th>Naquandah</th>
            <th>Neutronium</th>
            <th>Trinium</th>
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
        <label for="inputName">Title</label>
        <input type="text" class="form-control" id="inputTitle" placeholder="Enter title" wire:model="title">
        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="inputShortName">Short Name</label>
        <input type="text" class="form-control" id="inputShortName" placeholder="Enter short title" wire:model="shortName">
        @error('shortName') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="inputServerId">Server ID</label>
        <input type="text" class="form-control" id="inputServerId" placeholder="Enter server ID" wire:model="serverId">
        @error('serverId') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="inputTypeId">Type ID</label>
        <input type="text" class="form-control" id="inputTypeId" placeholder="Enter type ID" wire:model="typeId">
        @error('typeId') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="inputSystemStockWeight">System Stock Weight</label>
        <textarea class="form-control" id="inputSystemStockWeight" placeholder="Enter Body" wire:model="systemStockWeight"></textarea>
        @error('systemStockWeight') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save World</button>
</form>
