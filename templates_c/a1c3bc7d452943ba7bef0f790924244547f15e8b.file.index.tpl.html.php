<?php /* Smarty version Smarty-3.1.14, created on 2015-09-01 12:42:35
         compiled from ".\templates\index.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:622552a08b1f2df1a8-63117009%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1c3bc7d452943ba7bef0f790924244547f15e8b' => 
    array (
      0 => '.\\templates\\index.tpl.html',
      1 => 1441100301,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '622552a08b1f2df1a8-63117009',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52a08b1f462013_59448382',
  'variables' => 
  array (
    'contentbox' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a08b1f462013_59448382')) {function content_52a08b1f462013_59448382($_smarty_tpl) {?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="./gfx/favicon.png">
<link rel="stylesheet" type="text/css" href="css/ResetSJ.css">
<link rel="stylesheet" type="text/css" href="css/idrc.css">
<link href="./css/js-image-slider.css" rel="stylesheet" type="text/css" />
<script src="./js/js-image-slider.js" type="text/javascript"></script>

<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type='text/javascript'>
//<![CDATA[ 

 $(function() {
    // Stick the #nav to the top of the window
    var nav = $('#nav');
    var navHomeY = nav.offset().top;
    var isFixed = false;
    var $w = $(window);
    $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
            nav.css({
                position: 'fixed',
                top: 0,
                left: nav.offset().left,
                width: nav.width()
            });
            isFixed = true;
        }
        else if (!shouldBeFixed && isFixed)
        {
            nav.css({
                position: 'static'
            });
            isFixed = false;
        }
    });
});
//]]>  
</script>
<title>Infectious Diseases Research Collaboration</title>
</head>

<body>
<div id="wrapper" class="wrapper">
<?php echo $_smarty_tpl->getSubTemplate ('./header.tpl.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->tpl_vars['contentbox']->value;?>


<?php echo $_smarty_tpl->getSubTemplate ('./footer.tpl.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</div>
</body>
</html>
<?php }} ?>