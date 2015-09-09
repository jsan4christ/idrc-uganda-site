<?php
// start compressing and buffering
#ob_start( "ob_gzhandler" );

// include needed classes 
#require_once( 'Smarty.class.php' );
require_once( 'connect.inc.php') ;

#$smarty 						=& new Smarty();

// set the smarty-dirs
#$smarty->template_dir 	= "./templates/"; 
#$smarty->compile_dir 	= "../templates_c/"; 

/*$filePath = '.';
$serverPath = $_SERVER['PHP_SELF'];
$filePath .= $serverPath;

#$prgm 	= ( $_GET[ 'prgm' ] ) ? $_GET[ 'prgm' ] : "ehmis-home";

if( is_file( $filePath ) )
	require_once( "{$filePath}" );
*/
# Getting active Hospital Unit Info
#$query = "SHOW TABLES ";
if ($db->query("SELECT * FROM ehmis_health_unit_main WHERE active = 'Yes' ") ){
	$result = $db->getNext();
	echo DBHelper::dumpColumn($result, true, 'unit_no');
	if (isset($result))
		echo 'fadfasd';
	print_r($result);
}
else
	echo $db->error . 'SQL ERROR';
#$tables = $db->getTables() or die ('No Tables');
#print_r($tables);

/*if ( count($result) == 1){
	foreach ($result as $unitInfo){
		$unit_no = $unitInfo['unit_no'];
        $unit_name = $unitInfo['unit_name'];
        $unit_code = $unitInfo['unit_code'];
        $district = $unitInfo['district'];
        $country = $unitInfo['country'];
        $country_code = $unitInfo['country_code'];
        $reg_date = $unitInfo['reg_date'];
        $remarks = $unitInfo['remarks'];
        # the reporting code below is only important for backup purposes
        $reporting_code = $unitInfo['unit_no'];
	}
}
# Assign unit Info
$smarty->assign( 'unit_no', $unit_no );
$smarty->assign( 'unit_name', $unit_name );
$smarty->assign( 'unit_code', $unit_code );
$smarty->assign( 'district', $district );
$smarty->assign( 'country', $country );
$smarty->assign( 'country_code', $country_code );

$smarty->assign( 'content' , $content );
#$smarty->assign( 'sidebox' , $otpt_sidebox );

$smarty->display( "display/index.tpl.html" );
*/
// flush output
#ob_end_flush();
echo '<hr>';
highlight_file(__FILE__);
?>
