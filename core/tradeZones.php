<?php namespace Core;

require_once('dbClass.php');

class tradeZones extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}