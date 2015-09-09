<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:53
         compiled from ".\templates\faqs\faqs.mng_faqs.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2319151fa4639bd4f40-94717032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a74547083987f1e6a48c83680c20d5c2925d5f9' => 
    array (
      0 => '.\\templates\\faqs\\faqs.mng_faqs.tpl.html',
      1 => 1221577676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2319151fa4639bd4f40-94717032',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sessionUsername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa4639c08bf7_11443894',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa4639c08bf7_11443894')) {function content_51fa4639c08bf7_11443894($_smarty_tpl) {?><div id="content"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >
    <b style="float:right ">
      <a style="color:#FFFFFF "href="">  </a>
    </b>
  </div>
  <br />
  <?php }?>
  <div class="story">
    <h3> Manage FAQs </h3>
    <p>
      <a href="./index.php?path=./main/faqs/faqs.reg_faq.php"> Register an FAQ </a><br>
      <a href="./index.php?path=./main/faqs/faqs.show_faqs.php"> Show All FAQs </a><br>
    </p>
  </div>
</div> <?php }} ?>