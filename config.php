<?php
require_once('.env');
defined("DBDRIVER")or define("DBDRIVER","sqlite");
defined("DBHOST")or define("DBHOST","localhost");
defined("DBNAME")or define("DBNAME","db/core.sqlite");

$clusterId  = 3;