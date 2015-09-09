<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:07
         compiled from ".\templates\security\tm0.security.create_profile.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:1296751fa460ba01f72-28655819%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ecdf6d1724df61093c1c4b52196829868a4a664' => 
    array (
      0 => '.\\templates\\security\\tm0.security.create_profile.tpl.html',
      1 => 1222068892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1296751fa460ba01f72-28655819',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updateMsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa460ba35860_52382445',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa460ba35860_52382445')) {function content_51fa460ba35860_52382445($_smarty_tpl) {?><div id="content">
  <?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
  <span class="title"> Fields denoted with * <label style="color:red;">must</label> be filled in please. </span>
  <div id="forms">
    { $sec }
  </div>
  <?php }else{ ?>
  <div class="msgBox">
    <label class="msg">{ $updateMsg }</label>
  </div>
  <?php }?>
</div><?php }} ?>