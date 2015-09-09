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

    #tree object
    $menu00 = new HTML_TreeMenuXL();
    $nodeProperties = array("cssClass"=>"auto");
    #main node that shows current year
    $node0 = new HTML_TreeNodeXL("Current[{$yr}]", "", $nodeProperties);

    #category nodes under the main node with the tottal number of articles for each categroy
    $sql = "SELECT c.value,c.id,COUNT(cs.id) FROM sionapros_pubs AS cs";
    $sql .= " INNER JOIN sionapros_categories AS c ON cs.category = c.id";
    $sql .= " WHERE EXTRACT(YEAR FROM cs.pub_date) = '{$yr}'";
    $sql .= " GROUP BY cs.category";
    $result = $db->execute($sql);

    foreach( $result as $row ) {
        #create the nodes for the current year
        $node0->addItem(new HTML_TreeNodeXL(
                                        "{$row['value']}[{$row['COUNT(cs.id)']}]",
                                        "index.php?prgm=sionapros-files&category={$row['id']}&year={$yr}",
                $nodeProperties)
        );
    }
    #add node to the tree
    $menu00->addItem($node0);
    #create presentation object
    $currTreeMenu = &new HTML_TreeMenu_DHTMLXL($menu00, array("images"=>"./tree/TMimages"));
    #assign objects
    $smarty->assign_by_ref('currTreeMenu', $currTreeMenu);

    #Archiv Tree
    $menu01 = new HTML_TreeMenuXL();
    #main node that shows current year
    $node1 = new HTML_TreeNodeXL("Archives", "", $nodeProperties);
    #get available years
    $SQL = "SELECT DISTINCT EXTRACT(YEAR FROM pub_date) AS yr FROM sionapros_pubs";
    $SQL .= " WHERE EXTRACT(YEAR FROM pub_date) != '$yr' ORDER BY pub_date DESC";
    $yrs = $db->execute($SQL);

    $i = 0;
    #$yr--;
    foreach( $yrs as $yr ){
        #get total number of articles published in the year
        $yrSQL = "SELECT COUNT(id) FROM sionapros_pubs WHERE EXTRACT(YEAR FROM pub_date) = {$yr['yr']}";
        $yrRow = $db->execute($yrSQL);

        #yr node
        $var = "node_".$i;
        $$var = &$node1->addItem(new HTML_TreeNodeXL("{$yr['yr']}[{$yrRow[0]['COUNT(id)']}]", "", $nodeProperties));

        #category nodes under the main node with the tottal number of articles for each categroy
        $catSQL = "SELECT c.value,c.id,COUNT(cs.id) FROM  sionapros_pubs AS cs";
        $catSQL .= " INNER JOIN sionapros_categories AS c ON cs.category = c.id";
        $catSQL .= " WHERE EXTRACT(YEAR FROM cs.pub_date) = '{$yr['yr']}' GROUP BY cs.category";
        $catRes = $db->execute($catSQL);
        foreach( $catRes as $catRow ){
            #create the nodes for the current year
            $var = "node_".$i;
            $$var->addItem(new HTML_TreeNodeXL(
                                                "{$catRow['value']}[{$catRow['COUNT(cs.id)']}]",
                                                "index.php?prgm=sionapros-files&category={$catRow['id']}&year={$yr['yr']}",
                    $nodeProperties)
            );
        }
        #$yr--;
        $i++;

    }
    #add node to the tree
    $menu01->addItem($node1);

    #create presentation object
    $arcTreeMenu = &new HTML_TreeMenu_DHTMLXL($menu01, array("images"=>"./tree/TMimages"));
    #assign objects
    $smarty->assign_by_ref('arcTreeMenu', $arcTreeMenu);

    #end of code for building the menu#

    #generating content for template##
    #formulate where clause of search query
    $searchSpec = "";
    if($_REQUEST['category']) $searchSpec .= "AND category = '{$_REQUEST['category']}' ";
    if($_REQUEST['year']) $searchSpec .= "AND EXTRACT(YEAR FROM pub_date) = '{$_REQUEST['year']}' ";

    #store where clause in the session
    #if($_REQUEST['year'])
    #$_SESSION['pubs'] = $searchSpec;
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
    SmartyPaginate::setUrl('./index.php?prgm=sionapros-files');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon, $searchSpec) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT * FROM sionapros_pubs WHERE 1 {$searchSpec} ORDER BY pub_date DESC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);
        $i = 0;
        foreach( $result as $row ) {
            #$path = './admin'.substr($row['doc'], 1, strlen($row['doc']));
            $data[$i] = $row;
            #$data[$i]['path'] = $path;

            $i++;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_pubs WHERE 1 {$searchSpec}";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        return $data;

    }
    $results = getSearchResults($db, $searchSpec);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO PUBLICATIONS HAVE BEEN UPLOADED YET';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('file_title', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }
    $currentyr = date('Y');

    $smarty->assign('currentyr',$currentyr);

    $otpt_contentbox	= $smarty->fetch( "publications.cb.tpl.html" );
    SmartyPaginate::disconnect();


?>
