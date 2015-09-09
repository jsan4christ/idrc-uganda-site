<?php

    $projSQL = "SELECT * FROM sionapros_proj_info";
    $proj = $db->execute($projSQL);

    $smarty->assign('projs', $proj);

    SmartyPaginate::connect();

    // set items per page
    SmartyPaginate::setLimit(10);

    #set url for links
    SmartyPaginate::setUrl('./index.php?prgm=faqs');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT * FROM sionapros_faqs WHERE 1 ORDER BY id LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);
        foreach( $result as $row ) {
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_faqs WHERE 1";
        $dbcon->query($rowsSQL);

        SmartyPaginate::setTotal($dbcon->getValue());

        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO FAQs WERE FOUND';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('faqs', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $otpt_contentbox = $smarty->fetch('./faqs.cb.tpl.html');
    #SmartyPaginate::disconnect();
?>
