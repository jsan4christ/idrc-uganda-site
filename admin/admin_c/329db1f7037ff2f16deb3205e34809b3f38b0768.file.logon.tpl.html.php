<?php /* Smarty version Smarty-3.1.14, created on 2013-07-19 16:52:32
         compiled from ".\templates\display\logon.tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:142551e944a0392c15-50392579%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '329db1f7037ff2f16deb3205e34809b3f38b0768' => 
    array (
      0 => '.\\templates\\display\\logon.tpl.html',
      1 => 1221679040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '142551e944a0392c15-50392579',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'main' => 0,
    'sessionUsername' => 0,
    'SCRIPT_NAME' => 0,
    'username' => 0,
    'password' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_51e944a06d3ac6_87559706',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e944a06d3ac6_87559706')) {function content_51e944a06d3ac6_87559706($_smarty_tpl) {?>
<div id="masthead"> 
  <div class="image" style="width: 20%;">
    <center>
     <a href="http://www.sionapros.com" > <img alt="LOGO" src="<?php echo $_smarty_tpl->tpl_vars['main']->value['logo'];?>
" align="middle" border="0px"></a>
    </center>
  </div>
  <div style="margin-left:60%;">
    <div><center><label class="sys">SionaPros</label></center></div>
    <div><center><label class="sys"><br> </label></center></div>
    <div><center><label class="sys">Admin Panel</label></center></div>
    <div><center><label class="sys"><br></label></center></div>
  </div>

  

  <?php if (!isset($_smarty_tpl->tpl_vars['sessionUsername']->value)){?>
  <div id="logIn" >
    <form action="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
" method="post">

      <table style="padding: 0px;margin: 0px;">
        <tr>
          <td><label class="label"> USERNAME * </label></td>
          <td>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['username']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="textLogin" size="15">
          </td>
          <td><label class="label"> PASSWORD * </label><td>
          <td>
            <input type="password" name="password" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['password']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="textLogin" size="15">
          </td>
          <td>
            <div class="button">
              <input type="submit" name="login" value="LOGIN">
            </div>
          </td>
        </tr>
      </table>

    </form>
  </div>
  <?php }else{ ?>
  <div id="loggedIn">
    <label> Welcome, you are Logged in as: </label><b id="username"><?php echo $_smarty_tpl->tpl_vars['sessionUsername']->value;?>
</b>

    |<a href="./index.php?path=./main/user/user.mng_profile.php"> My Profile </a>|<a href="./index.php?path=./display/logout.php"> Sign Out </a>

  </div>
  <?php }?>

  <div id="globalNav" align="right">
    <b>
      |<a href="./index.php"> HOME </a>|<a href="javascript:window.history.back()"> RETURN </a>|<a href=""> PRINT </a>|<a href="javascript:popUp('./modules/main/help/tm0.help.help_file.php')"> HELP </a>
    </b>
  </div>
  <div style="clear: both;"></div>

</div> 
<!-- end masthead --> 

<?php }} ?>