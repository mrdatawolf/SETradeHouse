<?php

namespace App\Console\Commands;

use App\Components;
use App\GoodTypes;
use App\Http\Controllers\Trends as TrendsController;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Trends;
use Illuminate\Console\Command;

class GatherTrendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:trends { good_type_id }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather data from the transactions (active and inactive) to make updated trend data';

    protected $goodTypeId;
    protected $goodId;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->goodTypeId   = (int) $this->argument('good_type_id');
        switch($this->goodTypeId) {
            case 1 :
            $ids = Ores::pluck('id');
            break;
            case 2 :
                $ids = Ingots::pluck('id');
                break;
            case 3 :
                $ids = Components::pluck('id');
                break;
            case 4 :
                $ids = Tools::pluck('id');
                break;
        }

        foreach($ids as $id) {
            $trends     = new TrendsController();
            $trendsData = $trends->getTrends($this->goodTypeId, $id, false);
            foreach ($trendsData as $row) {
                foreach ($row as $month => $rowdatum) {
                    foreach ($rowdatum as $day => $monthdatum) {
                        foreach ($monthdatum as $hour => $daydatum) {
                            Trends::firstOrCreate([
                                'goodTypeId' => $this->goodTypeId,
                                'goodId'     => $id,
                                'month'      => $month,
                                'day'        => $day,
                                'hour'       => $hour
                            ], [
                                    'value'                   => $daydatum->value,
                                    'amount'                  => $daydatum->value,
                                    'orderAmount'             => $daydatum->orderAmount,
                                    'offerAmount'             => $daydatum->offerAmount,
                                    'average'                 => $daydatum->average,
                                    'count'                   => $daydatum->count,
                                    'orderAmountLatestMinute' => $daydatum->orderAmountLatestMinute,
                                    'offerAmountLatestMinute' => $daydatum->offerAmountLatestMinute,
                                ]);
                        }
                    }
                }
            }
        }
    }


}
