<?php

require_once('dbConnect.php');

class tradeZones extends dbConnect
{

    public $rows = [];
    public $headers = [];

    public function __construct()
    {
        $this->initDB();
    }


    public function create() {

    }


    public function read() {
        if(empty($this->headers) && empty($this->rows)) {
            try {
                $stmt = $this->dbase->prepare("select * from trade_zones");
                $stmt->execute();
                $stat[0] = true;
                $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $row = 0;
                foreach ($stat[1] as $data) {
                    $row++;
                    foreach ($data as $key => $value) {
                        if ($row === 1) {
                            $this->headers[] = $key;
                        }
                        $this->rows[$row][] = $value;
                    }
                }
            } catch (PDOException $ex) {
                $this->headers[] = 'Error';
                $this->rows[]    = "No valid data found!";
            }
        }
    }


    public function update() {

    }


    public function destroy() {

    }
}