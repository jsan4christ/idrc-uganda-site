<?php 
	/*******************************************************************************
	| Project Name: Contact Form
	|    File Name: contact.php
	|  Description: This page contains a standard contact form with e-mail func-
	|               tionality. Can be reused by any website. To use this form
	|               simply configure it for your e-mail address in the configuration
	|               section below.
	|
	|-------------------------------------------------------------------------------
	|               C O P Y R I G H T
	|-------------------------------------------------------------------------------
	|        Copyright (c) 2005 by Feaser LLC         All rights reserved.
	|
	|-------------------------------------------------------------------------------
	|               A U T H O R   I D E N T I T Y
	|-------------------------------------------------------------------------------
	| Initials   Name                 Contact                       Company
	| --------   ------------------   ---------------------------   ----------------
	| Vg         Frank Voorburg       info@feaser.com               Feaser LLC
	|-------------------------------------------------------------------------------
	|               R E V I S I O N   H I S T O R Y
	|-------------------------------------------------------------------------------
	| Date         Ver   Author  Description
	| ---------    ----  ------  ---------------------------------------------------
	| 18-Jan-05    1.0    Vg     - Creation
	|
	|******************************************************************************/

  /* ========================= Begin Configuration ============================ */
	define("kContactEmail","admin@idrc-uganda.org");
  /* ========================= End Configuration ============================== */

  // init variables
	$error = false;

	// determine is the form was submitted
	$submit = $_POST['submit'];
	if (!isset($submit)) 
		$form_submitted = false;
	else
	  $form_submitted = true;

  if ($form_submitted) {
	  // read out data
	  $name = $_POST['name'];
		$company = $_POST['company'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		}
		
		// prepare message
			$msg  = "Full Name: \t $name \n";
			$msg .= "Company: \t $company \n";
			$msg .= "E-mail Address: \t $email \n";
			$msg .= "Phone Number: \t $phone \n";
			$msg .= "Message: \n---\n $message \n---\n";

$myBadwords = array("to:", "cc:", "bcc:");

$name = str_ireplace( $myBadwords, "", $name);
$email = str_ireplace( $myBadwords, "", $email);



			// prepare message header
			$mailheaders  = "MIME-Version: 1.0\r\n";
			$mailheaders .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$mailheaders .= "From: $name <$email>\r\n";
			$mailheaders .= "Reply-To: $name <$email>\r\n"; 

		  // send out email
			mail(kContactEmail, $subject ,stripslashes($msg), $mailheaders);
		
				// email was successfully send
				if (($form_submitted) && (!$error)) {
			// display submitted data 
			$submittedMsg = nl2br(stripslashes($msg));
			$submitMsg="Thank you for your feedback,". $name ."	This is the information you submitted:<br><br>". nl2br(stripslashes($msg)) ."";
			$smarty->assign('submitMsg', $submitMsg);	}
				// display contact form
				else {
					// display error message
					if ($error) {	
						$submitMsg= "<font class='form_check'>" . $error_msg . "</font>\n";
						$smarty->assign('submitMsg', $submitMsg);
					} 
				}
				 $otpt_contentbox = $smarty->fetch("./display/contacts.tpl.html");
			?>
			

