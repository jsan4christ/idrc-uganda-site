<?php /* Smarty version Smarty-3.1.14, created on 2013-07-19 16:52:32
         compiled from ".\templates\display\nav.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2620451e944a06e5212-85160564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04d5d4ce77c2fcf1e5af428bad2b10a60339ea90' => 
    array (
      0 => '.\\templates\\display\\nav.tpl.html',
      1 => 1235038562,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2620451e944a06e5212-85160564',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e944a071e171_95396195',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e944a071e171_95396195')) {function content_51e944a071e171_95396195($_smarty_tpl) {?>
<div id="navBar"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <ul id="modNav">
  
  <li><a href="./index.php?path=./main/cats/main.mng_categories.php"> CATEGORIES </a></li>
  
  <li><a href="./index.php?path=./main/faqs/faqs.mng_faqs.php"> FAQs </a></li>
  <li><a href="./index.php?path=./main/news/tm0.news.mng_news.php"> NEWS </a></li>
  
  <li><a href="./index.php?path=./main/pubs/pubs.mng_pubs.php"> PUBLICATIONS </a></li>
  
  
   <li><a href="./index.php?path=./main/user/user.admin_panel.php"> ADMIN PANEL </a></li>
  <li><a href="./index.php?path=./display/logout.php"> Sign Out </a></li>
  </ul>
  <?php }?>
</div><?php }} ?>