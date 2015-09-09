<?php /* Smarty version Smarty-3.1.14, created on 2013-12-06 10:56:47
         compiled from ".\templates\cats\main.reg_category.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2680152a1833f81e368-32373659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d9a3a7cd800a8dc44facfa723d2255b55a0035f' => 
    array (
      0 => '.\\templates\\cats\\main.reg_category.tpl.html',
      1 => 1222073626,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2680152a1833f81e368-32373659',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
    'updateMsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52a1833fac9fc9_87164731',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a1833fac9fc9_87164731')) {function content_52a1833fac9fc9_87164731($_smarty_tpl) {?><div id="content"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >
    <b style="float:left ">  </b>
    <b style="float:right ">
      <a style="color:#FFFFFF "href=""> </a>
    </b>
  </div>
  <br />
  <?php }?>
  <?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
  <span style="font-style:italic;"> Fields denoted with * <label style="color:red;">must</label> be filled in please. </span>
  <div id="forms">
    { $cats }
  </div>
  <?php }else{ ?>
  <div class="msgBox">
    <label class="msg">{ $updateMsg }</label>
    <p>
      <a href="./index.php?path=./main/cats/main.reg_category.php">Register another Category</a><br>
      <a href="./index.php?path=./main/cats/main.show_categories.php">Show Categories</a>
    </p>
  </div>
  <?php }?>
</div> <?php }} ?>