<?php

namespace App\Console\Commands;

use App\Components;
use App\Http\Controllers\Trends as TrendsController;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Trends;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AlignTrendData extends Command
{
    /**
     * The name and signature of the console command. (order is trans id 1 offer is trans id 2
     *
     * @var string
     */
    protected $signature = 'align:trends
    { --transactionTypeId=  : If all it will align all goods. Otherwise use the transaction id you want to limit the alignment too.}
    { --goodTypeId=  : Limit to the goodtype of this id.}
    { --goodId= : Limit to the good with this id.}';

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
        $this->transactionTypeId = $this->option('transactionTypeId');
        $this->goodTypeId        = $this->option('goodTypeId');
        $this->goodId            = ($this->option('goodId')) ?? null;
        $transactionTypeIds      = $this->option('transactionTypeId') ? [(int)$this->transactionTypeId] : [1, 2];
        $goodTypeIds             = ($this->option('goodTypeId')) ? [1, 2, 3, 4] : [(int)$this->goodTypeId];
        foreach ($transactionTypeIds as $transactionTypeId) {
            foreach ($goodTypeIds as $goodTypeId) {
                if ( ! empty($this->goodId)) {
                    $ids = [$this->goodId];
                } else {
                    switch ($goodTypeId) {
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

                if ( ! empty($ids)) {
                    foreach ($ids as $id) {
                        $this->output->note('transactionTypeId: '.$transactionTypeId.' goodTypeId: '.$goodTypeId.' goodId: '.$id);
                        $trends     = new TrendsController();
                        $trendsData = $trends->getRawTrends($transactionTypeId, $goodTypeId, $id, false);
                        foreach ($trendsData as $row) {
                            Trends::updateOrCreate([
                                'transaction_type_id' => $transactionTypeId,
                                'good_type_id'        => $goodTypeId,
                                'good_id'             => $id,
                                'dated_at'            => Carbon::createFromDate($row->dated_at),
                            ], [
                                'sum'     => $row->sum,
                                'amount'  => $row->amount,
                                'average' => ($row->sum === 0 && $row->amount === 0) ? 0 : $row->sum / $row->amount,
                                'count'   => $row->count,
                            ]);
                        }
                    }
                } else {
                    $message = 'No ids found for '.$goodTypeId.' good id was '.$this->goodId;
                    \Log::error($message);
                }
            }
        }
    }

}
