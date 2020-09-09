<?php

namespace App\Console\Commands;

use App\Http\Controllers\Gather\GeneralStorageData;
use App\Http\Controllers\Gather\GeneralStoreData;
use App\Servers;
use App\Worlds;
use Illuminate\Console\Command;

class GatherNebulonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:nebulon {--initial}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather data from the nebulon db';

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
        if(! $servers->count() > 0) {
            $this->server = $servers->first();
        }
        $worlds = Worlds::where('title', 'Nebulon');
        if(! $worlds->count() > 0) {
            $this->world = $worlds->first();
        }
        if(!empty($this->server) && !empty($this->world)) {
            $gatherGeneralStorageData = new GeneralStorageData($this->option('initial'), $this->server->id,
                $this->world->id);
            $gatherGeneralStorageData->upateUserAndNpcStorageValues();

            $gatherGeneralStoreData = new GeneralStoreData($this->option('initial'), $this->server->id,
                $this->world->id);
            $gatherGeneralStoreData->updateTransactionValues();
        }
    }


}
