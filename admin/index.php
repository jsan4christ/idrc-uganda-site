<?php

    // start compressing and buffering
    ob_start();

    session_start();

    // include needed classes
    require_once( './config/smarty/libs/Smarty.class.php' );
    require_once( './config/SmartyValidate/libs/SmartyValidate.class.php' );
    require_once( './config/SmartyPaginate/SmartyPaginate.class.php' );
    require_once( './config/connect.inc.php' );
    require_once( './classes/Formitable.class.php' );
    require_once( './classes/authentication.class.php' );
    require_once( './classes/security.class.php' );
    
    $smarty = new Smarty();

    // set the smarty-dirs
    $smarty->template_dir 	= "./templates/";
    $smarty->compile_dir 	= "./admin_c/";

    # Getting active Org Info
    $orgSQL = "SELECT logo FROM sionapros_main_orga_info1 WHERE main_org = 'Yes'";
    $result = $db->execute($orgSQL) or die('No Match');

    $smarty->assign('main', $result[0]);
    #check login
    require_once('./display/session_verify.php');
    //assign username to template
    $smarty->assign('sessionUsername', $_SESSION['loginUsername']);
    #get requested path from url
    #$path 	= $_GET[ 'path' ];

    if( is_file( "{$path}" ) && $path != '' ){
        #check for access credentials
        $security = new Security($db);
        if( $security->accessCheck($_SESSION['loginUsername'], $path) ){
            #path tracking for form submitting purposes
            $_SESSION['prevPath'] = $path;

            require_once( "{$path}" );
        }else{
            $content = $smarty->fetch('./security/tm0.security.access_denied.tpl.html');
        }
    }
    elseif( isset($_POST) && isset($_POST['submit']) && is_file($_SESSION['prevPath']) ){
        require_once( $_SESSION['prevPath']);
    }

    #navigation
    #require_once('./display/navigate.php');
    #content
    if( isset($chg_pass_content) )
    $smarty->assign( 'content', $chg_pass_content);
    else
    $smarty->assign( 'content', $content );
    #$smarty->assign( 'sidebox' , $otpt_sidebox );

    $smarty->display( "display/index.tpl.html" );

    // flush output
    ob_end_flush();
    #echo '<hr>';
    #highlight_file(__FILE__);
?>
