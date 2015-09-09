<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:49
         compiled from ".\templates\news\tm0.news.reg_news.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:17451fa4635e5cbe9-20931320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4415228179ddce1d269459d7c6fc25933738dc3' => 
    array (
      0 => '.\\templates\\news\\tm0.news.reg_news.tpl.html',
      1 => 1221933186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17451fa4635e5cbe9-20931320',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updateMsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa4635e92b17_45718245',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa4635e92b17_45718245')) {function content_51fa4635e92b17_45718245($_smarty_tpl) {?><div id="content">
<?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
<span class="title"> Fields denoted with * <label style="color:red;">must</label> be filled in please. </span>
<div id="forms">
  { $news }
</div>
<?php }else{ ?>
<div class="msgBox">
  <label class="msg">{ $updateMsg }</label>
</div>
<?php }?>
</div><?php }} ?>