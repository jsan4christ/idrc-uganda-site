<?php

    #formulate where clause of search query
    $searchSpec = "";
    if($_POST['category']) $searchSpec .= "AND p.category = {$_POST['category']} ";
    if($_POST['title']) $searchSpec .= "AND p.title LIKE '%".$_POST['title']."%' ";
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
    SmartyPaginate::setUrl('./index.php?path=./main/pubs/pubs.show_pubs.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon, $proj_no) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT p.*,c.value FROM sionapros_pubs AS p INNER JOIN sionapros_categories AS c";
        $searchSQL .= " ON p.category = c.id WHERE 1 {$_SESSION['search']} ORDER BY id DESC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_pubs AS p WHERE 1 {$_SESSION['search']}";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db, $proj_no);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO PUBLICATIONS HAVE BEEN UPLOADED';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('docs', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $smarty->assign('proj_no', $proj_no);

    $content = $smarty->fetch('./pubs/pubs.show_pubs.tpl.html');
    SmartyPaginate::disconnect();
?>

