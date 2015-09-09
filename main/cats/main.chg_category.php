<?php

    require_once("./classes/classListbox.php");

    $SQL = "SELECT value,id FROM sionapros_categories ORDER BY id";

    $cat = new classListBox($db, "cats");
    $cat->set_query($SQL,"id","value");
    #$userMods->set_postback(true);
    $groups = $cat->display();
    $smarty->assign('cat', $groups);

    #check that new name doesnt match an already existing name
    function check(){
        global $_POST, $db;
        $chkSQL = "SELECT * FROM sionapros_categories WHERE value = '{$_POST['newname']}'";
        $chkSQL .= " AND id != {$_POST['cats']}";
        if( count($db->execute($chkSQL)) == 0 )
        return true;
        else
        return false;
    }

    if(empty($_POST)) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        #register criteria
        SmartyValidate::register_criteria('alreadyExists', 'check');
        // register our validators
        SmartyValidate::register_validator('grp', 'cats', 'notEmpty');
        SmartyValidate::register_validator('newgrp', 'newname', 'notEmpty');
        // display form
        #$content = $smarty->fetch('./main/allergy/tm0.allergy.chg_allergy_group.tpl.html');
    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            require_once('./classes/cats.class.php');
            #get $_POST info
            $id = $cat->get_selectedItemKey();
            $new_name = trim($_POST['newname']);

            $con = new Cats($db);
            if( $con->updCategory($id, $new_name)){

                $msg = "The category name was successfully changed";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/allergy/chg_allergy_group.tpl.html');
            }else{
                #update failed
                $msg = "The category name could not be changed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/allergy/chg_allergy_group.tpl.html');

            }
            unset($_SESSION['prevPath']);
            unset($_SESSION['cats']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/allergy/chg_allergy_group.tpl.html');
        }

    }

    $content = $smarty->fetch('./cats/main.chg_category.tpl.html');

?>
