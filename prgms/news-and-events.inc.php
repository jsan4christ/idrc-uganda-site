	<?PHP

    require_once( './tree/TreeMenuXL.php' );

    #current year
    $yr = date('Y');

    #news and pubs highlights.
	#retrieve news
    $newsSQL = "SELECT * FROM sionapros_news ORDER BY pub_date DESC LIMIT 5";
    $news = $db->execute($newsSQL);

    $smarty->assign('news', $news);

    #retrieve pubs
    $pubsSQL = "SELECT * FROM sionapros_pubs ORDER BY pub_date DESC LIMIT 5";
    $pubs = $db->execute($pubsSQL);

    $smarty->assign('pubs', $pubs);
	#end of news and pubs highlights.
    #formulate where clause of search query
    $searchSpec = "";
    if($_REQUEST['category']) $searchSpec .= "AND category = '{$_REQUEST['category']}' ";
    if($_REQUEST['year']) $searchSpec .= "AND EXTRACT(YEAR FROM pub_date) = '{$_REQUEST['year']}' ";

    #store where clause in the session
    #if($_REQUEST['year'])
    #$_SESSION['search'] = $searchSpec;
    #check if its a new search
    if ($_REQUEST['Search']){
        #reset session data
        SmartyPaginate::reset();
        // required connect
        SmartyPaginate::connect();
        // set items per page
        SmartyPaginate::setLimit(5);
    }
    else
    SmartyPaginate::connect();

    #set url for links
    SmartyPaginate::setUrl('./index.php?prgm=news-and-events');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon, $searchSpec) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT * FROM sionapros_news WHERE 1 {$searchSpec} ORDER BY pub_date DESC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);
        foreach( $result as $row ) {
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_news WHERE 1 {$searchSpec}";
        $dbcon->query($rowsSQL);

        SmartyPaginate::setTotal($dbcon->getValue());

        return $data;

    }
    $results = getSearchResults($db, $searchSpec);
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

    $otpt_contentbox	= $smarty->fetch( "news/news-and-events.cb.tpl.html" );
    SmartyPaginate::disconnect();


?>





