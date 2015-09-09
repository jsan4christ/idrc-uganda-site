<?PHP

    require_once('./classes/admin.class.php');

    $admin = new Admin($db);

    #create form object
    $opt = new Formitable($db, 'sionapros_pubs');

    $opt->forceTypes(array('doc','id','category'),
        array('file','hidden','select'));
    #custom labels
    $opt->labelFields(array('title','doc','category','pub_date'),
        array('Document Title *', 'Upload File *','Category *','Publication Date *'));
    //set up regular expressions for field validation
    $opt->registerValidation("required",".+","Field MUST be filled in please.");
    $opt->setDateField('pub_date');
    //set up fields for validation using regexs above
    $opt->validateField("title", "required");
    $opt->validateField("doc", "required");
    $opt->validateField("category", "required");
    $opt->validateField("pub_date", "validateDate");
    #set default value
    $opt->setDefaultValue('id', $admin->getId($opt->table));
    #set normalized
    $opt->normalizedField('category', 'sionapros_categories', 'id', 'value', 'id ASC');
    //set all output to be returned instead of printed
    $opt->returnOutput = true;

    if(isset($_FILES)){

        //path to upload to (with trailing slash)
        $path = "./docs/";

        //array of filetypes to check against
        $filetypes = array("png","jpeg","gif","PNG","JPEG","GIF","jpg","JPG","pdf","PDF","ps","PS");

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
                #   $unit->errMsg[$key] = "No Photo was selected.";
                if( $phpErr==3 )
                $opt->errMsg[$key] = "Document Upload was incomplete (possibly the file is too big)";
                else if( $phpErr==1 || $phpErr==2 || $_FILES[$key]['size']>$maxSize)
                $opt->errMsg[$key] = "File is too big ($maxSize byte limit)";
                else if(!is_uploaded_file($_FILES[$key]['tmp_name']))
                $opt->errMsg[$key] = "Error in upload.";

                //everything ok, proceed with upload
                else {
                    //get extension and test if acceptable
                    $ext=split("\.",$_FILES[$key]['name']); $ext=$ext[sizeof($ext)-1];
                    $i = ($filemode=="include" && in_array($ext,$filetypes));;
                    if( ($filemode=="include" && in_array($ext,$filetypes)) ||
                        ($filemode=="exclude" && !in_array($ext,$filetypes)) )
                    $opt->errMsg[$key] = "Unacceptable Filetype.";
                    //finally copy file
                    else if( $phpErr!=6 && $phpErr!=7 ){
                        $newFileName = $path.time().str_replace(' ','_',$_FILES[$key]['name']);
                        while( file_exists($newFileName) ){
                            $newFileName = $path.time().rand(1,99).str_replace(' ','_',$_FILES[$key]['name']);
                        }
                        if( move_uploaded_file($_FILES[$key]['tmp_name'], $newFileName) ){
                            //set file path to be stored in db
                            $_POST[$key] = $newFileName;
                        }
                        else{
                            $news->errMsg[$key] = "Unable to copy file. Please try again later";
                        }
                    }
                    else $news->errMsg[$key] = "Unable to copy file. Please try again later";
                }

            } else $opt->errMsg[$key] = "No file specified.";

        }

    }

    if( !isset($_POST['submit']) || (isset($_POST['submit']) && $opt->submitForm(false) == -1) ){

        $optForm = $opt->printForm();
        $smarty->assign('opt', $optForm);

    }
    else{
        #$smarty->assign('client_no', $client_no);
        #submit msg
        $smarty->assign('updateMsg', $opt->submitMsg);
        #$content	= $smarty->fetch( "./main/allergy/reg_allergy_group.tpl.html" );
        #unset prevPath
        unset($_SESSION['prevPath']);
    }
    $content	= $smarty->fetch( "./pubs/pubs.upload_pub.tpl.html" );
?>