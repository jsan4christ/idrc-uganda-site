<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:26:20
         compiled from ".\templates\news\tm0.news.mng_news.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2589551fa45dcad9643-41279293%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63e9a1b1b3f65d22a97986cefb2243759e20a800' => 
    array (
      0 => '.\\templates\\news\\tm0.news.mng_news.tpl.html',
      1 => 1222077884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2589551fa45dcad9643-41279293',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa45dcbd15f0_42098774',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa45dcbd15f0_42098774')) {function content_51fa45dcbd15f0_42098774($_smarty_tpl) {?><div id="content"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >
    <b style="float:right ">
      <a style="color:#FFFFFF "href="">  </a>
    </b>
  </div>
  <br />
  <?php }?>
  <div class="story">
    <h3> Manage News </h3>
    <p>
      <a href="./index.php?path=./main/news/tm0.news.reg_news.php"> Register an Article </a><br>
      <a href="./index.php?path=./main/news/tm0.news.search_news.php"> Search for Articles </a><br>
    </p>
    <h3> Manage Newsletter </h3>
    <p>
      <a href="./index.php?path=./main/news/news.show_subscribers.php&s=o"> Show Subscribers in Status 'Open' </a><br>
      <a href="./index.php?path=./main/news/news.show_subscribers.php&s=a"> Show Subscribers in Status 'Added' </a><br>
      <a href="./index.php?path=./main/news/news.show_subscribers.php&s=r"> Show Subscribers in Status 'Removed' </a><br>
    </p>
  </div>
</div> <?php }} ?>