<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:26:30
         compiled from ".\templates\cats\main.mng_category.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:1190151fa45e66c0ab0-65967045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a54a5fc3cd63ca444c8edb543e92867f82910a3' => 
    array (
      0 => '.\\templates\\cats\\main.mng_category.tpl.html',
      1 => 1221573558,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1190151fa45e66c0ab0-65967045',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa45e6713606_33567428',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa45e6713606_33567428')) {function content_51fa45e6713606_33567428($_smarty_tpl) {?><div id="content"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >
    <b style="float:right ">
      <a style="color:#FFFFFF "href="">  </a>
    </b>
  </div>
  <br />
  <?php }?>
  <div class="story">
    <h3> Manage Categories </h3>
    <p>
      <a href="./index.php?path=./main/cats/main.reg_category.php"> Register Category </a><br>
      <a href="./index.php?path=./main/cats/main.show_categories.php"> Show All Categories </a><br>
      <a href="./index.php?path=./main/cats/main.chg_category.php"> Change Category Name </a><br>
      <a href="./index.php?path=./main/cats/main.del_category.php"> Delete Category </a><br>
    </p>
  </div>
</div> <?php }} ?>