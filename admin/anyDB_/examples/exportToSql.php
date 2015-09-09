<?php 
require "connect.inc.php";
require "../addon/Exporter.php";

$appname = 'MySQL Backup Class';
$myurl = 'http://localhost';
$backupPath = 'C:\apachefriends\xampp\htdocs\anyDB2';

// export table content as sql statements
#$sqlData = Exporter::getDBDataDump($db);

$tables = $db->getTables();
$struct = Exporter::dbStructure($db, $tables);
print_r($struct);
#foreach($sqlData as $key => $data) {
#    echo "--$key--<br>";
#    echo nl2br($data);
#}
#$file = Exporter::dumpDataFileBuilder($sqlData);
#echo $file;
#Exporter::dataOnly($db, $appname, $myurl, $backupPath);
#echo $sfile;
//require "disconnect.inc.php";
////////////////////////////////////////////////////////////////////////
echo '<hr>';
highlight_file(__FILE__);
?>