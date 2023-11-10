<?php

header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("X-Frame-Options: DENY");

include_once(dirname(__FILE__) . '/lang.php');
include_once(dirname(__FILE__) . '/config.php');

if(!$config['production']) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
}

include_once(dirname(__FILE__) . '/lib/Router.php');
include_once(dirname(__FILE__) . '/lib/PhpRepository.php');
include_once(dirname(__FILE__) . '/db.php');
include_once(dirname(__FILE__) . '/functions.php');

?>