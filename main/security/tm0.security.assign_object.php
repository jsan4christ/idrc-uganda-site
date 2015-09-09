<?php

	require_once('./classes/fileDisplay.class.php');

	$fileDisplay = New FileDisplay;  // initiate new object

	$activefolder = $_REQUEST['activefolder'];
	#customise presentation
	$fileDisplay->showperms = false;
	$fileDisplay->showsize = false;
	$fileDisplay->showmodified = false;
	
	$smarty->assign('activefolder', $activefolder);
	$smarty->assign('fileDisplay', $fileDisplay->showContents($activefolder));
	#$fileDisplay->showContents($activefolder);
	$content = $smarty->fetch('./security/tm0.security.assign_object.tpl.html');

?>


