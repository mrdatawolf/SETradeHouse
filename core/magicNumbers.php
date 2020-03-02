<?php namespace Core;


class magicNumbers extends dbClass
{
    public $magicData;
    
    public function read() {
        $stmt = $this->dbase->prepare("SELECT * FROM magic_numbers");
        $stmt->execute();
        $this->magicData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}