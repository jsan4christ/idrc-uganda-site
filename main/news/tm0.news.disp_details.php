<?PHP

    # retrieve staff personnel_no,fname,lname
    $news_no = $_GET['news_no'];

    $displaySQL = "SELECT * FROM sionapros_news WHERE news_no = $news_no";
    $result = $db->execute($displaySQL);

    $smarty->assign('news', $result[0]);
    #fetch tpl
    $content = $smarty->fetch("./news/tm0.news.disp_details.tpl.html");

?>