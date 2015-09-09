<?php
    // start compressing and buffering
    ob_start( "ob_gzhandler" );
    session_start();
    // include needed classes
	
	//@define('SMARTY_DIR', '/admin/config/smarty/libs/');
	@define('SMARTY_DIR', dirname(__FILE__) . '/admin/config/smarty/libs/');
	echo $SMARTY_DIR;
	@define('SMARTY_VAL_DIR', '/admin/config/SmartyValidate/libs/');
        // if(!class_exists('Smarty')) {
           ///   include SMARTY_DIR . 'Smarty.class.php';
          ///  } 
    require_once SMARTY_DIR . 'Smarty.class.php';
	require_once SMARTY_VAL_DIR . 'SmartyValidate.class.php';
    //include_once( './admin/config/SmartyValidate/libs/SmartyValidate.class.php' );
    //include_once( './admin/config/SmartyPaginate/SmartyPaginate.class.php' );
    include_once( './admin/config/connect.inc.php' );
	//include_once( './prgms/breadcrumbs.inc.php' );

    $smarty = new Smarty();

    // set the smarty-dirs
    $smarty->template_dir = "./templates/";
    $smarty->compile_dir = "./templates_c/";
	

    $prgm = $_GET[ 'prgm' ];
   // $prgm 	= ( $_GET[ 'prgm' ] ) ? $_GET[ 'prgm' ] : "idrc-home";

    if( is_file( "./prgms/{$prgm}.inc.php" ) ){
        $_SESSION['prevPath'] = $prgm;
        require_once( "./prgms/{$prgm}.inc.php" );
    }
    elseif (isset($_POST) && isset($_POST['submit']) && is_file("./prgms/{$_SESSION['prevPath']}.inc.php")){
        require_once( "./prgms/{$_SESSION['prevPath']}.inc.php");

    }else {
        require_once("./prgms/idrc-home.inc.php");
    }
	//Get current year
	$Yr = date('Y');
	
	$smarty->assign('thisYear', $Yr);
	
    $smarty->assign( 'contentbox' , $otpt_contentbox );
    //$smarty->assign( 'sidebox' , $otpt_sidebox );

    $smarty->display( "index.tpl.html" );

    // flush output
    ob_end_flush();

?>