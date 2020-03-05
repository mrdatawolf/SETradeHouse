<?php namespace Core;

use DB\dbClass;

class components extends dbClass
{

    protected $componentId;
    protected $componentData;
    protected $ingotId;
    protected $ingotData;


    public function __construct($compId)
    {
        parent::__construct();
        $this->componentId      = $compId;
        $this->componentData    =  $this->find('components', $this->componentId);
    }

    public function getIngotAmountNeeded($ingotId) {
        $this->ingotData = $this->find('ingots', $ingotId);
        $ingotTitle = $this->ingotData['title'];
        return $this->componentData[$ingotTitle];
    }

    public function getComponentMass() {
        return $this->componentData['mass'];
    }

    public function getComponentVolume() {
        return $this->componentData['volume'];
    }

    public function getDensity() {
        $mass = $this->componentData['mass'];
        $volume = $this->componentData['volume'];
        return (empty($mass) || empty($volume)) ? 0 : $mass/$volume;
    }
}