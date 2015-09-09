<?php

    #get unit_no and unit_name
    $id = $_GET['id'];
    $s = $_GET['s'];
    $msg = "";

    if( $s == 'a' ){
        $status = 'Added';
        $msg = "{$_GET['fname']} {$_GET['lanme']}  is now in status 'Added'.";
    }
    elseif( $s == 'r' ){
        $status = 'Removed';
        $msg = "{$_GET['fname']} {$_GET['lanme']}  is now in status 'Removed'.";
    }

    $updSQL = "UPDATE sionapros_newsletter_receipient SET status = '$status' WHERE id = $id";

    if( $db->query($updSQL) ){
        $smarty->assign('msg', $msg);
    }
    else{
        $smarty->assign('msg', 'Action Failed.');
    }

    #fetch tpl
    $content = $smarty->fetch('./news/news.newsletter_status.tpl.html');

?>
