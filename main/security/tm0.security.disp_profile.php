<?PHP

	# retrieve ward_no,name
	$profile_id = $_GET['profile_id'];
	#$name = $_GET['name'];
	
	$displaySQL = "SELECT * FROM sionapros_profiles WHERE profile_id = '$profile_id'";

	$result = $db->execute($displaySQL);
	
	#for the links
	$smarty->assign('prof', $result[0]);

	#fetch tpl
	$content = $smarty->fetch("./security/tm0.security.disp_profile.tpl.html");

?>