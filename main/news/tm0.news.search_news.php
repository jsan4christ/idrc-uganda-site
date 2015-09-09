<?php

    #category retrieval
    $catSQL = "SELECT * FROM sionapros_categories";
    $cat = $db->execute($catSQL);

    $smarty->assign('cs', $cat);

    $content = $smarty->fetch('./news/tm0.news.search_news.tpl.html');

?>
