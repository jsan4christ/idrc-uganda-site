<?php

    #formulate where clause of search query
    $searchSpec = "";
    if($_POST['category']) $searchSpec .= "AND n.category = {$_POST['category']} ";
    if($_POST['title']) $searchSpec .= "AND n.title LIKE '%".$_POST['title']."%' ";
    #store where clause in the session
    if($_REQUEST['Search'])
    $_SESSION['search'] = $searchSpec;
    #check if its a new search
    if ($_REQUEST['Search']){
        #reset session data
        SmartyPaginate::reset();
        // required connect
        SmartyPaginate::connect();
        // set items per page
        SmartyPaginate::setLimit($_REQUEST['results']);
    }
    else
    SmartyPaginate::connect();

    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/news/tm0.news.show_news.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        #$searchSQL = sprintf("SELECT * FROM ehmis_personnel_main WHERE 1 {$_SESSION['search']} ORDER BY identifier ASC LIMIT %d,%d",
        #    					SmartyPaginate::getCurrentIndex(), SmartyPaginate::getLimit());
        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT n.*,c.value FROM sionapros_news AS n INNER JOIN sionapros_categories AS c ON";
        $searchSQL .= " n.category = c.id WHERE 1 {$_SESSION['search']} ORDER BY n.news_no DESC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_news AS n WHERE 1 {$_SESSION['search']}";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO ARTICLES WERE FOUND';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('news', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./news/tm0.news.show_news.tpl.html');
    SmartyPaginate::disconnect();
?>

