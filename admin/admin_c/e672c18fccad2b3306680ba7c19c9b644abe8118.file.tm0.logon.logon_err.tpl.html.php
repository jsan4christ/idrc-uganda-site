<?php /* Smarty version Smarty-3.1.14, created on 2013-07-19 16:52:32
         compiled from ".\templates\logon\tm0.logon.logon_err.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:979151e944a0106058-39365267%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e672c18fccad2b3306680ba7c19c9b644abe8118' => 
    array (
      0 => '.\\templates\\logon\\tm0.logon.logon_err.tpl.html',
      1 => 1221729916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '979151e944a0106058-39365267',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'loginMsg' => 0,
    'authMsg' => 0,
    'accountMsg' => 0,
    'sessionMsg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e944a023b965_60168797',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e944a023b965_60168797')) {function content_51e944a023b965_60168797($_smarty_tpl) {?><div id="content">
<center>
    <div class="msgBox">
      <?php if (isset($_smarty_tpl->tpl_vars['loginMsg']->value)){?>
      <h3 style="color:red;">LOGIN ERROR</h3>
      <label class="msg"> <?php echo $_smarty_tpl->tpl_vars['loginMsg']->value;?>
 </label>
      <?php }elseif(isset($_smarty_tpl->tpl_vars['authMsg']->value)){?>
      <h3 style="color: red;">AUTHENTICATION ERROR</h3>
      <label class="msg"> <?php echo $_smarty_tpl->tpl_vars['authMsg']->value;?>
 </label>
      <?php }elseif(isset($_smarty_tpl->tpl_vars['accountMsg']->value)){?>
      <h3 style="color: red;">ACCOUNT STATUS</h3>
      <label class="msg"> <?php echo $_smarty_tpl->tpl_vars['accountMsg']->value;?>
 </label>
      <?php }elseif(isset($_smarty_tpl->tpl_vars['sessionMsg']->value)){?>
      <h3 style="color: red;">SESSION ERROR</h3>
      <label class="msg"> <?php echo $_smarty_tpl->tpl_vars['sessionMsg']->value;?>
 </label>
      <?php }?>
    </div>
  </center>
</div>
<?php }} ?>