<?php
 	
	//check if user is already logged in
	//check if session_username doesnt already exist and that Log In form has been submitted
	if ( isset($_POST['login'])){

		if( ( !empty( $_POST['username'] )) && ( !empty( $_POST['password'] )) ){
       		#trim values
       		$username = trim($_POST['username']);
       		$password = trim($_POST['password']);
       			
			$user = new Authentication();
			//authenticate user
			if ( $user->authenticateUser($db, $username, $password) ){
				//check account_status
				if (!$user->accountStatus($db, $username)){
					$message = "This Account was deactivated. Contact the System Administrator.";
					$smarty->assign('accountMsg', $message);
					$content = $smarty->fetch('./logon/tm0.logon.logon_err.tpl.html');
					include_once('./config/disconnect.inc.php');					
				}
				else{
					//Register login Username
					$_SESSION['loginUsername'] = $username;			
					//Register remote IP-Address
					$_SESSION['loginIP'] = $_SERVER['REMOTE_ADDR'];	
				}
			}
			else{
				$message = "This username / password combination is incorrect. \nEither check your Login Information and try again or contact the System Administrator.";
				$smarty->assign('authMsg', $message);
				$smarty->assign($_POST);
				$content = $smarty->fetch('./logon/tm0.logon.logon_err.tpl.html');
				include_once('./config/disconnect.inc.php');
			}				
		}
		else{
			$message = "BOTH USERNAME AND PASSWORD MUST BE FILLED IN PLEASE.";
			$smarty->assign('loginMsg', $message);
			$content = $smarty->fetch('./logon/tm0.logon.logon_err.tpl.html');
			include_once('./config/disconnect.inc.php');			
		}
	}
	else{
		#check for session availability
		#if( isset($_SESSION['loginUsername']) ) {
			
 		$user = new Authentication();
 		#check whether user has a session
		if( !$user->sessionAuthenticate() ){ 
			$smarty->assign('sessionMsg', $user->msg);
			$content = $smarty->fetch('./logon/tm0.logon.logon_err.tpl.html');
			unset($path); #this avoids execution of the wanted content script
			include_once('./config/disconnect.inc.php');
		}
		else{
			#check whether user is required to change their passwoard
			#session chg_pass avoids execution of the whole if statement every time script is run
			#its set when user changes password successfully or when they rnt required to change their password 
			$path = $_GET['path'];
			
			if( (!isset($_SESSION['chg_pass']) && substr_count($path, 'chg_pass') != 1) && $user->chgPassStatus($db, $_SESSION['loginUsername']) ){
				$smarty->assign('chg_pass', "You are required to change your Password");
	    		// new form, we (re)set the session data
	    		SmartyValidate::connect($smarty, true);
	    		// register our validators
				SmartyValidate::register_validator('password', 'oldpassword', 'notEmpty');
	    		SmartyValidate::register_validator('password1', 'newpassword:6:-1', 'isLength');
	    		SmartyValidate::register_validator('password2', 'newpassword:confpassword', 'isEqual');
	    		// fetch form
				$chg_pass_content = $smarty->fetch('./user/user.chg_pass.tpl.html');
			}
		}
		
	}
?>

