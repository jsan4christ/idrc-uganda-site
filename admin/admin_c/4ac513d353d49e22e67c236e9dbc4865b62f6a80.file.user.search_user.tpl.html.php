<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:28:10
         compiled from ".\templates\user\user.search_user.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:730251fa464a6af557-86129459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ac513d353d49e22e67c236e9dbc4865b62f6a80' => 
    array (
      0 => '.\\templates\\user\\user.search_user.tpl.html',
      1 => 1221680236,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '730251fa464a6af557-86129459',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa464a70a187_44047172',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa464a70a187_44047172')) {function content_51fa464a70a187_44047172($_smarty_tpl) {?><div id="content">
<span class="title"> Fill in all or any of the fields below. </span>
<form method="post" action="./index.php?path=./main/user/user.show_user.php">
  <div id="forms">
    <table width="100%">
      <tr>
        <td ><label class="textlabel labels">First Name</label>
          <input type="text" name="fname" size="10" class="text">
        </td>
      </tr>
      <tr>
        <td ><label class="textlabel labels">Last Name</label>
          <input type="text" name="lname" size="10" class="text">
        </td>
      </tr>
      <tr>
        <td><label class="selectlabel labels">Results Per Page</label><br>
          <select name="results" class="select">
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>
          <div class="button">
            <input type="reset" value="Reset Form"><input type="submit" name="Search" value="Search">
          </div>
        </td>
      </tr>
    </table>
  </div>
</form>
</div><?php }} ?>