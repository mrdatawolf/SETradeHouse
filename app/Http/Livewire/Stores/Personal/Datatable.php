<?php namespace App\Http\Livewire\Stores\Personal;

use App\Http\Traits\FindingGoods;
use App\Models\GoodTypes;
use App\Models\Servers;
use App\Models\TradeZones;
use App\Models\Transactions;
use App\Models\TransactionTypes;
use App\Models\Worlds;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Datatable extends LivewireDatatable
{
    use FindingGoods;
    public function builder()
    {
        return Transactions::query();
    }

    /**
     * @return array|mixed
     */
    public function columns()
    {
        return [
            Column::name('owner')->filterable()->label('Owner')->sortBy('owner'),
            NumberColumn::name('trade_zone_id')->filterable($this->tradezones->pluck('title'))->label('Trade Zone'),
            NumberColumn::name('world_id')->filterable($this->worlds->pluck('title'))->linkTo('Worlds')->label('World Id'),
            NumberColumn::name('server_id')->filterable($this->servers->pluck('title'))->label('Server Id'),
            NumberColumn::name('transaction_type_id')->filterable($this->transactionTypes->pluck('title'))->label('Transaction Type Id'),
            NumberColumn::name('good_id')->label('Good Id'),
            NumberColumn::name('good_type_id')->filterable($this->goodTypes->pluck('title'))->label('Good Type Id'),
            NumberColumn::name('value')->label('Value'),
            NumberColumn::name('amount')->label('Amount'),
            DateColumn::name('created_at')->label('Created At'),

        ];
    }


    public function getTradezonesProperty()
    {
        return TradeZones::all();
    }


    public function getServersProperty()
    {
        return Servers::all();
    }


    public function getWorldsProperty()
    {
        return Worlds::all();
    }


    public function getTransactionTypesProperty()
    {
        return TransactionTypes::all();
    }


    public function getGoodTypesProperty()
    {
        return GoodTypes::all();
    }


    public function getGoods($good_type_id, $good_id) {
        return $this->getGoodTitleFromGoodtypeIdAndGoodId($good_type_id, $good_id);
    }
}

