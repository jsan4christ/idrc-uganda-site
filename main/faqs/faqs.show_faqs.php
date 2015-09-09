<?PHP

    #reset session data
    SmartyPaginate::reset();
    // required connect
    SmartyPaginate::connect();
    // set items per page
    SmartyPaginate::setLimit(10);


    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/faqs/faqs.show_faqs.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT fq.*,C.value FROM sionapros_faqs AS fq INNER JOIN sionapros_categories";
        $searchSQL .= " AS C ON fq.category = C.id ORDER BY C.id,fq.id LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);echo $dbcon->error;

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_faqs WHERE 1";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO FAQs HAVE BEEN RECORDED YET';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('faqs', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./faqs/faqs.show_faqs.tpl.html');
    SmartyPaginate::disconnect();
?>

