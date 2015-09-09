<?php

    include_once("./classes/classListbox.php");

    $profSQL = "SELECT profile,profile_id FROM sionapros_profiles";

    $profile = new classListBox($db, "profiles");
    $profile->set_query($profSQL,"profile_id","profile");
    #$userMods->set_postback(true);
    $profs = $profile->display();
    $smarty->assign('profs', $profs);

    if(empty($_POST)) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our sionaprosalidators
        SmartyValidate::register_validator('prof', 'profiles', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            require_once('./classes/security.class.php');
            #get $_POST info
            $profile_id = $profile->get_selectedItemKey();

            #get the old profile name first
            $oldSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = $profile_id";
            $old = $db->execute($oldSQL);

            $security = new Security($db);
            if( $security->delProfile($profile_id)){

                $msg = "The {$old[0]['profile']} profile was removed from the database.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/del_nasionapros_profile.tpl.html');

            }else{

                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/del_nasionapros_profile.tpl.html');


            }
            unset($_SESSION['profiles']);
            unset($_SESSION['prevPath']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/del_nasionapros_profile.tpl.html');
        }

    }
    $content = $smarty->fetch('./security/tm0.security.del_profile.tpl.html');

?>
