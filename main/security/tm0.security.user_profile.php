<?php

    include_once("./classes/classListbox.php");
    include_once('./classes/security.class.php');

    $usrSQL = "SELECT username FROM sionapros_users WHERE account_status = 'Active' AND username != 'SADMIN'";

    $user = new classListBox($db, "dbusers");
    $user->set_query($usrSQL,"username","username");
    $user->set_postback(true);
    $chUser = $user->display();
    $smarty->assign('user', $chUser);

    $security = new Security($db);
    $profAssigned = $security->userProfiles($user->get_selectedItemKey());

    if( count($profAssigned) == 0)
    $msg = 'none';

    $smarty->assign('msg', $msg);
    $smarty->assign('profiles', $profAssigned);

    $content = $smarty->fetch('./security/tm0.security.user_profile.tpl.html');

?>
