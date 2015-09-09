<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:38
         compiled from ".\templates\pubs\pubs.mng_pubs.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:1233151fa462aa889f8-24696246%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd44c0acbd9c55c58177a70f8b1cb1fe4617c2efe' => 
    array (
      0 => '.\\templates\\pubs\\pubs.mng_pubs.tpl.html',
      1 => 1221625948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1233151fa462aa889f8-24696246',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa462aabe401_85830522',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa462aabe401_85830522')) {function content_51fa462aabe401_85830522($_smarty_tpl) {?><div id="content">
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >
    <b style="float:right ">
      <a style="color:#FFFFFF "href="">  </a>
    </b>
  </div>
  <br />
  <?php }?>
  <div class="story">
    <h3> Manage Publications </h3>
    <p>
      <a href="./index.php?path=./main/pubs/pubs.upload_pub.php"> Upload a Publication </a><br>
      <a href="./index.php?path=./main/pubs/pubs.search_pubs.php"> Search for Publications </a><br>
    </p>
  </div>
</div><?php }} ?>