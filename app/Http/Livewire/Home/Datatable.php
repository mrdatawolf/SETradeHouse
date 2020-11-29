<?php namespace App\Http\Livewire\Home;

use App\Models\TradeZones;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Datatable extends LivewireDatatable
{
    public $model = TradeZones::class;

    /**
     * @return array|mixed
     */
    public function columns()
    {
        return [
            Column::name('title')->sortBy('title')->label('Name')->sortBy('title'),
            Column::name('owner')->label('Owner'),
            Column::name('gps')->label('GPS')
        ];
    }
}
