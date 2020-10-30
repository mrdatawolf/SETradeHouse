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
            <th>{{ $rarityPercentages->where('title', 'common')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'uncommon')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'gold')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'platinum')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'uranium')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'naquandah')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'neutronium')->first()['percentage'] ?? 0 }}%</th>
            <th>{{ $rarityPercentages->where('title', 'trinium')->first()['percentage'] ?? 0 }}%</th>
        </tr>
        <tr>
            <th colspan="8" style="background-color: #0e9f6e !important;">==Current amounts on {{ $this->worldsCount }} worlds==</th>
        </tr>
        <tr>
            <th>{{ $rarity->where('title', 'common')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'uncommon')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'gold')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'platinum')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'uranium')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'naquandah')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'neutronium')->first()['total'] ?? 0 }}</th>
            <th>{{ $rarity->where('title', 'trinium')->first()['total'] ?? 0 }}</th>
        </tr>
    </table>
</div>
