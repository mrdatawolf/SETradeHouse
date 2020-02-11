<?php

class dbConnect
{
    public $dbase;


    public function initDB()
    {
        $dsn = 'sqlite:/Users/patrickmoon/Projects/Colonization2/db/core.sqlite';
        $this->dbase = new PDO($dsn);
        $this->dbase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
