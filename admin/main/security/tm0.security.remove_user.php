<?php

    include_once("./classes/classListbox.php");
    #include_once('./classes/main/security.class.php');
    #db users
    $usrSQL = "SELECT username FROM sionapros_users WHERE account_status = 'Active' AND username != 'SADMIN'";

    $user = new classListBox($db, "users");
    $user->set_query($usrSQL,"username","username");
    $user->set_postback(true);
    $chUser = $user->display();
    $smarty->assign('user', $chUser);
    #their profiles
    $profSQL = "SELECT user.profile_id,profiles.profile FROM sionapros_user_profiles AS user INNER JOIN sionapros_profiles AS profiles ON";
    $profSQL .= " user.profile_id = profiles.profile_id WHERE user.username = '{$user->get_selectedItemKey()}'";

    $profiles = new classListBox($db, "userprofiles");
    $profiles->set_query($profSQL, "profile_id", "profile");
    $profiles->set_postback(true);
    $userProf = $profiles->display();
    $smarty->assign('userProf', $userProf);

    if($profiles->get_selectedItemKey() != ''){
        $smarty->assign('button', 'visible');
        unset($_SESSION['userprofiles']);
    }

    if(!isset($_POST['submit'])) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('usr', 'users', 'notEmpty');
        SmartyValidate::register_validator('prof', 'userprofiles', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            require_once('./classes/security.class.php');
            #get $_POST info
            $profile_id = $profiles->get_selectedItemKey();
            $username = $user->get_selectedItemKey();

            $security = new Security($db);
            if( $security->removeUser($username, $profile_id)){
                #profile name
                $nmpSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = {$profile_id}";
                $nmp = $db->execute($nmpSQL);
                #user details
                $nmSQL = "SELECT firstname,lastname FROM sionapros_users WHERE username = '{$username}'";
                $nm = $db->execute($nmSQL);

                $msg = "{$nm[0]['firstname']} {$nm[0]['lastname']} no longer has access to objects assigned to the {$nmp[0]['profile']} profile";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/remove_user.tpl.html');

            }else{

                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/remove_user.tpl.html');

            }
            unset($_SESSION['users']);
            unset($_SESSION['userprofiles']);
            unset($_SESSION['prevPath']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/remove_user.tpl.html');
        }

    }
    $content = $smarty->fetch('./security/tm0.security.remove_user.tpl.html');

?>
