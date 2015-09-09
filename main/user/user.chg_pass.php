<?php

    if(empty($_POST)) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('password', 'oldpassword', 'notEmpty');
        SmartyValidate::register_validator('password1', 'newpassword:6:-1', 'isLength');
        SmartyValidate::register_validator('password2', 'newpassword:confpassword', 'isEqual');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            // no errors, done with SmartyValidate
            #ccreate authenticatio object
            $userAuth = new Authentication();

            $oldPass = trim($_POST['oldpassword']);
            $newPass = trim($_POST['newpassword']);

            $cryptNewPass = crypt($newPass,'yxpijaui93');

            if( $userAuth->authenticateUser($db, $_SESSION['loginUsername'], $oldPass)){
                #perform password update
                $updatePass = "UPDATE sionapros_users SET password = '{$cryptNewPass}',change_password = 'No' WHERE username = '{$_SESSION['loginUsername']}'";
                if ( $userAuth->chgPassword($db, $_SESSION['loginUsername'], $newPass)){
                    #set session variable 'chg_pass'
                    $_SESSION['chg_pass'] = 'done';

                    $msg = "Password has been changed. Please log out and re-log in to ensure that your new password works.";
                    $smarty->assign( 'updateMsg', $msg );
                    #$content = $smarty->fetch('./main/staff/chg_pass.tpl.html');
                }
                else{

                    #update failed
                    $msg = "Action Failed. Please try again later or contact the Administrator.";
                    $smarty->assign( 'updateMsg', $msg );
                    #$content = $smarty->fetch('./main/staff/chg_pass.tpl.html');

                }
                unset($_SESSION['prevPath']);
            }
            else{
                // new form, we (re)set the session data
                SmartyValidate::connect($smarty, true);
                // register our validators
                SmartyValidate::register_validator('password', 'oldpassword', 'notEmpty');
                SmartyValidate::register_validator('password1', 'newpassword:6:-1', 'isLength');
                SmartyValidate::register_validator('password2', 'newpassword:confpassword', 'isEqual');
                #old password doesnt match the one in the DB
                $msg = "Authentication error! The old Password doesnt match the one in the Database . Either Try again or Contact the System Administrator.";
                $smarty->assign( 'updateMsg', $msg );
                #$content = $smarty->fetch('./main/staff/chg_pass.tpl.html');
            }
        } else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/staff/chg_pass.tpl.html');
        }
    }
    $content = $smarty->fetch('./user/user.chg_pass.tpl.html');

?>