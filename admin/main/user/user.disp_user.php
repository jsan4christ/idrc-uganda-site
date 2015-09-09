<?PHP

    # retrieve staff personnel_no,fname,lname
    $identifier = $_GET['identifier'];

    $displaySQL = "SELECT * FROM sionapros_users WHERE identifier = '{$_GET['identifier']}'";
    $result = $db->execute($displaySQL);

    $smarty->assign('user', $result[0]);
    #fetch tpl
    $content = $smarty->fetch("./user/user.disp_user.tpl.html");

?>