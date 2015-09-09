<?php
require_once './anyDB/anyDB.php';
require_once './anyDB/addon/DBHelper.php';
require_once './anyDB/addon/QueryHelper.php';

$database = 'idrc_db1';
$host = 'localhost';
//$user = 'root';
//$password = 'theReal@dmin85!';
$user = 'root';
$password = 'theReal@dmin85!';
$dbType = 'mysql';

// create a new db layer
//$db = anyDB::getLayer('MYSQL','', $dbType);
    //$db = anyDB::getLayer('PEAR', 'C:\apachefriends\xampp\php\pear', $dbType);
    //$db = anyDB::getLayer('PHPLIB', '../../../inc/phplib-7.2d/', $dbType);
    //$db = anyDB::getLayer('METABASE', '../../../inc/metabase/', $dbType);
    $db = anyDB::getLayer('ADODB', './adodb', $dbType);
    //$db = anyDB::getLayer('DBX','../../../inc/dbx/', $dbType);

//connect to db
$db->connect($host, $database, $user, $password) or die ("Connection Not Established");
?>