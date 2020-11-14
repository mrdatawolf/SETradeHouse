<?php namespace App\Http\Livewire\Trends;

use App\Models\Ammo;
use App\Models\Bottles;
use App\Models\Components;
use App\Models\GoodTypes;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\TransactionTypes;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Trends;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class Charts extends Component
{
    public $transactionTypeId;
    public $goodTypeId;
    public $goodId;
    public $fromDate;
    public $toDate;
    public $types    = ['average', 'amount'];
    public $colors   = ['average' => '#66DA26', 'sum' => '#fc8181', 'count' => '#f6ad55', 'amount' => '#cbd5e0'];
    public $transactionTypes;
    public $goodTypes;
    public $goods;
    public $firstRun = true;

    protected $listeners = [
        'onPointClick'  => 'handleOnPointClick',
        'onSliceClick'  => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];


    public function mount()
    {
        $this->transactionTypes  = TransactionTypes::orderBy('id')->get();
        $this->goodTypes         = GoodTypes::orderBy('id')->get();
        $this->transactionTypeId = 1;
        $this->goodTypeId        = 1;
        $this->goodId            = 1;
        $this->fromDate          = Carbon::now()->subDays(1)->toDateString();
        $this->toDate            = Carbon::now()->toDateString();

        $this->gatherGoods();
    }


    public function render()
    {
        $fromDate = Carbon::createFromDate($this->fromDate)->startOfDay();
        $toDate = Carbon::createFromDate($this->toDate)->endOfDay();
        $trends                = Trends::where('transaction_type_id', $this->transactionTypeId)
                                       ->where('type_id', $this->goodTypeId)
                                       ->where('good_id', $this->goodId)
                                       ->whereBetween('dated_at', [$fromDate, $toDate])
                                       ->get();
        $lineChartModelAverage = $this->makeLineChartModel('average', $trends);
        $lineChartModelAmount  = $this->makeLineChartModel('amount', $trends);
        $lineChartModelSum     = $this->makeLineChartModel('sum', $trends);
        $lineChartModelCount   = $this->makeLineChartModel('count', $trends);

        $this->firstRun = false;

        return view('livewire.trends.charts')->with([
            'lineChartModelAverage' => $lineChartModelAverage,
            'lineChartModelAmount'  => $lineChartModelAmount,
            'lineChartModelSum'     => $lineChartModelSum,
            'lineChartModelCount'   => $lineChartModelCount,
        ]);
    }


    private function makeLineChartModel($type, $trends)
    {
        return (in_array($type, $this->types)) ? $trends->reduce(function (LineChartModel $lineChartModel, $data) use (
            $trends,
            $type
        ) {
            $index   = $data->dated_at->toDateString();
            $average = (int)$data->$type;

            return $lineChartModel->addPoint($index, $average, ['id' => $index]);
        }, (new LineChartModel())->setAnimated($this->firstRun)->withOnPointClickEvent('onPointClick')) : null;
    }


    public function handleOnPointClick($point)
    {
        $this->fromDate          = Carbon::createFromDate($point['title'])->toDateString();
        $this->toDate            = Carbon::createFromDate($point['title'])->toDateString();
    }


    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }


    public function handleOnColumnClick($column)
    {
        dd($column);
    }


    public function transactionTypeIdChange($value)
    {
        $this->transactionTypeId = $value;
    }


    public function updatedGoodTypeId($value)
    {
        $this->goodTypeId = $value;
        $this->resetGoodId();
        $this->gatherGoods();
    }


    public function goodIdChange($value)
    {
        $this->goodId = $value;
    }


    public function resetGoodId()
    {
        $this->goodId = 1;
    }


    public function gatherGoods()
    {
        switch ($this->goodTypeId) {
            case '2' :
                $this->goods = Ingots::select('id', 'title')->orderBy('id')->get();
                break;
            case '1' :
                $this->goods = Ores::select('id', 'title')->orderBy('id')->get();
                break;
            case '3' :
                $this->goods = Components::select('id', 'title')->orderBy('id')->get();
                break;
            case '4' :
                $this->goods = Tools::select('id', 'title')->orderBy('id')->get();
                break;
            case '5' :
                $this->goods = Ammo::select('id', 'title')->orderBy('id')->get();
                break;
            case '6' :
                $this->goods = Bottles::select('id', 'title')->orderBy('id')->get();
                break;
            default:
                $this->goods = Tools::select('id', 'title')->orderBy('id')->get();
        }
    }
}
