<?php namespace Core;

use DB\dbClass;

class Components extends dbClass
{

    public $id;
    public $title;

    protected $data;
    protected $ingotData;
    protected $baseValue;
    protected $scarcityAdjustedValue;
    protected $keenCrapFix;

    public function __construct($id)
    {
        parent::__construct();
        $this->id      = $id;
        $this->gatherData();
        $this->scarcityAdjustedValue = 1;
        $this->keenCrapFix = 1;

    }

    private function gatherData() {
        $this->data = $this->find('components', $this->id);
        $this->setBaseValue();
        $this->title = $this->data->title;
    }

    public function getName() {
        return $this->title;
}

    public function getData() {
        return $this->data;
    }

    public function getBaseValue() {
        return $this->baseValue;
    }

    public function setBaseValue() {
        //note: this is going to need to pull the storeAdjusted value of each ingot*the amount needed to make this comp. and add all of them together.
        //$this->baseValue = $this->data['oreRequired']*$this->oreClass->getStoreAdjustedValue();
        $this->baseValue = 1;
    }

    public function getStoreAdjustedMinimum() {
        return $this->baseValue*$this->data['keen_crap_fix'];
    }

    public function getScarcityAdjustedValue() {
        return $this->scarcityAdjustedValue;
    }

    public function getKeenCrapFix() {
        return $this->keenCrapFix;
    }

    public function getIngotAmountNeeded($ingotId) {
        $this->ingotData = $this->find('ingots', $ingotId);
        $ingotTitle = $this->ingotData['title'];
        return $this->data[$ingotTitle];
    }

    public function getComponentMass() {
        return $this->data['mass'];
    }

    public function getComponentVolume() {
        return $this->data['volume'];
    }

    public function getDensity() {
        return (empty($this->data['mass'])) ? 0 : $this->data['mass']/$this->data['volume'];
    }
}