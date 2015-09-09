<?PHP

    if($_GET['news_no'])
    $_SESSION['news_no'] = $_GET['news_no'];

    #check to see that the selected news article has no photo already uploaded
    $SQL = "SELECT photo FROM sionapros_news WHERE news_no = '{$_SESSION['news_no']}'";
    $photo = $db->execute($SQL);

    if( count($photo) == 0 ){
        ;
    }else{
        $smarty->assign('secMsg', 'Not Allowed');
    }
    #create form object
    $news = new Formitable($db, 'sionapros_news');

    $news->setPrimaryKey('news_no');
    #set encryption key
    $news->setEncryptionKey("eoeeuye_eeeoi");
    $news->getRecord($_SESSION['news_no']);

    $news->forceTypes(array('news_no','photo','title','summary','details','username','reg_date','category','pub_date'),
        array('hidden','file','hidden','hidden','hidden','hidden','hidden','hidden','hidden'));
    #custom labels
    $news->labelFields(array('photo','photo_desc'),
        array('Upload A Photo *','Short Photo Description *'));
    //set up regular expressions for field validation
    $news->registerValidation("required",".+","Field MUST be filled in please.");
    //set up fields for validation using regexs above
    $news->validateField("photo", "required");
    $news->validateField("photo_desc", "required");
    #set default values
    $news->setDefaultValue('news_no', $_SESSION['news_no']);
    #submit msg
    $news->msg_updateSuccess = "A photo for a news article was uploaded.";
    //set all output to be returned instead of printed
    $news->returnOutput = true;

    if(isset($_FILES)){

        //path to upload to (with trailing slash)
        $path = "./photos";

        //array of filetypes to check against
        $filetypes = array("png","jpeg","gif","PNG","JPEG","GIF","jpg","JPG");

        //should file be include(ed) or exclude(ed) to be acceptable?
        $filemode = "exclude";

        foreach( $_FILES as $key=>$value ){

            //get built-in error code (since PHP 4.2.0)
            if( isset($_FILES[$key]['error']) ){ $phpErr = $_FILES[$key]['error']; }
            else{ $phpErr = 0; }

            if( $_FILES[$key]['name'] && $phpErr!=4 ){

                // get the max file size from post (upload_max_filesize in php.ini)
                // http://us3.php.net/manual/en/ini.core.php#ini.upload-max-filesize
                // to set the upload size smaller than the value in php.ini
                // create an .htaccess file in the script directory with the following directive
                // php_value upload_max_filesize 1M
                $maxSize = $_POST['MAX_FILE_SIZE'];

                //test for possible errors: empty/partial file, file too big, file is not really an upload
                #if( $_FILES[$key]['size']==0 )
                #   $news->errMsg[$key] = "No Photo was selected.";
                if( $phpErr==3 )
                $news->errMsg[$key] = "Photo Upload was incomplete (possibly the file is too big)";
                else if( $phpErr==1 || $phpErr==2 || $_FILES[$key]['size']>$maxSize)
                $news->errMsg[$key] = "File is too big ($maxSize byte limit)";
                else if(!is_uploaded_file($_FILES[$key]['tmp_name']))
                $news->errMsg[$key] = "Error in upload.";

                //everything ok, proceed with upload
                else {
                    //get extension and test if acceptable
                    $ext=split("\.",$_FILES[$key]['name']); $ext=$ext[sizeof($ext)-1];
                    $i = ($filemode=="include" && in_array($ext,$filetypes));
                    if( ($filemode=="include" && in_array($ext,$filetypes)) ||
                        ($filemode=="exclude" && !in_array($ext,$filetypes)) )
                    $news->errMsg[$key] = "Unacceptable Filetype.";
                    //finally copy file
                    else if( $phpErr!=6 && $phpErr!=7 ){
                        $newFileName = $path.'/'.time().$_FILES[$key]['name'];
                        while( file_exists($newFileName) ){
                            $newFileName = $path.'/'.time().rand(1,99).$_FILES[$key]['name'];
                        }
                        if( move_uploaded_file($_FILES[$key]['tmp_name'], $newFileName) ){
                            //resize photo
                            require_once('./classes/imageprocessor.class.php');

                            $imageR = new ImageProcessor($newFileName, 300, $path);
                            $imageR->resizeImage();
                            //set file path to be stored in db
                            $_POST[$key] = $path . '/' . $imageR->newFileName;
                            //delete the original image
                            unlink($newFileName);
                        }
                        else{
                            $news->errMsg[$key] = "Unable to copy file. Please try again later";
                        }
                    }
                    else $news->errMsg[$key] = "Unable to copy file. Please try again later";
                }

            }
            else {
                $news->errMsg[$key] = "No file specified.";
            }

        }

    }
    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $news->submitForm(false) == -1) ){

        $newsForm = $news->printForm();
        $smarty->assign('news', $newsForm);

    }
    else{
        $smarty->assign('updateMsg', $news->submitMsg);
        #unset prevPath
        unset($_SESSION['prevPath']);
        unset($_SESSION['news_no']);
    }
    $content = $smarty->fetch( "./news/tm0.news.upload_photo.tpl.html" );
?>