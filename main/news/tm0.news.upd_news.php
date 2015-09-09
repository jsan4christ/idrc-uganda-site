<?PHP
    #get the ward_no
    $news_no = $_REQUEST['news_no'];

    #create form object
    $news = new Formitable($db, 'sionapros_news');
    #set primary key field
    $news->setPrimaryKey('news_no');
    $news->setEncryptionKey("eoeeuye_eeeoi");
    $news->getRecord($news_no);
    $news->forceType('news_no','hidden');
    $news->forceType('photo', 'hidden');
    $news->forceType('category', 'select');
    $news->hideFields(array('photo_desc','reg_date','username'));
    $news->setDateField('pub_date');
    #$news->forceTypes(array('status'), array('select'));
    #custom labels
    $news->labelFields(array('title','summary','detail','category','pub_date'),
        array('Title *','News Summary*','Details *','Category *','Publication Date *'));
    //set up regular expressions for field validation
    $news->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $news->validateField("title", "required");
    $news->validateField("summary", "required");
    $news->validateField("category", "required");
    $news->validateField("pub_date", "validateDate");

    $news->normalizedField("category","sionapros_categories","id","value","id ASC");
    //set all output to be returned instead of printed
    $news->returnOutput = true;

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $news->submitForm(false) == -1) ){

        $newsForm = $news->printForm();
        $smarty->assign('news', $newsForm);
    }
    else{
        #unset prevPath
        unset($_SESSION['prevPath']);
        header("Location: ./index.php?path=./main/news/tm0.news.preview_news.php&news_no=$news->pkeyID");
        exit();

    }
    $content	= $smarty->fetch( "./news/tm0.news.upd_news.tpl.html" );


?>