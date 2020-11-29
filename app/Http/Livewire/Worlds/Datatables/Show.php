<?php namespace App\Http\Livewire\Worlds\Datatables;

use App\Models\Worlds;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Show extends LivewireDatatable
{
    public function builder()
    {
        //the current server id the player is set to should always limit the results.
        return Worlds::query()->where('worlds.server_id', \Auth::user()->server_id);
    }


    /**
     * @return array|mixed
     */
    public function columns()
    {
        return [
            NumberColumn::name('id')->label('ID'),
            Column::name('title')->label('Title')->sortBy('title'),
            Column::name('short_name')->label('Short Name')->sortBy('short_name'),
            Column::name('servers.title')->label('Server')->linkTo('server.title'),
            Column::name('types.title')->label('Type'),
            NumberColumn::name('rarity.title')->label('Rarity'),
            NumberColumn::name('system_stock_weight')->label('System Stock Weight'),
        ];
    }
}
