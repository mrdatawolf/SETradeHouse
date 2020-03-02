<?php namespace Core;


use productionParts\refinery;

class ores extends dbClass
{
    protected $oreData;
    
    public function getOreData($oreId)
    {
        $stmt = $this->dbase->prepare("SELECT * FROM ores WHERE id=" . $oreId);
        $stmt->execute();
        $oreData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $oreData;
    }
    
    
    public function getRefineryKiloWattHourForOre($oreId,$effeciency = 1)
    {
        //return =MagicNumbers!$B$5/Ores!$B3/60/60
    }

	public function getRefineryTimePerOre()
	{
		$refinery = new refinery();
		$baseGameRefinerySpeed = $refinery->baseRefinerySpeed * 100;
		
		return $baseGameRefinerySpeed;
	}
}