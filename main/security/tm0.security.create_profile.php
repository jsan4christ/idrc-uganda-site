<?PHP

    require_once('./classes/security.class.php');

    $security = new Security($db);
    #create form object
    $sec = new Formitable($db, 'sionapros_profiles');

    $sec->forceTypes(array('profile_id'), array('hidden'));
    #custom labels
    $sec->labelField('profile', 'Profile Name *');
    $sec->labelField('remarks', 'Remarks i.e Describe the Profile');
    //set up regular expressions for field validation
    $sec->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $sec->validateField("profile", "required");
    $sec->validateField("remarks", "required");
    $sec->uniqueField("profile", "This Profile Name Already Exists");

    #set default values
    $sec->setDefaultValue('profile_id', $security->getProfileId());
    #submit msg
    $sec->msg_insertSuccess = "A new profile called {$_POST['profile']} was created.";

    //set all output to be returned instead of printed
    $sec->returnOutput = true;

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $sec->submitForm(false) == -1) ){

        $secForm = $sec->printForm();
        $smarty->assign('sec', $secForm);

    }
    else{
        $smarty->assign('updateMsg', $sec->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);

    }
    $content	= $smarty->fetch( "./security/tm0.security.create_profile.tpl.html" );
?>