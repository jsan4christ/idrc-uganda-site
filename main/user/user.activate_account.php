<?php

    include_once("./classes/classListbox.php");

    #db users
    $usrSQL = "SELECT username,firstname,lastname FROM sionapros_users WHERE account_status = 'Inactive'";
    $users = $db->execute($usrSQL);echo $db->error;

    $smarty->assign('users', $users);

    if(empty($_POST)) {
        // new form, we (re)set the session data
        SmartyValidate::connect($smarty, true);
        // register our validators
        SmartyValidate::register_validator('usr', 'users', 'notEmpty');
        // display form

    } else {
        // validate after a POST
        SmartyValidate::connect($smarty);
        if(SmartyValidate::is_valid($_POST)) {

            SmartyValidate::disconnect();
            #require_once('./classes/main/tm0.security.class.php');
            #get $_POST info
            $username = $_POST['users'];

            $passSQL = "UPDATE sionapros_users SET account_status = 'Active' WHERE username = '$username'";

            #$security = new Security($db);
            if( $db->query($passSQL)){
                #get users name
                $nmSQL = "SELECT firstname,lastname FROM sionapros_users WHERE username = '$username'";
                $nm = $db->execute($nmSQL);

                $msg = $nm[0]['firstname'].' '.$nm[0]['lastname']."'s account was activated.";
                $smarty->assign( 'updateMsg', $msg );
                
            }else{

                #update failed
                $msg = "Action Failed. Please try again later.";
                $smarty->assign( 'updateMsg', $msg );
                
            }
            unset($_SESSION['users']);
            unset($_SESSION['prevPath']);

        }else {
            // error, redraw the form
            $smarty->assign($_POST);
            #$content = $smarty->fetch('./main/security/chg_profile.tpl.html');
        }

    }
    $content = $smarty->fetch('./user/user.activate_account.tpl.html');

?>
