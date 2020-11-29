<?php namespace App\Http\Livewire\Worlds\Datatables;

use App\Models\Worlds;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Index extends LivewireDatatable
{
    public function builder()
    {
        return Worlds::query();
    }

    /**
     * @return array|mixed
     */
    public function columns()
    {
        return [
            Column::name('title')->label('Title')->sortBy('title'),
            Column::name('short_name')->label('Short Name')->sortBy('short_name'),
            Column::name('servers.title')->label('Server'),
            Column::name('types.title')->label('Type'),
            NumberColumn::name('rarity.title')->label('Rarity'),
            NumberColumn::name('system_stock_weight')->label('System Stock Weight'),
        ];
    }
}
