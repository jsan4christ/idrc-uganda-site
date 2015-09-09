<?php
	include_once('breadcrumbs.inc.php');
	$smarty->assign('bcs', $bcs);
    $otpt_contentbox = $smarty->fetch("./display/past-projects.tpl.html");
?>