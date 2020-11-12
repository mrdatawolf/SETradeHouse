<?php namespace App\Http\Livewire\Worlds;

use App\Models\Worlds;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DataTable extends LivewireDatatable
{
    public $model = Worlds::class;

    function columns()
    {
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id'),
            Column::name('title')->label('Name'),
            Column::name('short_name')->label('Short Name'),
            NumberColumn::name('server_id')->label('Server Id'),
            NumberColumn::name('type_id')->label('Type Id'),
            NumberColumn::name('system_stock_weight')->label('system_stock_weight'),
            NumberColumn::name('rarity')->label('rarity'),
            DateColumn::name('created_at')->label('Creation Date'),
            DateColumn::name('updated_at')->label('Updated Date')
        ];
    }
}
