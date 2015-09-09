<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:56
         compiled from ".\templates\faqs\faqs.reg_faq.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2528551fa463c8cc892-65212666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cefbdb63db00bf1e5ae37b6c05315bbb752ce216' => 
    array (
      0 => '.\\templates\\faqs\\faqs.reg_faq.tpl.html',
      1 => 1221929424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2528551fa463c8cc892-65212666',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updateMsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa463c900c30_52581794',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa463c900c30_52581794')) {function content_51fa463c900c30_52581794($_smarty_tpl) {?><div id="content">
<?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
<span class="title"> Fields denoted with * <label style="color:red;">must</label> be filled in please. </span>
<div id="forms">
  { $faq }
</div>
<?php }else{ ?>
<div class="msgBox">
  <label class="msg">{ $updateMsg }</label>
  <p>
    <a href="./index.php?path=./main/faqs/faqs.reg_faq.php">Register another FAQ</a><br>
    <a href="./index.php?path=./main/faqs/faqs.show_faqs.php">Show FAQs</a>
  </p>
</div>
<?php }?>
</div><?php }} ?>