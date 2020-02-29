<?php namespace DB;

require_once('dbClass.php');

class ingots extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}