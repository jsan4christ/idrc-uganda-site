<?php

    // required connect
    SmartyPaginate::connect();
    // set items per page
    SmartyPaginate::setLimit(10);

    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/cats/main.show_categories.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT * FROM sionapros_categories WHERE 1 ORDER BY id ASC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_categories WHERE 1 ";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NONE HAVE BEEN RECORDED YET';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('cats', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./cats/main.show_categories.tpl.html');
    SmartyPaginate::disconnect();
?>

