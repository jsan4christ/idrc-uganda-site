<?php 

    $news_no = $_GET['news_no'];

    if( isset($_GET['news_no'])){
        $newsSQL = "SELECT * FROM sionapros_news WHERE news_no = '$news_no'";
        $result = $db->execute($newsSQL);
        $smarty->assign('details', $result[0]);
    }
    else
    $smarty->assign('msg', 'News Error');

    $smarty->assign('news_no', $news_no);

    #news article has been submitted
//    if( isset($_POST['submit']) && $_POST['submit'] == 'submit' ){
//        $smarty->assign('msg2', "A News article was recorded.");
//    }

    $content = $smarty->fetch('./news/tm0.news.preview_news.tpl.html');

?>