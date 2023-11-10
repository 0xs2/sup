<?php
require_once('lib/mysqlidb.php');

$db = new MysqliDb (Array (
    'host' => 'localhost',
    'username' =>'root',
    'password' => '',
    'db'=> 'up',
    'port' => 3306
));
