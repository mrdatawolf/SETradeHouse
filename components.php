<?php

require_once('dbClass.php');

class components extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}