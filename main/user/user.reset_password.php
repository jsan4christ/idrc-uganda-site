<?php

    #include_once("./classes/formGen/classListbox.php");

    #db users
    $usrSQL = "SELECT username,firstname,lastname FROM sionapros_users WHERE account_status = 'Active' AND username != 'SADMIN'";
    $users = $db->execute($usrSQL);

    $smarty->assign('users', $users);

    if(empty($_POST)) {
        // new form, we (re)set the session data
        Smartyvalidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('usr', 'users', 'notEmpty');
        SmartyValidate::register_validator('password1', 'newpassword', 'notEmpty');
        SmartyValidate::register_validator('password2', 'newpassword:confpassword', 'isEqual');
        #SmartyValidate::register_validator('newprof', 'newname', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            #require_once('./classes/main/tm0.security.class.php');
            #get $_POST info
            $username = $_POST['users'];
            $newPass = trim($_POST['newpassword']);

            $cryptedPass = crypt($newPass,'yxpijaui93');

            $passSQL = "UPDATE sionapros_users SET password = '$cryptedPass',change_password = 'Yes' WHERE username = '$username'";

            #$security = new Security($db);
            if( $db->query($passSQL)){
                #get users name
                $nmSQL = "SELECT firstname,lastname FROM sionapros_users WHERE username = '$username'";
                $nm = $db->execute($nmSQL);

                $msg = $nm[0]['firstname'].' '.$nm[0]['lastname']."\'s password was reset.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/chg_profile.tpl.html');

            }else{

                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/security/chg_profile.tpl.html');

            }
            unset($_SESSION['users']);
            unset($_SESSION['prevPath']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/chg_profile.tpl.html');
        }

    }
    $content = $smarty->fetch('./user/user.reset_password.tpl.html');

?>
