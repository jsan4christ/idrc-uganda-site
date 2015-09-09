<?PHP

    
    #create form object
    $staff = new Formitable($db, 'sionapros_users');
    #set primary key field
    $staff->setPrimaryKey('identifier');
    #set encryption key
    $staff->setEncryptionKey("g00D_3nCr4p7");
    #set identifier field
    $staff->setIdentifier('identifier');
    #unique username
    $staff->uniqueField('username', "This Username already exists");

    $staff->forceTypes(array('identifier','password','reg_date'),
        array('hidden','password','hidden'));
    $staff->forceTypes(array('change_password','account_status'),
        array('hidden','hidden'));
    #custom labels
    $staff->labelFields(array('firstname','lastname'),
        array('First Name *','Last Name *'));
    $staff->labelFields(array('username','password'),
        array('User Name *','Password *'));
    //set up regular expressions for field validation
    $staff->registerValidation("required",".+","Field MUST be filled in please.");
    #$staff->setDateField('account_expiry_date');
    $staff->setPasswordField('password');
    //set up fields for validation using regexs above
    $staff->validateField("firstname", "required");
    $staff->validateField("lastname", "required");
    $staff->validateField("username", "required");
    $staff->validateField("password", "required");
    
    #set default values
    $staff->setDefaultValue('reg_date', date("Y-m-d H:i:s"));
    $staff->setDefaultValue('change_password', 'Yes');
    $staff->setDefaultValue('account_status', 'Active');
    
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
        $id = $staff->printField('identifier');
        $smarty->assign('id', $id);
        $fname = $staff->printField('firstname');
        $smarty->assign ('fname', $fname);
        $lname = $staff->printField('lastname');
        $smarty->assign ('lname', $lname);
        $reg_date = $staff->printField('reg_date');
        $smarty->assign('reg_date', $reg_date);
        $username = $staff->printField('username');
        $smarty->assign('username', $username);
        $password = $staff->printField('password');
        $smarty->assign('password', $password);
        $pass_verify = $staff->printField('password','',true);
        $smarty->assign('pass_verify', $pass_verify);
        $chg_pass = $staff->printField('change_password');
        $smarty->assign('chg_pass', $chg_pass);
        $acc_status = $staff->printField('account_status');
        $smarty->assign('acc_status', $acc_status);

        $end = $staff->multiPage("end");
        $smarty->assign('end', $end);
        $staffClose = $staff->closeForm();
        $smarty->assign('staffClose3', $staffClose);

    }
    else{
        #submit msg
        $smarty->assign('updateMsg', $staff->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);

    }
    $content	= $smarty->fetch( "./user/user.reg_user.tpl.html" );


?>