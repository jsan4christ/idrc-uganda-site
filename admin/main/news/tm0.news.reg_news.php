<?PHP

    $news = new Formitable($db, 'sionapros_news');

    $news->forceTypes(array('news_no','reg_date','username','photo','photo_desc','category'),
        array('hidden','hidden','hidden','hidden','hidden','select'));
    #custom labels
    $news->labelFields(array('title','summary','detail','photo','pub_date'),
        array('Title *','News Summary*','Details *','Upload Photo','Publication Date *'));
    $news->setDateField('pub_date');
    //set up regular expressions for field validation
    $news->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $news->validateField("title", "required");
    $news->validateField("summary", "required");
    $news->validateField("details", "required");
    $news->validateField("category", "required");
    $news->validateField("pub_date", "validateDate");
    #set default values
    #get news_No
    $newsSQL = "SELECT MAX(news_no) FROM sionapros_news";
    $result = $db->execute($newsSQL);
    $id = $result[0];
    $news_no = $id['MAX(news_no)'] + 1;

    $news->setDefaultValue('news_no', $news_no);
    $news->setDefaultValue('reg_date', date("Y-m-d H:i:s" ));
    $news->setDefaultValue('username', $_SESSION['loginUsername']);

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

        header("Location: ./index.php?path=./main/news/tm0.news.preview_news.php&news_no={$_POST['news_no']}");
        exit();

    }
    $content	= $smarty->fetch( "./news/tm0.news.reg_news.tpl.html" );
?>