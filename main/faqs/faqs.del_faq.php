<?php

    #get id_no and name
    $id = $_GET['id'];

    $smarty->assign('id', $id);

    if( $_GET['delete'] == 'confirmed' ){
        $delSQL = "DELETE FROM sionapros_faqs WHERE id = '$id'";
        if($db->query($delSQL)){
            $msg = "The FAQ was removed from the database.";
        }
        else{
            $msg = "Action Failed. Please try again later.";
        }
    }

    #assign msg
    $smarty->assign('msg', $msg);
    #fetch tpl
    $content = $smarty->fetch('./faqs/faqs.del_faq.tpl.html');

?>
