<?php
require "connect.inc.php";


// get all the results and print them in a html table
$results = $db->execute("SELECT * FROM ehmis_health_unit_main WHERE active = 'Yes' ") or die('No Matches');

#echo DBHelper::dumpAll($results, true, array('Name','Email Adress'));
print_r($results);

	foreach ($results as $unitInfo){
		$unit_no = $unitInfo['unit_no'];
        $unit_name = $unitInfo['unit_name'];
        $unit_code = $unitInfo['unit_code'];
        $district = $unitInfo['district'];
        $country= $unitInfo['country'];
        $country_code = $unitInfo['country_code'];
        $reg_date = $unitInfo['reg_date'];
        $remarks = $unitInfo['remarks'];
        # the reporting code below is only important for backup purposes
        $reporting_code = $unitInfo['unit_no'];
	}
	echo $unit_no;
if ($db->query("SELECT * FROM ehmis_health_unit_main WHERE active = 'Yes' ") ){
	$result = $db->getNext();
	echo DBHelper::dumpColumn($result, true, 'unit_no');
	if (!isset($result))
		echo 'fadfasd';
	print_r($result);
}
else
	echo $db->error . 'SQL ERROR';
#require "disconnect.inc.php";
////////////////////////////////////////////////////////////////////////
echo '<hr>';
highlight_file(__FILE__);
?>