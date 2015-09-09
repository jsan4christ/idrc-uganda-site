<?php

    $searchSpec = "";
    if($_GET['s'] == 'o') $searchSpec .= "AND status = 'Open' ";
    if($_GET['s'] == 'a') $searchSpec .= "AND status = 'Added' ";
    if($_GET['s'] == 'r') $searchSpec .= "AND status = 'Removed' ";

    if($_GET['s'])
    $_SESSION['search'] = $searchSpec;

    if ($_POST['Search'] ){
        #reset session data
        SmartyPaginate::reset();
        // required connect
        SmartyPaginate::connect();
        // set items per page
        SmartyPaginate::setLimit(10);
    }
    else
    SmartyPaginate::connect();
    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/news/news.show_subscribers.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT * FROM sionapros_newsletter_receipient WHERE 1 {$_SESSION['search']} ORDER BY id ASC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_newsletter_receipient WHERE 1 {$_SESSION['search']}";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NONE CURRENTLY IN THIS CATEGORY';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('cats', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./news/news.show_subscribers.tpl.html');
    SmartyPaginate::disconnect();
?>

