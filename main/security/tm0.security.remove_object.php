<?php

    include_once("./classes/classListbox.php");

    #db profiles
    $profSQL = "SELECT profile_id,profile FROM sionapros_profiles";

    $profiles = new classListBox($db, "dbProfiles");
    $profiles->set_query($profSQL, "profile_id", "profile");
    $profiles->set_postback(true);
    $dbProf = $profiles->display();
    $smarty->assign('profiles', $dbProf);
    #print_r($_POST);
    #db users
    $obSQL = "SELECT object FROM sionapros_object_profile WHERE profile_id = '{$profiles->get_selectedItemKey()}'";

    $object = new classListBox($db, "objectProf");
    $object->set_query($obSQL,"object","object");
    $object->set_postback(true);
    $obProf = $object->display();
    $smarty->assign('objects', $obProf);

    if($object->get_selectedItemKey() != ''){
        $smarty->assign('button', 'visible');
        unset($_SESSION['objectProf']);
    }

    if(!isset($_POST['submit'])) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('prof', 'dbProfiles', 'notEmpty');
        SmartyValidate::register_validator('obj', 'objectProf', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            require_once('./classes/security.class.php');
            #get $_POST info
            $profile_id = $profiles->get_selectedItemKey();
            $object = $object->get_selectedItemKey();

            #get the profile name first
            $oldSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = $profile_id";
            $old = $db->execute($oldSQL);

            $security = new Security($db);
            if( $security->removeObject($object, $profile_id)){

                $msg = "The object {$object} is now either accessible to all or not accessible to user under the {$old} profile.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/remove_object.tpl.html');

            }else{
                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/remove_object.tpl.html');

            }
            unset($_SESSION['prevPath']);
            unset($_SESSION['dbProfiles']);
        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/remove_object.tpl.html');
        }

    }
    $content = $smarty->fetch('./security/tm0.security.remove_object.tpl.html');

?>
