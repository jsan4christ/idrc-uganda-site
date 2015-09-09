<?php

    include_once("./classes/classListbox.php");

    $SQL = "SELECT value,id FROM sionapros_categories ORDER BY id";

    $con = new classListBox($db, "con");
    $con->set_query($SQL,"id","value");
    #$userMods->set_postback(true);
    $grps = $con->display();
    $smarty->assign('cons', $grps);

    if(empty($_POST)) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('grp', 'con', 'notEmpty');
        // display form
        #$content = $smarty->fetch('./main/allergy/tm0.allergy.del_allergy_group.tpl.html');
    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            require_once('./classes/cats.class.php');
            #get $_POST info
            $id = $con->get_selectedItemKey();

            $SQL = "SELECT * FROM sionapros_faqs WHERE category = '$id'";
            $res = $db->execute($SQL);
            $SQL1 = "SELECT * FROM sionapros_news WHERE category = '$id'";
            $res1 = $db->execute($SQL1);
            $SQL2 = "SELECT * FROM sionapros_pubs WHERE category = '$id'";
            $res2 = $db->execute($SQL2);

            if( count($res) == 0 || count($res1) == 0 || count($res2) == 0 ){
                SmartyValidate::disconnect();

                $Cos = new Cats($db);
                if( $Cos->delCategory($id)){

                    $msg = "The Category was successfully deleted";
                    $smarty->assign( 'updateMsg', $msg );
                    #$content = $smarty->fetch('./main/allergy/del_allergy_group.tpl.html');
                }else{
                    #update failed
                    $msg = "The Category could not be deleted. Please try again later.";
                    $smarty->assign( 'updateMsg', $msg );
                    #$content = $smarty->fetch('./main/allergy/del_allergy_group.tpl.html');
                }
                unset($_SESSION['prevPath']);
                unset($_SESSION['con']);
            }else {
                $smarty->assign('msg', 'set');
            }

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/allergy/del_allergy_group.tpl.html');
        }

    }#
    $content = $smarty->fetch('./cats/main.del_category.tpl.html');

?>
