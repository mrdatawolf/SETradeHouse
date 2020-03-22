<?php namespace Core;

use DB\dbClass;

class Servers extends dbClass
{
    public $id;
    protected $title;
    protected $data;
    protected $cluster;
    protected $oreIds;
    protected $ores;

    private $table = 'servers';

    public function __construct($id)
    {
        parent::__construct();
        $this->cluster = new Clusters(2);
        $this->id = $id;
        $this->data = $this->gatherData();
        $this->ores = $this->gatherOres();

    }

    private function gatherData() {
        $this->data              = $this->find($this->table, $this->id);
        $this->title                = $this->data->title;
    }

    private function gatherOres() {
        $this->oreIds = $this->findPivots('server', 'ore', $this->id);
        return $this->findIn('ores', $this->oreIds);

    }

    public function getName() {
        return $this->title;
    }

    public function getOres() {
        return $this->ores;
    }

    public function getOreIds() {
        return $this->oreIds;
    }

}