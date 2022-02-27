<?php

namespace App\Console\Commands;

use App\Http\Controllers\Gather\GeneralStorageData;
use App\Http\Controllers\Gather\GeneralStoreData;
use App\Models\Servers;
use App\Models\Worlds;
use Illuminate\Console\Command;

class GatherOffersAndOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:offersandorders {serverId : Name or ID of the server} {worldIds : Name of Ids of servers comma seperated} {--initial} {--extended=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather offers and orders from the world api';

    protected $serverId;
    protected $server;
    protected $worldIds;
    protected $worldId;
    protected $world;
    protected string $worldName;

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
        $this->serverId = $this->argument('serverId');
        $this->worldIds = $this->argument('worldIds');
        $this->getServer();

        $gatherGeneralStoreData = new GeneralStoreData($this->option('initial'), $this->option('extended'), $this->server->id);
        $this->output->text('pull api data');
        foreach (explode(',',$this->worldIds) as $worldId) {
            $this->worldId = $worldId;
            $this->getWorld($worldId);
            $this->output->note('Updating Transactions for Server: ' . $this->server->title . 'World : ' . $this->world->title);
            $gatherGeneralStoreData->gatherApiData($this->worldName);
            $this->output->text('process api data');
            $result = $gatherGeneralStoreData->processApiData($this->world->id);
            $this->output->note($result);
        }
        $gatherGeneralStoreData->applyTransactions();
    }

    private function getServer() {
        switch($this->serverId) {
            case 'The Nebulon Cluster':
            case 'nebulon':
            case '1':
                $serverId = 1;
                break;
            default:
                die("Server not found: " . $this->serverId);
        }
        $this->server = Servers::where('id', $serverId)->first();
    }

    private function getWorld($worldId) {
        switch($worldId) {
            case 'Carmenta' :
            case '1':
                $this->worldName = "Carmenta";
                $worldId = 1;
                break;
            case 'Pertam' :
            case '2':
                $this->worldName = "Pertam";
                $worldId = 2;
                break;
            case 'Qun':
            case '3':
                $this->worldName = "Qun";
                $worldId = 3;
                break;
            case 'Androktasia':
            case '4':
                $this->worldName = "Androktasia";
                $worldId = 4;
                break;
            case 'Nemesis':
            case '5':
                $this->worldName = "Nemesis";
                $worldId = 5;
                break;
            case 'General Space':
            case '6':
                $this->worldName = "General Space";
                $worldId = 6;
                break;
            default:
                die ('No matching world found for ' . $this->worldId);
        }
        $this->world = Worlds::where('id', $worldId)->first();
    }
}
