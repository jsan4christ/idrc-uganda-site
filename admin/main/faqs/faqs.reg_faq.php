<?PHP

    require_once('./classes/admin.class.php');

    $re = new Admin($db);
    #create form object
    $faq = new Formitable($db, 'sionapros_faqs');

    $faq->forceTypes(array('id','done_by','reg_date','category'),
        array('hidden','hidden','hidden','select'));
    #custom labels
    $faq->labelFields(array('faq_qn','faq_ans','category'),
        array('Question *','Answer *','Category *'));
    //set up regular expressions for field validation
    $faq->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $faq->validateField("faq_qn", "required");
    $faq->validateField("faq_ans", "required");
    $faq->validateField("category", "required");
    #set default values
    $faq->setDefaultValue('id', $re->getId($faq->table));
    $faq->setDefaultValue('reg_date', date("Y-m-d"));
    $faq->setDefaultValue('done_by', $_SESSION['loginUsername']);

    #normalized field
    $faq->normalizedField("category", "sionapros_categories", "id", "value", "id ASC");

    #submit msg
    $faq->msg_insertSuccess = "A new FAQ was recorded.";

    //set all output to be returned instead of printed
    $faq->returnOutput = true;

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $faq->submitForm(false) == -1) ){

        $faqForm = $faq->printForm();
        $smarty->assign('faq', $faqForm);

    }
    else{
        $smarty->assign('updateMsg', $faq->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);
    }
    $content = $smarty->fetch( "./faqs/faqs.reg_faq.tpl.html" );
?>