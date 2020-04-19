<?php
require 'vendor/autoload.php';
require 'config.php';
$title= $title ?? 'test';
use Models\Database;

function ddng($var)
{
    ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
    ini_set("highlight.string", "#5825b6; font-weight: lighter; ");

    ob_start();
    highlight_string("<?php\n" . var_export($var, true) . "?>");
    $highlighted_output = ob_get_clean();

    $highlighted_output = str_replace(["&lt;?php", "?&gt;"], '', $highlighted_output);
    $dbgt=debug_backtrace();
    echo '<div id="debugBox">';
    echo '<h4>Debug Info</h4>';
    if(!empty($dbgt[1])) {
        echo "See {$dbgt[1]['file']} on line {$dbgt[1]['line']}";
    }
    echo $highlighted_output;
    echo '</div>';
    die();
}

function getTZsFromServers($servers) {
    $tradezones = [];
    foreach($servers as $server) {
        foreach ($server->tradezones as $tradezone) {
            $tradezones[$server->id][] = $tradezone;
        }
    }

    return $tradezones;
}

new Database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title;?></title>
    <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link href="public/css/default.css" type="text/css" rel="stylesheet">
    <script src="public/js/default.js"></script>

</head>
<body>
