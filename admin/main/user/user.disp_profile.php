<?PHP

    $displaySQL = "SELECT * FROM sionapros_users WHERE username = '{$_SESSION['loginUsername']}'";
    $result = $db->execute($displaySQL);

    $smarty->assign('usr', $result[0]);

    #fetch tpl
    $content = $smarty->fetch("./user/user.disp_profile.tpl.html");

?>