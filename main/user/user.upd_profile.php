<?PHP

    #create form object
    $profile = new Formitable($db, 'sionapros_users');
    #set primary key field
    $profile->setPrimaryKey('identifier');
    $profile->setEncryptionKey("EHm1C_3nCr4p7");

    $persNoSQL = "SELECT identifier FROM sionapros_users WHERE username = '{$_SESSION['loginUsername']}'";
    $res = $db->execute($persNoSQL);

    #retrieve profile's data
    $profile->getRecord($res[0]['identifier']);
    #hide primary key field
    $profile->hideField('identifier');
    #customiszing form
    $profile->hideField('reg_date');
    $profile->hideField('identifier');
    $profile->hideField('username');
    $profile->hideField('password');
    $profile->hideField('change_password');
    $profile->hideFields(array('account_status'));

    #custom labels
    $profile->labelFields(array('firstname','lastname'),
        array('First Name *','Last Name *'));
    //set up regular expressions for field validation
    $profile->registerValidation("required",".+","Input is required.");

    //set up fields for validation using regexs above
    $profile->validateField("firstname", "required");
    $profile->validateField("lastname", "required");
    #set default values
    #submit msg
    $profile->msg_updateSuccess = "Your Profile was updated successfully.";

    //set all output to be returned instead of printed
    $profile->returnOutput = true;

    //test for last page and no errors to submit form, otherwise start form
    if( @$_POST['formitable_multipage']!= "end" || isset($profile->errMsg) ){
        $profileOpen = $profile->openForm();
        $smarty->assign('profileOpen', $profileOpen);
    }
    else
    $profile->submitForm(false);

    //first page - test for no submit OR errors set with a field on the first page
    if( !isset($_POST['submit']) || (isset($profile->errMsg) && isset($_POST['firstname'])) ){
        #print first page
        $page1 = "page 1";
        $smarty->assign('page1', $page1);
        $fname = $profile->printField('firstname');
        $smarty->assign ('fname', $fname);
        $lname = $profile->printField('lastname');
        $smarty->assign ('lname', $lname);
        
        $end = $profile->multiPage("end");
        $smarty->assign('end', $end);
        $profileClose = $profile->closeForm();
        $smarty->assign('profileClose2', $profileClose);

    }
    else{
        $smarty->assign('updateMsg', $profile->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);

    }
    $content	= $smarty->fetch( "./user/user.upd_profile.tpl.html" );


?>