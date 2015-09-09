<?PHP

    #get staff personnel_no
    #$staff_no = $_GET['identifier'];
    if ( isset($_GET['identifier']) ){
        $_SESSION['upd_no'] = $_GET['identifier'];
    }
    #create form object
    $staff = new Formitable($db, 'sionapros_users');
    #set primary key field
    $staff->setPrimaryKey('identifier');
    $staff->setEncryptionKey("qHm1rC_3nCt4p7");
    #retrieve staff's data
    $staff->getRecord($_SESSION['upd_no']);
    #hide primary key field
    $staff->hideField('identifier');
    #customiszing form
    $staff->hideField('reg_date');
    $staff->hideField('identifier');
    $staff->hideField('username');
    $staff->hideField('password');

    $staff->forceTypes(array('account_status','change_password'),
        array('select','select'));
    #custom labels
    $staff->labelFields(array('firstname','lastname'),
        array('First Name *','Last Name *'));
    $staff->labelFields(array('account_status','change_password'),
        array('Account Status *','Change Password *'));
    //set up regular expressions for field validation
    $staff->registerValidation("required",".+","Field MUST be filled in please.");

    //set up fields for validation using regexs above
    $staff->validateField("firstname", "required");
    $staff->validateField("lastname", "required");
    $staff->validateField("change_password", "required");
    $staff->validateField("account_status", "required");
    #$staff->validateField("country", "required");
    
    #submit msg
    $nmSQL = "SELECT firstname,lastname FROM sionapros_users WHERE identifier = {$_SESSION['upd_no']}";
    $nm = $db->execute($nmSQL);
    $staff->msg_updateSuccess = "{$nm[0]['firstname']} {$nm[0]['lastname']}'s account data was changed.";

    //set all output to be returned instead of printed
    $staff->returnOutput = true;

    //test for last page and no errors to submit form, otherwise start form
    if( @$_POST['formitable_multipage']!= "end" || isset($staff->errMsg) ){
        $staffOpen = $staff->openForm();
        $smarty->assign('staffOpen', $staffOpen);
    }
    else
    $staff->submitForm(false);

    //first page - test for no submit OR errors set with a field on the first page
    if( !isset($_POST['submit']) || (isset($staff->errMsg) && isset($_POST['firstname'])) ){
        #print first page
        $page1 = "page 1";
        $smarty->assign('page1', $page1);
        $fname = $staff->printField('firstname');
        $smarty->assign ('firstname', $fname);
        $lname = $staff->printField('lastname');
        $smarty->assign ('lastname', $lname);
        $acc = $staff->printField('account_status');
        $smarty->assign('acc', $acc);
        $chg = $staff->printField('change_password');
        $smarty->assign('chg', $chg);
        
        $end = $staff->multiPage("end");
        $smarty->assign('end', $end);
        $staffClose = $staff->closeForm();
        $smarty->assign('staffClose2', $staffClose);

    }
    else{
        $smarty->assign('updateMsg', $staff->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);
        unset($_SESSION['upd_no']);
    }
    $content	= $smarty->fetch( "./user/user.upd_user.tpl.html" );

?>