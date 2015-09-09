<?PHP

    require_once('./classes/cats.class.php');

    $ts = new Cats($db);
    #create form object
    $cats = new Formitable($db, 'sionapros_categories');

    $cats->forceTypes(array('id','value'), array('hidden','varchar'));
    #custom labels
    $cats->labelFields(array('value'),
        array('Category *'));
    //set up regular expressions for field validation
    $cats->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $cats->validateField("value", "required");
    $cats->uniqueField("value", "This Category Name Already Exists");
    #set default values
    $cats->setDefaultValue('id', $ts->getCatNo());
    //set all output to be returned instead of printed
    $cats->returnOutput = true;

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $cats->submitForm(false) == -1) ){

        $catsForm = $cats->printForm();
        $smarty->assign('cats', $catsForm);

    }
    else{
        #$smarty->assign('client_no', $client_no);
        #submit msg
        $smarty->assign('updateMsg', $cats->submitMsg);
        #$content	= $smarty->fetch( "./main/allergy/reg_allergy_group.tpl.html" );
        #unset prevPath
        unset($_SESSION['prevPath']);
    }
    $content	= $smarty->fetch( "./cats/main.reg_category.tpl.html" );
?>