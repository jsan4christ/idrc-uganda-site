<?php

    include_once("./classes/classListbox.php");

    $profSQL = "SELECT profile,profile_id FROM sionapros_profiles";

    $profile = new classListBox($db, "profiles");
    $profile->set_query($profSQL,"profile_id","profile");
    #$userMods->set_postback(true);
    $profs = $profile->display();
    $smarty->assign('profs', $profs);

    #check that new name doesnt match an already existing name
    function check(){
        global $_POST, $db;
        $chkSQL = "SELECT * FROM sionapros_profiles WHERE profile = '{$_POST['newname']}'";
        $chkSQL .= " AND profile_id != {$_POST['profiles']}";
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
        SmartyValidate::register_validator('prof', 'profiles', 'notEmpty');
        SmartyValidate::register_validator('newprof', 'newname', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            require_once('./classes/security.class.php');
            #get $_POST info
            $profile_id = $profile->get_selectedItemKey();
            $new_name = trim($_POST['newname']);

            #get the old profile name first
            $oldSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = $profile_id";
            $old = $db->execute($oldSQL);

            $security = new Security($db);
            if( $security->updateProfile($profile_id, $new_name)){

                $msg = "The profile name was changed from {$old[0]['profile']} to {$new_name}.";
                $smarty->assign( 'updateMsg', $msg );

            }else{
                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );

            }
            unset($_SESSION['profiles']);
            unset($_SESSION['prevPath']);
        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            # $content = $smarty->fetch('./main/security/chg_nav_profile.tpl.html');
        }

    }
    $content = $smarty->fetch('./security/tm0.security.chg_profile.tpl.html');

?>
