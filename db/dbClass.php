<?php namespace DB;

use \PDO;
use \PDOException;

class dbClass
{
    /**
     * @var PDO
     */
    public $dbase;
    public $headers;
    public $rows;
	public $clusterId;
    public $clusterData;
    public $magicData;
    public $baseGameRefinerySpeed;
    public $baseRefineryKilowattPerHourUsage;
    public $costPerKilowattHour;
    public $foundationalOreId;
    public $foundationalIngotId;
    public $foundationOreData;
    public $foundationIngotData;
    public $foundationOrePerIngot;
    
    public function __construct()
    {
		$this->clusterId = 2;

        $dsn = 'sqlite:'.getcwd().'/db/core.sqlite';

        $this->dbase = new PDO($dsn);
        $this->dbase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->dbase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

		$this->gatherMagicData();
        $this->gatherClusterData();
        $this->gatherFoundationOre();
        $this->gatherFoundationIngot();
    }
    
    public function gatherFromTable($table) {
        //$stmt = $this->dbase->prepare("SELECT * FROM " . $table);
        //$stmt->execute();
        
        //return $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt =  $this->dbase->query("SELECT * FROM " . $table);

        return $stmt->fetchObject();
    }


    /**
     * @param $table
     * @param $id
     *
     * @return array
     */
    public function find($table, $id) {
        $stmt =  $this->dbase->query("SELECT * FROM " . $table . " WHERE id=". $id);
        
       return $stmt->fetchObject();
    }
    
    public function findPivots($table, $where, $id) {
        $stmt =  $this->dbase->query("SELECT * FROM " . $table . " WHERE " . $where . "=". $id);
        //die("SELECT * FROM " . $table . " WHERE " . $where . "=". $id);
        return $stmt->fetchObject();
    }

	public function gatherMagicData() {
        $this->magicData                        = $this->gatherFromTable('magic_numbers');

        $this->baseRefineryKilowattPerHourUsage = $this->magicData->base_refinery_kwh;
        $this->costPerKilowattHour              = $this->magicData->cost_kw_hour;
    }

    public function gatherClusterData() {
        $this->clusterData          = $this->find('clusters', $this->clusterId);
        $this->foundationalOreId    = $this->clusterData->economy_ore;
    }
    
    public function gatherFoundationOre() {
        $this->foundationOreData = $this->find('ores',  $this->foundationalOreId);
    }
    
    public function gatherFoundationIngot() {
        $pivot = $this->findPivots('ingot_ores','ore_id', $this->foundationalOreId);

        $this->foundationalIngotId      = $pivot->ingot_id;
        $this->foundationIngotData      = $this->find('ingots', $this->foundationalIngotId);
        $this->foundationOrePerIngot    = $this->foundationIngotData->ore_required;
    }
    
    public function create($insertArray, $table) {
        $prepareColumns = "";
        $executeArray = [];
        foreach($insertArray as $key => $value) {
            $prepareColumns .= $key . " = " . ":" . $key . ", ";
            $executeArray[":" . $key] = $value;
        }
        $trimmedPrepareColumns = rtrim($prepareColumns, ", ");
        $stmt = $this->dbase->prepare("INSERT INTO " . $table . " SET ".$trimmedPrepareColumns);
        $stmt->execute($executeArray);
    }

    public function read($table) {
        if(empty($this->headers) && empty($this->rows)) {
            try {
                $stmt = $this->dbase->prepare("SELECT * FROM ".$table);
                $stmt->execute();
                $stat[0] = true;
                $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $row = 0;
                $lastRow = [];
                foreach ($stat[1] as $data) {
                    $row++;
                    foreach ($data as $key => $value) {
                        if ($row === 1) {
                            $this->headers[] = $key;

                            $lastRow[$key] = $value;
                        }
                        $this->rows[$row][] = $value;
                    }
                }
                $finalRowId = $row+1;
                $this->rows[$finalRowId] = $this->addFinalRow($lastRow, $finalRowId, $table);
            } catch (PDOException $ex) {
                $this->headers[] = 'Error';
                $this->rows[]    = "No valid data found!";
            }
        }

        return ['headers' => $this->headers, 'rows' => $this->rows];
    }


    public function update($id, $updateArray, $table) {
        $updates = "";
        foreach ($updateArray as $title => $value) {
            $updates .= $title . "='" . $value . "', ";
        }
        $trimmedString = rtrim($updates, ", ");
        $updateString = "UPDATE " . $table . " SET " . $trimmedString . " WHERE id=" . $id;
        $rowsEffected = $this->dbase->exec($updateString);

        return $rowsEffected;
    }


    /**
     * @param $id
     * @param $table
     *
     * @return int
     */
    public function destroy($id, $table) {
        $rowsEffected = $this->dbase->exec('DELETE FROM ' . $table . ' WHERE id='. $id);

        return $rowsEffected;
    }


    private function addFinalRow($lastRow, $finalRowId, $table) {
        $row = [];
        foreach($lastRow as $key => $value) {
            switch ($key) {
                case 'id' :
                    $row[$key] = '<button id="addRow" class="addId" data-row_id="' . $finalRowId  . '" data-table="' . $table  . '" disabled><span class="fa fa-plus"></span></button>';
                    break;
                case 'title' :
                    $row[$key] = '<input type=text value="" data-type="title" class="addTitle">';
                    break;
                default:
                    $row[$key] = '<input type=text value="" data-type="general" class="addGeneral">';
            }

        }

            return $row;
    }
}
