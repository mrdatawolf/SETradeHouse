<?php

require_once('dbClass.php');

class stations extends dbClass
{

    public function __construct()
    {
        $this->initDB();
    }
}