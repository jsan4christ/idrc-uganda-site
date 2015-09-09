<?php

    #get unit_no and unit_name
    $id = $_GET['id'];
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];

    $smarty->assign('id', $id);
    $smarty->assign('fname', $fname);
    $smarty->assign('lname', $lname);


    #if($_GET['delete'] == 'confirmed' ){
        $delSQL = "DELETE FROM sionapros_newsletter_subscriber WHERE id = '$id'";
        if($db->query($delSQL)){
            $msg = "You have been removed from the Newsletter List.";
        }
        else{
            $msg = "Action Failed. Please try again later.";
        }
    #}

    #assign msg
    $smarty->assign('msg', $msg);
    #fetch tpl
    $content = $smarty->fetch('./news/news.del_subscriber.tpl.html');

?>
