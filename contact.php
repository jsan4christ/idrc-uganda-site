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
	define("kContactEmail","pmwodila@ebenezergospel.net");
  /* ========================= End Configuration ============================== */

  // init variables
	$error_msg = 'The following fields were left empty or contain invalid information:<ul>';
	$error = false;

	// determine is the form was submitted
	$submit = $_POST['submit'];
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
		
		// verify required data
		if(!$name) { $error_msg .= "<li>Full Name</li>"; $error = true; }
		if(!$email) { $error_msg .= "<li>E-mail Address</li>"; $error = true; }
		if(!$message) { $error_msg .= "<li>Message</li>"; $error = true; }
		if($email) { if(!eregi("^[a-z0-9_]+@[a-z0-9\-]+\.[a-z0-9\-\.]+$", $email)){ $error_msg .= "<li>E-mail Address</li>"; $error = true; }}
		$error_msg .= "</ul>";
		
		// email message if no errors occurred
		if (!$error) {
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
		}
	} 
?>

<style type="text/css">

	td.form         { color: #606060; font-family: "Arial";  }
	td.main         { color: #606060; font-family: "Arial";  }
	font.form_check {	color: red; }
	input           { font-family: "Arial"; color:#606060; }
	textarea        { font-family: "Arial"; color:#606060; }
	div#form_box    { margin: 2px; width: 295px; border: 1px; border-style: solid; border-color: #606060; background: #f8f8f8; padding: 5px; }
	h1              { font-size:14; color: #606060; }
</style>

<!-- box around the page -->
			<?php
				// email was successfully send
				if (($form_submitted) && (!$error)) {
			?>
			<!-- display submitted data -->
			Thank you for your feedback, <?php echo $name; ?>.
			This is the information you submitted:<br><br><?php echo nl2br(stripslashes($msg)); ?>
			<?php	
				}
				// display contact form
				else {
					// display error message
					if ($error) {	
						echo "<font class='form_check'>" . $error_msg . "</font>\n";
					} 
			?>
			<!-- display form information -->
			
			<p style=" display:block;  height: 60px; margin: 5px; ">Please fill out and submit the form on this page to contact us. We will get back to you 
			as soon as we can. Note: We do not sell, trade, or exchange addresses!</p>
			
			<!-- display form -->
			<form action="<?php echo $PHP_SELF; ?>" method="post" name="contact" style="margin: 0 auto;">
				<fieldset>
                	<legend>Contact form </legend>
						<label for="name">Full Name </label><br class="br" />
						<input name="name" type="text" required class="textfield" placeholder="Name" value="<?php echo $name ?>" size="40" >
						<br />
						<label for="email">E-mail </label><br class="br" />
						<input name="email" type="email" value="<?php echo $email ?>" size="40" class="textfield">
						<br />
<label for="phone">Phone </label><br class="br" /><input name="phone" type="tel" value="<?php echo $phone ?>" size="40" class="textfield">
						<br />
						<label for="subject">Subject </label><br class="br" />
						<input name="subject" type="text" required class="textfield" placeholder="Subject" value="<?php echo $subject ?>" size="40">	
						<br />
						<label for="message">Message </label><br class="br" />
						<textarea name="message" cols="30" rows="15" required placeholder="Please type your message here!"><?php echo $message ?></textarea>
                        <br />
						<label for="submit">&nbsp;</label><br class="br" />
						<input name="submit" type="submit" value="Submit" class="submit">
					</fieldset>
			</form>
			<?php
				}
			?>
	
