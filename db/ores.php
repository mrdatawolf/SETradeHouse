<?php


namespace DB;


class ores extends dbClass
{
    
    public function getRefineryKiloWattHourForOre($oreId,$effeciency = 1)
    {
        $stmt = $this->dbase->prepare("SELECT * FROM ores WHERE id=" . $oreId);
        $stmt->execute();
        $oreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $oreData;
        //return =MagicNumbers!$B$5/Ores!$B3/60/60
    }
}