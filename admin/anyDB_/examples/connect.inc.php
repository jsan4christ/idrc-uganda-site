<?php
require_once '../anyDB.php';
require_once '../addon/DBHelper.php';
require_once '../addon/QueryHelper.php';

$database = 'ehmis_00256_e001';
$host = 'localhost';
$user = 'root';
$password = 'die8irmm';
$dbType = 'mysql';

// create a new db layer
//$db = anyDB::getLayer('MYSQL','', $dbType);
    //$db = anyDB::getLayer('PEAR', 'C:\apachefriends\xampp\php\pear', $dbType);
    //$db = anyDB::getLayer('PHPLIB', '../../../inc/phplib-7.2d/', $dbType);
    //$db = anyDB::getLayer('METABASE', '../../../inc/metabase/', $dbType);
    $db = anyDB::getLayer('ADODB', 'C:\apachefriends\xampp\php\pear\adodb', $dbType);
    //$db = anyDB::getLayer('DBX','../../../inc/dbx/', $dbType);

//connect to db
$db->connect($host, $database, $user, $password) or die ('No Connection');
?>