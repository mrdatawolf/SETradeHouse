<?php
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
            $tradezones[] = $tradezone;
        }
    }

    return $tradezones;
}