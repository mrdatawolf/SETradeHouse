<?php


namespace Colonization\db;

class dbClass
{
    /**
     * @var PDO
     */
    public $dbase;
    public $headers;
    public $rows;
    
    public function __construct()
    {
        $dsn = 'sqlite:'.getcwd().'/db/app.sqlite';
        
        $this->dbase = new PDO($dsn);
        $this->dbase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
