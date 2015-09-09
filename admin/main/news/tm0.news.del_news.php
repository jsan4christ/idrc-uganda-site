<?php

    #get unit_no and unit_name
    $news_no = $_GET['news_no'];
    $username = $_GET['username'];

    $smarty->assign('news_no', $news_no);
    $smarty->assign('username', $username);

    if($_GET['delete'] == 'confirmed' ){

        #delete photo as well
        $photoSQL = "SELECT photo FROM sionapros_news WHERE news_no = '$news_no'";
        $photo = $db->execute($photoSQL);
        if( $photo[0]['photo'] != '' )
        unlink($photo[0]['photo']);

        $delSQL = "DELETE FROM sionapros_news WHERE news_no = '$news_no'";
        if($db->query($delSQL)){

            $msg = "A news article was deleted";
        }
        else{
            $msg = "Action Failed. Please try again later.";
        }
        #assign msg
        $smarty->assign('msg', $msg);
    }
    #fetch tpl
    $content = $smarty->fetch('./news/tm0.news.del_news.tpl.html');

?>