<?php
require '..\..\..\start.php';
use Controllers\StockLevels;
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET' :
        $stockLevels = new StockLevels();
        print_r('get', $stockLevels->read());
        break;
    case 'POST' :
        echo "this should do post stuff";
        break;
    case 'PUT' :
        $data = json_decode(file_get_contents('php://input'), true);
        print_r('put', $data);
        break;
    case 'DELETE' :
        echo "this should let you delete stock data";
        break;

}
