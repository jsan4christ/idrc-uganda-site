<?php
  
  
	//unset other sessionn variables
	session_unset();
	unset($_SESSION['loginUsername']);
	$smarty->assign( 'sessionUsername', $_SESSION['loginUsername']);
  	// Destroy the session.
  	session_destroy();
  	
	require_once('./config/disconnect.inc.php');
  
?>
