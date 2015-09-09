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

    #iser profiles
    $security = new Security($db);
    $userProfiles = $security->userProfiles($user->get_selectedItemKey());
    if( count($userProfiles) == 0)
    $msg = 'NONE';
    $smarty->assign('msg', $msg);
    $smarty->assign('userProfiles', $userProfiles);
    # profiles
    $profSQL = "SELECT * FROM sionapros_profiles";

    $profiles = new classListBox($db, "toprofile");
    $profiles->set_query($profSQL, "profile_id", "profile");
    $profiles->set_postback(true);
    $userProf = $profiles->display();
    $smarty->assign('userProf', $userProf);

    if( $profiles->get_selectedItemKey() != ''){
        $smarty->assign('button', 'visible');
        unset($_SESSION['toprofile']);
    }

    if(!isset($_POST['submit'])) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('usr', 'users', 'notEmpty');
        SmartyValidate::register_validator('prof', 'toprofile', 'notEmpty');
        // display form
    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            #require_once('./classes/security.class.php');
            #get $_POST info
            $username = $user->get_selectedItemKey();
            $profile_id = $_POST['toprofile'];

            $security = new Security($db);
            if( $security->addUser($username, $profile_id)){
                #profile name
                $nmpSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = {$profile_id}";
                $nmp = $db->execute($nmpSQL);
                #user details
                $nmSQL = "SELECT firstname,lastname FROM sionapros_users WHERE username = '{$username}'";
                $nm = $db->execute($nmSQL);

                $msg = "{$nm[0]['firstname']} {$nm[0]['lastname']} was added to the {$nmp[0]['profile']} Profile";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/add_user.tpl.html');
            }else{

                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/add_user.tpl.html');

            }
            unset($_SESSION['users']);
            unset($_SESSION['toprofile']);
            unset($_SESSION['prevPath']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/add_user.tpl.html');
        }

    }
    $content = $smarty->fetch('./security/tm0.security.add_user.tpl.html');#

?>
