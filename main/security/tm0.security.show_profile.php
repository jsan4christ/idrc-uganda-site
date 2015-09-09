<?php

    SmartyPaginate::connect();
    // set items per page
    SmartyPaginate::setLimit(20);

    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/security/tm0.security.show_profile.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();

        $searchSQL = "SELECT * FROM sionapros_profiles ORDER BY profile_id ASC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_profiles";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO PROFILES HAVE BEEN CREATED';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('profile', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./security/tm0.security.show_profile.tpl.html');
    SmartyPaginate::disconnect();
?>

