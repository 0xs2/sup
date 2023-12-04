<?php

header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("X-Frame-Options: DENY");

include_once(dirname(__FILE__) . '/lang.php');
include_once(dirname(__FILE__) . '/config.php');

if(!APP_CONFIG['production']) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
}

include_once(dirname(__FILE__). '/lib/mysqlidb.php');

$db = new MysqliDb (Array (
    'host' => APP_CONFIG['db']['host'],
    'username' => APP_CONFIG['db']['user'],
    'password' => APP_CONFIG['db']['pass'],
    'db'=> APP_CONFIG['db']['name'],
    'port' => APP_CONFIG['db']['port']
));

include_once(dirname(__FILE__) . '/lib/Router.php');
include_once(dirname(__FILE__) . '/lib/mime.php');
include_once(dirname(__FILE__) . '/functions.php');

?>
