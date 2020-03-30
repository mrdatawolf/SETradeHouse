<?php

namespace Controllers;


class BaseController
{
    protected $dataSource;
    protected $clusterId;

    public function headers() {
        $headers = [];
        $rowArray = $this->dataSource::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public function rows() {
        $rows = [];
        foreach ($this->dataSource::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public function basicData($id = null) {
        $rows = [];
        if(empty($id)) {
            foreach ($this->dataSource::get()->toArray() as $key => $value) {
                foreach ($value as $column => $columnValue) {
                    $rows[$column] = $columnValue;
                }
            }
        } else {
            $rows = $this->dataSource::find($id)->toArray();
        }

        return (object) $rows;
    }

    public function create($data) {

    }

    public function read() {
        return $this->dataSource::all();
    }

    public function update() {

    }

    public function delete() {

    }

    public function ddng($var)
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