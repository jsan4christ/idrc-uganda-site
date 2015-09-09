<?php 
require "connect.inc.php";
require "../addon/Exporter.php";

$appname = 'MySQL Backup Class';
$myurl = 'http://localhost';
$backupPath = 'C:\apachefriends\xampp\htdocs\anyDB2';

// export table content as sql statements
$sqlData = Exporter::structureOnly($db, $appname, $myurl, $backupPath);

#foreach($sqlData as $key => $data) {
#    echo "$key<br>";
#    echo nl2br($data);
#}
echo $sqlData;
//require "disconnect.inc.php";
////////////////////////////////////////////////////////////////////////
echo '<hr>';
highlight_file(__FILE__);
?>