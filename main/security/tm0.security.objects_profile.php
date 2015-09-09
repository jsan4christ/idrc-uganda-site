<?php

    include_once("./classes/classListbox.php");
    include_once('./classes/security.class.php');

    $profSQL = "SELECT profile,profile_id FROM sionapros_profiles";

    $profile = new classListBox($db, "profiles");
    $profile->set_query($profSQL,"profile_id","profile");
    $profile->set_postback(true);
    $profiles = $profile->display();
    $smarty->assign('profiles', $profiles);

    $security = new Security($db);
    $objects = $security->objectProfiles($profile->get_selectedItemKey());

    if( count($objects) == 0)
    $msg = 'none';

    $smarty->assign('msg', $msg);
    $smarty->assign('objects', $objects);

    $content = $smarty->fetch('./security/tm0.security.objects_profile.tpl.html');

?>
