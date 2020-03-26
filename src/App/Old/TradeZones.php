<?php namespace Old;


use Illuminate\Database\Eloquent\Model;

class TradeZones extends Model
{
    public $id;

    protected $title;
    protected $data;
    protected $cluster;

    private $table = 'trade_zones';

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
        $this->data = $this->gatherData();
    }


    private function gatherData() {
        $this->data              = $this->find($this->table, $this->id);
        $this->title                = $this->data->title;
    }
}