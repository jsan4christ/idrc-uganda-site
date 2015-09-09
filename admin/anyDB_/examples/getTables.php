<?php
require "connect.inc.php";

// get all tables
$tables = $db->getTables();
$i = 1;
foreach ($tables as $table) {
	echo $table ;
	
	if ($i < count($tables))
	echo $i.', <br>';
	$i++;
}
$tables = $db->execute("DESCRIBE formitable_demo",1);
#print_r($db->_getAssociativeEntries($tables));
echo '<br>';
print_r($tables);
foreach ($tables as $table) {
	$field = $table['Field'];
	$type = $table['Type'];
	$y = strpos($type, ')');
	
	$null = $table['Null'];
	if ($null == '') $null = 'not_null';
	$flags = $null.' '.$table['Default'].' '.$table['Key'].' '.$table['Extra'];
	echo 'field '.$field.' <br>';
	echo 'type ';
	$x = strpos($type, '(');
	#echo 'pos '.$x. '<br>';
	if($x === false ) echo $type.' <br>'; else 
	echo substr($type, 0, $x). '<br>';
	echo 'flags ';
	if($y === false); else
	echo substr($type, $y+1,strlen($type));
	echo $flags.' <br>';
	echo 'len ';
	$i = strpos($type, '(');
	$p = strpos($type, ')');
	echo substr($type, $i+1, $p-$i-1).'<br>';
	ereg('^([^ (]+)(\((.+)\))?([ ](.+))?$',$type,$Split);
	$split = split("','",substr($Split[3],1,-1));
	#print_r($split);
	echo $Split[0].' 2'.$Split[1].' 3'.$Split[2].' 4'.$Split[3].' 5'.$Split[4].' 6'.$Split[5].' <br>';
}
echo $tables[0]['Field'];
$db = @mysql_connect($host, $user, $password);

$result = mysql_list_fields($database, 'formitable_demo', $db);

$menge = mysql_num_fields($result);

for($x = 0; $x < $menge; $x++){
  $type = mysql_field_type($result, $x);
  $name = mysql_field_name($result, $x);
  $len = mysql_field_len($result, $x);
  $flags = mysql_field_flags($result, $x);
  echo 'Feld <b>' . $name . '</b>:<br>';
  echo '&nbsp;&nbsp;&nbsp;' . $type . '[' . $len . ']';
  echo $flags . '<br>';
}
require "disconnect.inc.php";
////////////////////////////////////////////////////////////////////////
echo '<hr>';
highlight_file(__FILE__);
?>