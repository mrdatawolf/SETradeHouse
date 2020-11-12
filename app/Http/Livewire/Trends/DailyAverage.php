<?php namespace App\Http\Livewire\Trends;

use App\Models\Trends;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class DailyAverage extends Component
{
    public $trendDailyAvg;
    public $trendDailyLabels;
    public $types = ['amount', 'sum', 'count', 'average'];

    public $colors = [
        'amount' => '#f6ad55',
        'sum' => '#fc8181',
        'count' => '#90cdf4',
        'average' => '#66DA26'
    ];
    public $firstRun = true;

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];

    public function handleOnPointClick($point)
    {
        dd($point);
    }

    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }

    public function handleOnColumnClick($column)
    {
        dd($column);
    }


    public function render() {
        $expenses = Trends::where('transaction_type_id', 1)->where('good_type_id', 1)->where('good_id')->get();
        $lineChartModel = $expenses
            ->reduce(function (LineChartModel $lineChartModel, $data) use ($expenses) {
                $index = $expenses->search($data);

                $amountSum = $expenses->take($index + 1)->sum('amount');

                if ($index == 6) {
                    $lineChartModel->addMarker(7, $amountSum);
                }

                if ($index == 11) {
                    $lineChartModel->addMarker(12, $amountSum);
                }

                return $lineChartModel->addPoint($index, $amountSum, ['id' => $data->id]);
            }, (new LineChartModel())
                ->setTitle('Expenses Evolution')
                ->setAnimated($this->firstRun)
                ->withOnPointClickEvent('onPointClick')
            );
        $this->firstRun = false;

        return view('livewire.trends.daily-average')->with(['lineChartModel' => $lineChartModel]);
    }
}
