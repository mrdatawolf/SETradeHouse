<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';

new Models\Database();
use Controllers\Ores;

// get the HTTP method, path and body of the request
$method  = $_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input   = json_decode(file_get_contents('php://input'), true);

// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
$key   = array_shift($request) + 0;

// escape the columns and values from the input object
//$columns = preg_replace('/[^a-z0-9_]+/i', '', array_keys($input));

// create SQL based on HTTP method
switch ($method) {
    case 'GET':
        if(isset($_GET['ores'])) {
            $ores   = new Ores(0);
            $result = $ores->read();
        } else {
            return null;
        }
        break;
    case 'PUT':
        $sql = "update `$table` set $set where id=$key";
        break;
    case 'POST':
        $sql = "insert into `$table` set $set";
        break;
    case 'DELETE':
        $sql = "delete `$table` where id=$key";
        break;
}

// die if SQL statement failed
if ( ! $result) {
    http_response_code(404);
    die();
}

// print results, insert id or affected row count
if ($method == 'GET') {
    http_response_code(200);

    echo $result;
} elseif ($method == 'POST') {

    echo mysqli_insert_id($link);
} else {
    echo mysqli_affected_rows($link);
}
