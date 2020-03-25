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
        $this->id = $id;

        $this->gatherData();
        $this->gatherOreIds();

    }

    private function gatherData() {
        $this->data     = $this->find($this->table, $this->id);
        $this->title    = $this->data->title;
    }

    private function gatherOreIds() {
        $this->oreIds = $this->findPivots('server', 'ore', $this->id);

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