<?php

namespace App\Console\Commands;

use App\Http\Controllers\Gather\GeneralStorageData;
use App\Http\Controllers\Gather\GeneralStoreData;
use App\Models\Servers;
use App\Models\Worlds;
use Illuminate\Console\Command;

class GatherTransactionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:transactions {--initial} {--extended=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather transaction data from the nebulon db';

    protected $server;
    protected $world;

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
        $servers = Servers::where('title', 'The Nebulon Cluster');
        if( $servers->count() > 0) {
            $this->server = $servers->first();
        }
        $worlds = Worlds::where('title', 'Nebulon');
        if( $worlds->count() > 0) {
            $this->world = $worlds->first();
        }
        if(!empty($this->server) && !empty($this->world)) {
            $this->output->note('Updating Transactions for Server: ' . $this->server->title . 'World : ' . $this->world->title);
            $gatherGeneralStoreData = new GeneralStoreData($this->option('initial'), $this->option('extended'), $this->server->id,
                $this->world->id);
            $this->output->text('now updateTransactionValues');
           $result = $gatherGeneralStoreData->updateTransactionValues();
            $this->output->note($result);
        }
    }


}
