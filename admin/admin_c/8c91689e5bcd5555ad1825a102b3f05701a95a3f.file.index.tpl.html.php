<?php /* Smarty version Smarty-3.1.14, created on 2013-07-19 16:52:32
         compiled from ".\templates\display\index.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2250251e944a02e3366-28348735%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c91689e5bcd5555ad1825a102b3f05701a95a3f' => 
    array (
      0 => '.\\templates\\display\\index.tpl.html',
      1 => 1374148638,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2250251e944a02e3366-28348735',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e944a036a1c7_49016121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e944a036a1c7_49016121')) {function content_51e944a036a1c7_49016121($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <!-- DW6 -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>SionaPros - Admin Panel</title>
    <link rel="stylesheet" href="./css/admin.css" type="text/css">
    <link rel="stylesheet" href="./css/form.css" type="text/css">
    <link rel="stylesheet" href="./css/table.css" type="text/css">
    <link rel="stylesheet" href="./css/niftyCorners.css" type="text/css">
    <link rel="stylesheet" href="./css/emesPrint.css" media="print">
    <script type="text/javascript" src="./config/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="./css/niftyCube.js"></script>
    
    <script type="text/javascript">
        tinyMCE.init({
            mode : "textareas",
            theme: "advanced",
            plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
            theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons3 : "link,unlink,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_source_editor_height : "100",
            theme_advanced_source_editor_width : "200",
            directionality: "ltr",
            theme_advanced_resizing : false,
            force_p_newlines : false,
            force_br_newlines : false
        });
    </script>
    
    
    <script type="text/javascript">
        
        function popUp(URL) {
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=500,height=500');");
        }
        window.onload=function(){
            Nifty("div#masthead","big");
            Nifty("div#content","big");
            Nifty("div#navBar","big");
        }
        
    </script>
    
   
   
  </head>
  <body>

    <?php echo $_smarty_tpl->getSubTemplate ('display/logon.tpl.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    <?php echo $_smarty_tpl->getSubTemplate ('display/nav.tpl.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("display/footer.tpl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  </body>
</html><?php }} ?>