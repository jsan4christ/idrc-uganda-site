<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:27:41
         compiled from ".\templates\pubs\pubs.upload_pub.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:3012851fa462d9c6337-98072346%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf89e6bb82545632ac91308249bd43ab73e0f3d1' => 
    array (
      0 => '.\\templates\\pubs\\pubs.upload_pub.tpl.html',
      1 => 1222065442,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3012851fa462d9c6337-98072346',
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
  'unifunc' => 'content_51fa462da2be33_12100901',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa462da2be33_12100901')) {function content_51fa462da2be33_12100901($_smarty_tpl) {?><div id="content"> 
  <?php if (isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="secLinks" >

  </div>
  <br />
  <?php }?>
  <?php if (!isset($_smarty_tpl->tpl_vars['updateMsg']->value)){?>
  <span style="font-style:italic;"> Fields denoted with * <label style="color:red;">must</label> be filled in please. </span>
  <div id="forms">
    { $opt }
  </div>
  <?php }else{ ?>
  <div class="msgBox">
    <label class="msg">{ $updateMsg }</label>
    <p>
      <a href="./index.php?path=./main/pubs/pubs.upload_pub.php">Upload another Publication</a><br>
      <a href="./index.php?path=./main/pubs/pubs.show_pubs.php">Show Publications</a>
    </p>
  </div>
  <?php }?>
</div> <?php }} ?>