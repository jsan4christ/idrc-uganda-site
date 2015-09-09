<?php /* Smarty version Smarty-3.1.14, created on 2013-08-01 14:26:50
         compiled from ".\templates\user\user.admin_panel.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:1081551fa45facf5123-56650529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '746a4215d1e79a48bc046f5e53aeee420e8f14da' => 
    array (
      0 => '.\\templates\\user\\user.admin_panel.tpl.html',
      1 => 1221679750,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1081551fa45facf5123-56650529',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51fa45fadc7599_48121613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fa45fadc7599_48121613')) {function content_51fa45fadc7599_48121613($_smarty_tpl) {?><div id="content">
  <div class="story">
    <h3> Manage Security </h3><br>
    <label> Manage Profiles </label>
    <p>
      <a href="./index.php?path=./main/security/tm0.security.show_profile.php"> Show All </a>
      |<a href="./index.php?path=./main/security/tm0.security.create_profile.php"> Create </a>
      |<a href="./index.php?path=./main/security/tm0.security.chg_profile.php"> Change Profile </a>
      |<a href="./index.php?path=./main/security/tm0.security.del_profile.php"> Delete </a>
      |<a href="./index.php?path=./main/security/tm0.security.objects_profile.php"> Show Objects </a>
    </p>
    <label> Manage User Profiles </label>
    <p>
      <a href="./index.php?path=./main/security/tm0.security.user_profile.php"> Show All </a>
      |<a href="./index.php?path=./main/security/tm0.security.add_user.php"> Add User to a Profile </a>
      |<a href="./index.php?path=./main/security/tm0.security.remove_user.php"> Remove User from a Profile </a>
    </p>
    <label> Manage Objects </label>
    <p>
      <a href="./index.php?path=./main/security/tm0.security.assign_object.php"> Assign Object to a Profile </a>
      |<a href="./index.php?path=./main/security/tm0.security.remove_object.php"> Remove Object from Profile </a>
    </p>

    <h3> Manage User Accounts </h3>
    <p>
      <a href="./index.php?path=./main/user/user.reg_user.php"> Register </a>
      |<a href="./index.php?path=./main/user/user.reset_password.php"> Reset Password </a>
      |<a href="./index.php?path=./main/user/user.activate_account.php"> Activate </a>
      |<a href="./index.php?path=./main/user/user.deactivate_account.php"> Deactivate </a>
      |<a href="./index.php?path=./main/user/user.search_user.php"> Search For User </a>
    </p>

  </div>
</div><?php }} ?>