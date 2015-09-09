<?PHP

 #retrieve news
    $newsSQL = "SELECT * FROM sionapros_news ORDER BY pub_date DESC LIMIT 3";
    $news = $db->execute($newsSQL);

    $smarty->assign('news', $news);

    #retrieve pubs
    $pubsSQL = "SELECT * FROM sionapros_pubs ORDER BY pub_date DESC LIMIT 3";
    $pubs = $db->execute($pubsSQL);

    $smarty->assign('pubs', $pubs);
	#end of news and pubs highlights.
    #article details
    $news_no = $_GET['news_no'];
    $dispSQL = "SELECT * FROM sionapros_news WHERE news_no = '$news_no'";
    $disp = $db->execute($dispSQL);

    if( $disp[0]['photo'] )
    $path = './admin'.substr($disp[0]['photo'], 1, strlen($disp[0]['photo']));

    $smarty->assign('newsDetails', $disp[0]);
    $smarty->assign('path', $path);

    $otpt_contentbox = $smarty->fetch("news/news-details.cb.tpl.html");

?>