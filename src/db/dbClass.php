<?php namespace DB;

use \PDO;
use \PDOException;
use \Exception;

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
    public $baseRefineryCostPerHour;
    public $baseDrillCostPerHour;
    public $costPerKilowattHour;
    public $foundationalOreId;
    public $foundationalIngotId;
    public $foundationOreData;
    public $foundationIngotData;
    public $foundationOrePerIngot;
    public $serverCount;
    public $planetCount;
    public $otherCount;
    
    public function __construct()
    {
		$this->clusterId = 2;

        $dsn = 'sqlite:'.getcwd().'/db/core.sqlite';

        $this->dbase = new PDO($dsn);
        $this->dbase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->gatherMagicData();
        $this->gatherClusterData();
        $this->gatherFoundationOre();
        $this->gatherFoundationIngot();
        $this->gatherSystemTypeCount();
    }
    
    public function gatherFromTable($table) {
        return $this->dbase->query("SELECT * FROM " . $table)->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @param $table
     * @param $id
     *
     * @return mixed
     */
    public function find($table, $id) {
        $stmt = $this->dbase->prepare("SELECT * FROM " . $table . " WHERE id= ?");
        $stmt->execute([$id]);

        return $stmt->fetchObject();
    }


    /**
     * @param string $table
     * @param array $ids
     *
     * @return mixed
     */
    public function findIn($table, $ids) {
        $idString = implode(",", $ids);

        return $this->dbase->query("SELECT * FROM " . $table . " WHERE id IN (" . $idString . ")")->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @param $from
     * @param $to
     * @param $fromIds
     *
     * @return array
     */
    public function findPivots($from, $to, $fromIds) {
        if(! is_array($fromIds)) {
            $fromIds = [$fromIds];
        }
        $fromIdString = implode(',',$fromIds);
        $pivotedIds = [];
        $sortArray = [$from."s", $to."s"];
        sort($sortArray);
        $table = $sortArray[0]."_".$sortArray[1];
        $toColumn = $to . "_id";
        $fromColumn = $from . "_id";
        $select = "SELECT " . $toColumn . " FROM " . $table . " WHERE " . $fromColumn . " IN (" . $fromIdString . ")";
        $stmt =  $this->dbase->query($select)->fetchAll(PDO::FETCH_OBJ);
        foreach($stmt as $object) {

            $pivotedIds[] = $object->$toColumn;
        }

        return $pivotedIds;
    }

	private function gatherMagicData() {
        $this->magicData                        = $this->gatherFromTable('magic_numbers')[0];
        $this->baseRefineryKilowattPerHourUsage = $this->magicData->base_refinery_kwh;
        $this->costPerKilowattHour              = $this->magicData->cost_kw_hour;
        $this->baseRefineryCostPerHour          = $this->magicData->base_refinery_kwh*$this->magicData->cost_kw_hour;
        $this->baseDrillCostPerHour             = $this->magicData->base_drill_per_kw_hour*$this->magicData->cost_kw_hour;

    }

    private function gatherClusterData() {
        $this->clusterData          = $this->find('clusters', $this->clusterId);
        $this->foundationalOreId    = $this->clusterData->economy_ore;
    }

    private function gatherSystemTypeCount() {
        // note: hacking these in to not have to think...
        $this->planetCount = 6;
        $this->otherCount = 4;
        $this->serverCount = $this->planetCount+$this->otherCount;
    }

    private function gatherFoundationOre() {
        $this->foundationOreData = $this->find('ores',  $this->foundationalOreId);
    }

    private function gatherFoundationIngot() {
        $this->foundationalIngotId = $this->findPivots('ore','ingot', $this->foundationalOreId)[0];

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

                $row = 0;
                $lastRow = [];
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $data) {
                    $row++;
                    foreach ($data as $key => $value) {
                        if($key === 'base_cost_to_gather') {
                            $value = sprintf('%f', $value);
                            $key = $key . ' (rounded)';
                        }
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
        try {
            $this->dbase->beginTransaction();
            $trimmedString = rtrim($updates, ", ");
            $stmt          = $this->dbase->prepare("UPDATE ".$table." SET ".$trimmedString." WHERE id= ?");
            $stmt->execute([$id]);
            $this->dbase->commit();
        } catch (Exception $e) {
            $this->dbase->rollBack();
        }

        return $stmt->rowCount();
    }


    /**
     * @param $id
     * @param $table
     *
     * @return int
     */
    public function destroy($id, $table) {
        return $this->dbase->exec('DELETE FROM ' . $table . ' WHERE id='. $id);;
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

    public function getClusterId() {
        return $this->clusterId;
    }


    function ddng($var)
    {
        ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
        ini_set("highlight.string", "#5825b6; font-weight: lighter; ");

        ob_start();
        highlight_string("<?php\n" . var_export($var, true) . "?>");
        $highlighted_output = ob_get_clean();

        $highlighted_output = str_replace(["&lt;?php", "?&gt;"], '', $highlighted_output);

        echo $highlighted_output;
        die();
    }
}
