<?php

namespace App\Console\Commands;

use App\Components;
use App\Http\Controllers\Trends as TrendsController;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Trends;
use Illuminate\Console\Command;

class AlignTrendData extends Command
{
    /**
     * The name and signature of the console command. (order is trans id 1 offer is trans id 2
     *
     * @var string
     */
    protected $signature = 'align:trends { transactionTypeId } { goodTypeId } { --goodId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather data from the transactions (active and inactive) to make updated trend data';

    protected $transactionTypeId;
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
        $this->transactionTypeId = (int)$this->argument('transactionTypeId');
        $this->goodTypeId        = (int)$this->argument('goodTypeId');
        $this->goodId            = ($this->option('goodId')) ?? null;
        if ( ! empty($this->goodId)) {
            $ids = [$this->goodId];
        } else {
            switch ($this->goodTypeId) {
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

        if(!empty($ids)) {
            foreach ($ids as $id) {
                $this->output->note('goodTypeId: ' . $this->goodTypeId . ' goodId: ' . $id);
                $trends     = new TrendsController();
                $trendsData = $trends->getRawTrends($this->transactionTypeId, $this->goodTypeId, $id, false);
                foreach ($trendsData as $row) {
                    Trends::firstOrCreate([
                        'transaction_type_id' => $this->transactionTypeId,
                        'type_id'             => $this->goodTypeId,
                        'good_id'             => $id,
                        'month'               => $row->month,
                        'day'                 => $row->day,
                        'hour'                => $row->hour
                    ], [
                        'sum'           => $row->sum,
                        'amount'        => $row->amount,
                        'average'       => ($row->sum === 0 && $row->amount === 0) ? 0 : $row->sum / $row->amount,
                        'count'         => $row->count,
                        'latest_minute' => 0,
                    ]);
                }
            }
        } else {
            $message = 'No ids found for '. $this->goodTypeId . ' good id was '. $this->goodId;
            \Log::error($message);
        }
    }

}
