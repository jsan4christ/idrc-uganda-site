<?php

    #get unit_no and unit_name
    $id = trim($_GET['id']);
    #$name = trim($_GET['name']);
    $doc = trim($_GET['doc']);

    $smarty->assign('id', $id);
    #$smarty->assign('name', $name);
    $smarty->assign('doc', $doc);


    if($_GET['delete'] === 'confirmed' ){

        $delSQL = "DELETE FROM sionapros_pubs WHERE id = '$id' AND doc = '$doc'";

        if( $db->query($delSQL) ){
            #delete document form docs folder
            unlink($doc);
            $msg = "Document was successfully deleted";
        }
        else{
            $msg = "Document couldnt be deleted.";
        }
    }

    #assign msg
    $smarty->assign('msg', $msg);
    #fetch tpl
    $content = $smarty->fetch('./pubs/pubs.del_pub.tpl.html');

?>
