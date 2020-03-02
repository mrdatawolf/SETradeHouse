<?php namespace Core;

require_once('dbClass.php');

class servers extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}