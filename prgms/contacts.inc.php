<?php
    
    #fetch addr cats
    #$catsSQL = "SELECT * FROM sionapros_addr_cats";
    #$cats = $db->execute($catsSQL);
    
    #$smarty->assign('cats', $cats);
    
    #if( isset($_GET['id'])) {$id = $_GET['id'];}
    #else
    #$id = 1; #default shows head office addresses

    #$smarty->assign('id', $id);
    #$addSQL = "SELECT ad.*,cats.value FROM sionapros_address AS ad INNER JOIN sionapros_addr_cats AS cats";
    #$addSQL .= " ON ad.category = cats.id WHERE ad.category = '$id'";
    #$adds = $db->execute($addSQL);
    
    #$smarty->assign('adds', $adds);
	
	//Setup mailer and send mail when form is submited.
	/* ========================= Begin Configuration ============================ */
	define("kContactEmail","admin@muucsf.org");
  /* ========================= End Configuration ============================== */

  // init variables
	$error = false;

	// determine is the form was submitted
	$submit = $_POST['submit'];
	echo $submit;
	if (empty($submit)) 
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