<?php

    #formulate where clause of search query
    $searchSpec = "";
    if($_POST['fname']) $searchSpec .= "AND firstname LIKE '%".$_POST['fname']."%' ";
    if($_POST['lname']) $searchSpec .= "AND lastname LIKE '%".$_POST['lname']."%' ";
    #if($_POST['dob']) $searchSpec .= "AND date_of_birth LIKE '%".$_POST['dob']."%' ";

    if($_POST['Search'] || $_GET['l'])
    $_SESSION['search'] = $searchSpec;
    #check if its a new search
    if ($_POST['Search'] ){
        #reset session data
        SmartyPaginate::reset();
        // required connect
        SmartyPaginate::connect();
        // set items per page
        SmartyPaginate::setLimit($_POST['results']);
    }
    else
    SmartyPaginate::connect();

    #set url for links
    SmartyPaginate::setUrl('./index.php?path=./main/user/user.show_user.php');
    SmartyPaginate::setPrevText('PREV');
    SmartyPaginate::setNextText('NEXT');

    function getSearchResults(& $dbcon) {

        $X = SmartyPaginate::getCurrentIndex();
        $Y = SmartyPaginate::getLimit();
        $searchSQL = "SELECT firstname,lastname,identifier FROM sionapros_users";
        $searchSQL .= " WHERE 1 {$_SESSION['search']} ORDER BY identifier ASC LIMIT $X,$Y";

        $result = $dbcon->execute($searchSQL);

        foreach ($result as $row) {
            // collect each record into $_data
            $data[] = $row;
        }

        // now we get the total number of records from the table
        $rowsSQL = "SELECT COUNT(*) FROM sionapros_users WHERE 1 {$_SESSION['search']}";
        $dbcon->query($rowsSQL);
        #$rowNo = $rows[0];

        SmartyPaginate::setTotal($dbcon->getValue());

        $dbcon->free();
        return $data;

    }
    $results = getSearchResults($db);
    if ( sizeof($results) == 0){
        $searchMsg = 'NO MATCHES WERE FOUND';
        $smarty->assign('searchMsg',$searchMsg);
    }
    else{
        // assign your db results to the template
        $smarty->assign('user', $results);
        // assign {$paginate} var
        SmartyPaginate::assign($smarty);
    }

    $content = $smarty->fetch('./user/user.show_user.tpl.html');

    SmartyPaginate::disconnect();
?>

