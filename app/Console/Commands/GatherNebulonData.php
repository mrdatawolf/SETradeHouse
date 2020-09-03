<?php

namespace App\Console\Commands;

use App\Http\Controllers\Gather\GeneralStorageData;
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
        $this->server=Servers::where('title', 'The Nebulon Cluster')->first();
        $this->world=Worlds::where('title', 'Nebulon')->first();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $gatherGeneralStorageData = new GeneralStorageData($this->option('initial'), $this->server->id, $this->world->id);
        $gatherGeneralStorageData->upateUserAndNpcStorageValues();


        //gather stores
        //check if it is already in the active_transactions
        //if it is move the current transaction to the inactive_transactions
        //add transaction to active_transactions
    }


}
