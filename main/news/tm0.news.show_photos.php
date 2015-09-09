<?PHP

    # retrieve news_no
    $news_no = $_GET['news_no'];
    #house images
    $photoSQL = "SELECT * FROM sionapros_news WHERE news_no = '$news_no'";
    $photos = $db->execute($photoSQL);

    $smarty->assign('imgs', $photos);
    #fetch tpl
    $content = $smarty->fetch("./news/tm0.news.show_photos.tpl.html");

?>