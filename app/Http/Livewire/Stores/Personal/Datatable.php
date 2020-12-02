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

    public $goodId;
    public $goodTypeId;

    public function builder()
    {
        $tzQuery = Transactions::query();

        return $tzQuery->with('tradezone');
    }

    /**
     * @return array|mixed
     */
    public function columns()
    {
        return [
            Column::name('owner')->filterable()->label('Owner')->sortBy('owner'),
            Column::callback(['trade_zone_id'], function ($id) {
                return TradeZones::find($id)->title;
            })->label('Trade Zone'),
            Column::callback(['world_id'], function ($id) {
                return Worlds::find($id)->title;
            })->label('World'),
            Column::callback(['server_id'], function ($id) {
                return Worlds::find($id)->title;
            })->label('Server'),
            Column::callback(['transaction_type_id'], function ($id) {
                return ucfirst(TransactionTypes::find($id)->title);
            })->label('Transaction Type'),
            Column::callback(['good_type_id'], function ($id) {
                $this->goodTypeId = $id;
                return GoodTypes::find($id)->title;
            })->label('Good Type'),
            Column::callback(['good_id'], function ($id) {
                $this->goodId = $id;
                return $this->getGoods()->title;
            })->label('Good Name'),
            NumberColumn::name('value')->label('Value'),
            NumberColumn::name('amount')->label('Amount'),
            DateColumn::name('created_at')->format('m/d/y')->label('Created At'),

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


    public function getGoods() {
        return $this->getGoodFromGoodtypeIdAndGoodId($this->goodTypeId, $this->goodId);
    }
}

