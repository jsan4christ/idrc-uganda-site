<?PHP

    
    #create form object
    $staff = new Formitable($db, 'sionapros_newsletter_receipient');
    #set primary key field
    $staff->setPrimaryKey('id');
    #set encryption key
    $staff->setEncryptionKey("g00D_3nCr4p7");
    #set identifier field
    $staff->setIdentifier('id');
    #unique username
    $staff->uniqueField('email', "This Email Address already exists");

    $staff->forceTypes(array('id'),
        array('hidden'));
    #custom labels
    $staff->labelFields(array('fname','lname','email'),
        array('First Name *','Last Name *','Email Address *'));
    //set up regular expressions for field validation
    $staff->registerValidation("required",".+","Field MUST be filled in please.");
    #$staff->setDateField('account_expiry_date');
    $staff->setPasswordField('password');
    //set up fields for validation using regexs above
    $staff->validateField("firstname", "required");
    $staff->validateField("lastname", "required");
    $staff->validateField("email", "required");
    
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
        $id = $staff->printField('id');
        $smarty->assign('id', $id);
        $fname = $staff->printField('fname');
        $smarty->assign ('fname', $fname);
        $lname = $staff->printField('lname');
        $smarty->assign ('lname', $lname);
        $email = $staff->printField('email');
        $smarty->assign('email', $email);
        
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
    $content	= $smarty->fetch( "./news/news.reg_subscriber.tpl.html" );


?>