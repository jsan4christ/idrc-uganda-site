<?php

    #category retrieval
    $catSQL = "SELECT * FROM sionapros_categories";
    $cat = $db->execute($catSQL);

    $smarty->assign('cs', $cat);

    $content = $smarty->fetch('./pubs/pubs.search_pubs.tpl.html');

?>
