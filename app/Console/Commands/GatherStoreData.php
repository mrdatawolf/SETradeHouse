<?php

namespace App\Console\Commands;

use App\Http\Controllers\Gather\GeneralStorageData;
use App\Http\Controllers\Gather\GeneralStoreData;
use App\Models\Servers;
use App\Models\Worlds;
use Illuminate\Console\Command;

class GatherStoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:stores {--initial} {--extended=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather store data from the connected dbs';

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
        // Don't kill the app if the database hasn't been created.
        try {
            \DB::connection('storage')->statement(
                'PRAGMA synchronous = OFF;'
            );
        } catch (\Throwable $throwable) {
            $this->output->info('sync is not off');
            return;
        }
        $servers = Servers::where('title', 'The Nebulon Cluster');
        if( $servers->count() > 0) {
            $this->server = $servers->first();
        } else {
            die('No matching server found!');
        }
        $worlds = Worlds::where('title', 'General Space');
        if( $worlds->count() > 0) {
            $this->world = $worlds->first();
        } else {
            die('No matching world found!');
        }

        if(!empty($this->server) && !empty($this->world)) {
            $this->output->note(' Updating Stores for Server: ' . $this->server->title . ', World : ' . $this->world->title);
            $gatherGeneralStorageData = new GeneralStorageData($this->option('initial'), $this->option('extended'), $this->server->id,
                $this->world->id);
            $result = $gatherGeneralStorageData->upateUserAndNpcStorageValues();
            $this->output->note($result);
        }
    }
}
