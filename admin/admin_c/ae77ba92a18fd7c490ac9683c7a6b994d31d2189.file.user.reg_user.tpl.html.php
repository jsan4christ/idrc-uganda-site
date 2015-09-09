<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:24
         compiled from ".\templates\user\user.reg_user.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:1057451fa461cdd75d7-53780629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae77ba92a18fd7c490ac9683c7a6b994d31d2189' => 
    array (
      0 => '.\\templates\\user\\user.reg_user.tpl.html',
      1 => 1221685526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1057451fa461cdd75d7-53780629',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updateMsg' => 0,
    'page1' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa461ce1a9d7_88607829',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa461ce1a9d7_88607829')) {function content_51fa461ce1a9d7_88607829($_smarty_tpl) {?><div id="content">
  <?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
  <span class="title"> Fields denoted with * <label class="labels" style="color:red;">must</label> be filled in please. </span>
  <div id="forms">
    { $staffOpen }
    <?php if (isset($_smarty_tpl->tpl_vars['page1']->value)){?>
    
    { $fname }
    { $lname }
    { $id }
    { $reg_date }
    { $username }
    { $password }
    { $pass_verify }
    { $chg_pass }
    { $acc_status }
    { $end }
    { $staffClose3 }
    <?php }?>
  </div>
  <?php }else{ ?>
  <div class="msgBox">
    <label class="msg">{ $updateMsg }</label>
  </div>
  <?php }?>
</div><?php }} ?>