<?php namespace DB;

use \PDO;
use \Exception;


class dbClass
{
    /**
     * @var PDO
     */
    public $dbase;
    public $baseRefineryKilowattPerHourUsage;
    public $baseRefineryCostPerHour;
    public $baseDrillCostPerHour;
    public $costPerKilowattHour;


    public function __construct()
    {
        $dsn = 'sqlite:'.getcwd().'/db/core.sqlite';

        $this->dbase = new PDO($dsn);
        $this->dbase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function gatherFromTable($table) {
        return $this->dbase->query("SELECT * FROM " . $table)->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @param string $table
     * @param string $id
     * @param $column
     *
     * @return mixed
     */
    public function find($table, $id, $column = 'id') {
        $stmt = $this->dbase->prepare("SELECT * FROM ".$table." WHERE ".$column."= ?");
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
        return json_encode($this->gatherFromTable($table));
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


    function ddng($var)
    {
        ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
        ini_set("highlight.string", "#5825b6; font-weight: lighter; ");

        ob_start();
        highlight_string("<?php\n" . var_export($var, true) . "?>");
        $highlighted_output = ob_get_clean();

        $highlighted_output = str_replace(["&lt;?php", "?&gt;"], '', $highlighted_output);
        $dbgt=debug_backtrace();
        echo "See {$dbgt[1]['file']} on line {$dbgt[1]['line']}";
        echo $highlighted_output;
        die();
    }
}
