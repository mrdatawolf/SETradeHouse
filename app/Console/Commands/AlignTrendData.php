<?php

namespace App\Console\Commands;

use App\Models\Components;
use App\Http\Controllers\Trends as TrendsController;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\Ammo;
use App\Models\Bottles;
use App\Models\Trends;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AlignTrendData extends Command
{
    /**
     * note: order is transaction_id 1 is an order and 2 is an offer.
     *
     * @var string
     */
    protected $signature = 'align:trends
    { --transactionTypeId=  : If "all" it will align all goods. Otherwise use the transaction id you want to limit the alignment too.}
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
        $this->goodId            = $this->option('goodId');
        $transactionTypeIds      = ($this->option('transactionTypeId')) ? [(int)$this->transactionTypeId] : [1, 2];
//todo: something is wrong with certain good types... causes failures into inactive_transactions...not sure why. So along with the other blocks I stopped 4 of them completely. Also tools, ammo and bottles which needs to be corrected
        $goodTypeIds             = ($this->option('goodTypeId')) ? [(int)$this->goodTypeId] :  [1, 2, 3, 4, 5, 6] ;
        foreach ($transactionTypeIds as $transactionTypeId) {
            foreach ($goodTypeIds as $goodTypeId) {
                if ( ! empty($this->goodId)) {
                    $ids = [$this->goodId];
                } else {
                    switch ($goodTypeId) {
                        case 1 :
                            $ids = Ores::whereNotIn('id', [12, 13])->pluck('id');
                            break;
                        case 2 :
                            $ids = Ingots::whereNotIn('id', [10, 11, 12])->pluck('id');
                            break;
                        case 3 :
                            $ids = Components::pluck('id');
                            break;
                        case 4 :
                            //currently blocked
                            $ids = Tools::pluck('id');
                            break;
                        case 5 :
                            //currently blocked
                            $ids = Ammo::pluck('id');
                            break;
                        case 6 :
                            //currently blocked
                            $ids = Bottles::pluck('id');
                            break;
                    }
                }

                if (! empty($ids)) {
                    foreach ($ids as $id) {
                        $this->output->note('transactionTypeId: '.$transactionTypeId.' goodTypeId: '.$goodTypeId.' goodId: '.$id);
                        $trends     = new TrendsController();
                        $trendsData = $trends->getRawTrends($transactionTypeId, $goodTypeId, $id, false);
                        foreach ($trendsData as $row) {
                            Trends::updateOrCreate([
                                'transaction_type_id' => $transactionTypeId,
                                'type_id'        => $goodTypeId,
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
                    $message = 'No ids found for '.$goodTypeId.' good id was '.json_encode($this->goodId);
                    \Log::error($message);
                }
            }
        }
    }

}
