<?php
require 'start.php';
$users = \Controllers\Users::read();
function read() {
    $stockLevels = new \Controllers\StockLevels();
    $headers  = $stockLevels->headers();
    $rows     = $stockLevels->rows();


    return ['headers' => $headers, 'rows' => $rows];
}

function getTotal($rows) {
    $totals   = [];
    foreach($rows as $row) {
        $type = $row[6];
        $id = $row[7];
        if(empty($totals[$type][$id])) {
            $totals[$type][$id] = 0;
        }
        $totals[$type][$id] += $row[3];
    }

    return $totals;
}

function makeChartData($rows, $users) {
    $return = "[";
    foreach($rows as $row) {
        $user = $users->find($row[2]);

        $return .= "['".$user->username."', ".$row[3]."],";
    }
    $return .= "]";

    return $return;
}

$tableData = read();
$totalData = getTotal($tableData['rows']);