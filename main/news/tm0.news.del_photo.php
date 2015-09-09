<?php

    #get news_no and image path
    $news_no = $_GET['news_no'];
    $photo = $_GET['photo'];

    $smarty->assign('news_no', $news_no);
    $smarty->assign('photo', $photo);

    if($_GET['delete'] == 'confirmed' ){
        $delSQL = "UPDATE sionapros_news SET photo = '' WHERE news_no = '$news_no'";
        if($db->query($delSQL)){
            $msg = "A photo for an article was deleted.";
            unlink($photo);
        }
        else{
            $msg = "Action Failed. Please try again later.";
        }
    }
    #assign msg
    $smarty->assign('msg', $msg);
    #fetch tpl
    $content = $smarty->fetch('./news/tm0.news.del_photo.tpl.html');

?>
