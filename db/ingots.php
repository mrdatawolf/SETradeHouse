<?php namespace Colonization\db;

require_once('dbClass.php');

class ingots extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}