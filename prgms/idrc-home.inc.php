<?PHP
	include_once('breadcrumbs.inc.php');
    #rand no. for the banner to be shown
    /*$rand = rand(1, 17);

    $smarty->assign('no', $rand);

    #retrieve news
    $newsSQL = "SELECT * FROM sionapros_news ORDER BY pub_date DESC LIMIT 3";
    $news = $db->execute($newsSQL);

    $smarty->assign('news', $news);

    #retrieve pubs
    $pubsSQL = "SELECT * FROM sionapros_pubs ORDER BY pub_date DESC LIMIT 3";
    $pubs = $db->execute($pubsSQL);

    $smarty->assign('pubs', $pubs);*/
	$smarty->assign('bcs', $bcs);
    $otpt_contentbox = $smarty->fetch("idrc-home.tpl.html");
?>