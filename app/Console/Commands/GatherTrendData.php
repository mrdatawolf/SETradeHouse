<?php

namespace App\Console\Commands;

use App\Components;
use App\Http\Controllers\Trends as TrendsController;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Trends;
use Illuminate\Console\Command;

class GatherTrendData extends Command
{
    /**
     * The name and signature of the console command. (order is trans id 1 offer is trans id 2
     *
     * @var string
     */
    protected $signature = 'gather:trends { transaction_type_id } { type_id } { --goodId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather data from the transactions (active and inactive) to make updated trend data';

    protected $transactionTypeId;
    protected $typeId;
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
        $this->transactionTypeId = (int)$this->argument('transaction_type_id');
        $this->typeId        = (int)$this->argument('type_id');
        $this->goodId            = ($this->option('goodId')) ? $this->option('goodId') : null;
        if ( ! empty($this->goodId)) {
            $ids = [$this->goodId];
        } else {
            switch ($this->typeId) {
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
        }

        foreach ($ids as $id) {
            $trends     = new TrendsController();
            $trendsData = $trends->getRawTrends($this->transactionTypeId, $this->typeId, $id, false);
            foreach ($trendsData as $goodId => $row) {
                foreach ($row as $month => $rowdatum) {
                    foreach ($rowdatum as $day => $monthdatum) {
                        foreach ($monthdatum as $hour => $daydatum) {
                            Trends::firstOrCreate([

                                'transaction_type_id' => $this->transactionTypeId,
                                'type_id'        => $this->typeId,
                                'good_id'             => $id,
                                'month'               => $month,
                                'day'                 => $day,
                                'hour'                => $hour
                            ], [
                                'sum'           => $daydatum->sum,
                                'amount'        => $daydatum->amount,
                                'average'       => ($daydatum->sum === 0 && $daydatum->amount === 0) ? 0 : $daydatum->sum / $daydatum->amount,
                                'count'         => $daydatum->count,
                                'latest_minute' => $daydatum->latestMinute,
                            ]);
                        }
                    }
                }
            }
        }
    }

}
