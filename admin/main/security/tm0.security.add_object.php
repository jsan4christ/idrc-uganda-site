<?PHP

    include_once('./classes/security.class.php');

    if( $_REQUEST['activefolder'] ){
        $msg = 'Folder';
        $objectpath = $_REQUEST['activefolder'];
        #$object = $objectpath;#so that it looks like the path variable
        $smarty->assign('folder', 'set');
    }else if( $_REQUEST['filename'] ){
        $objectpath = $_REQUEST['filename'];
        #$objectpath = basename($objectpath);
    }
    $security = new Security($db);
    $result = $security->profileObjects($objectpath);
    if( count($result) == 0 )
    $assignedTo = 'NONE';

    #create form object
    $sec = new Formitable($db, 'sionapros_object_profile');

    $sec->forceTypes(array('object'), array('hidden'));
    $sec->skipFields(array('activefolder','filename'));
    $sec->normalizedField('profile_id', 'sionapros_profiles', 'profile_id', 'profile', 'profile_id ASC');
    #custom labels
    $sec->labelField('profile_id', 'Profile *');
    //set up regular expressions for field validation
    $sec->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $sec->validateField("profile_id", "required");

    #set default values
    $sec->setDefaultValue('object', $objectpath);

    $nmSQL = "SELECT profile FROM sionapros_profiles WHERE profile_id = {$_POST['profile_id']}";
    $nm = $db->execute($nmSQL);
    $sec->msg_insertSuccess = "The object {$objectpath} is now only accessible to users under the {$nm[0]['profile']} profile.";

    //set all output to be returned instead of printed
    $sec->returnOutput = true;

    $smarty->assign('msg', $msg);
    $smarty->assign('assignedTo', $assignedTo);
    $smarty->assign('result', $result);
    $smarty->assign('objectpath', $objectpath);

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $sec->submitForm(false) == -1) ){

        $secOpen = $sec->openForm();
        $smarty->assign('secOpen', $secOpen);

        $objectId = $sec->printField('object');
        $smarty->assign('objectId', $objectId);
        $profile = $sec->printField('profile_id');
        $smarty->assign('profile', $profile);

        $secClose = $sec->closeForm();
        $smarty->assign('secClose', $secClose);

        //        $secForm = $sec->printForm();
        //        $smarty->assign('sec', $secForm);
    }
    else{
        #submit msg
        $smarty->assign('updateMsg', $sec->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);
    }
    $content	= $smarty->fetch( "./security/tm0.security.add_object.tpl.html" );
?>