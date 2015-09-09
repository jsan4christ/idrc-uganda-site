<?php

    #get unit_no and unit_name
    $id = $_GET['identifier'];
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];

    $smarty->assign('identifier', $id);
    $smarty->assign('fname', $fname);
    $smarty->assign('lname', $lname);


    if($_GET['delete'] == 'confirmed' ){
        $delSQL = "DELETE FROM sionapros_users WHERE identifier = '$id'";
        if($db->query($delSQL)){
            $msg = "{$fname} {$lname}'s user account was deleted";
        }
        else{
            $msg = "Action Failed. Please try again later.";
        }
    }

    #assign msg
    $smarty->assign('msg', $msg);
    #fetch tpl
    $content = $smarty->fetch('./user/user.del_user.tpl.html');

?>
