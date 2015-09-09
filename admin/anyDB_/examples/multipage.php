<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
<style type="text/css"> @import url("Formitable_style_users.css"); </style>
<style type="text/css"> @import url("site.css"); </style>

<style type="text/css"> @import url("print.css"); </style>
       <title>Title here!</title>
</head>
<body>
<? 
/*** change the following variables ***/
$user = "user";
$pass = "pass";
$DB = "db";

require("Formitable.class.php");
require_once 'C:\apachefriends\xampp\htdocs\anyDB2\examples\connect.inc.php';

if(strstr($_SERVER['SERVER_NAME'],"local")) $server="localhost";
else $server="localhost";
$newForm = new Formitable( $db,"formitable_users" );

//set the field name of primary key
$newForm->setPrimaryKey("UserID");

//force a few field types
$newForm->forceTypes( array("UserType","WkDays","Occupation","Address","Address2","City","Password"),
                      array("select","checkbox","text","text","text","text","password") );

//retrieve normalized data from another table
$newForm->normalizedField("UserType","field_data","ID","name","ID ASC","type='user'");
$newForm->normalizedField("NewsLetter","field_data","ID","name","ID DESC","type='yn'");
$newForm->normalizedField("Donation","field_data","ID","name","ID ASC","type='donate'");
$newForm->normalizedField("recurring_Method","field_data","ID","name","ID ASC","type='recurring'");
$newForm->normalizedField("Donation_Type","field_data","ID","name","ID ASC","type='dtype'");
$newForm->normalizedField("NamePosted","field_data","ID","name","ID DESC","type='yn'");
$newForm->normalizedField("volunteer","field_data","ID","name","ID ASC","type='volunteer'");
$newForm->normalizedField("gender","field_data","ID","name","ID ASC","type='gender'");
$newForm->normalizedField("WkDays","field_data","ID","name","ID ASC","type='days'");
$newForm->normalizedField("StateCode","states","Code","Name","Name ASC");


//set custom field labels
$newForm->labelFields( array("FName","MName","LName","UserType","FindUs","NewsLetter","volunteer","Donation","NamePosted",
      "WkDays","PostalCode","StateCode","TelePhone","Mobile","Facsimile","Details"),
array("First Name","Middle Name","Last Name","I am a","How did you find us?",
      "Subscribe to our newsletter?", "I want to Volunteer", "I would like to donate",
      "Add name to Sponsors page?", "I can work these days","Zip Code","State","Home Phone",
      "Cell Phone","FAX","Personal Message")
);
$newForm->labelField("Password_verify","Verify Password");

//don't output field sets (<fieldset> tag)
#$newForm->fieldSets=false;

//set up regular expressions for field validation
$newForm->registerValidation("required",".+","Input is required.");
$newForm->registerValidation("valid_email",'^[a-zA-Z0-9_]{2,50}@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.?]+$',
         "Invalid email address.");
$newForm->registerValidation("uspostal","^[0-9]{5}(-?[0-9]{4})?$","Invalid US Postal Code.");
$newForm->registerValidation("currency_us","^([0-9]+(\.[0-9]{2})?)?$","Use dollar amount only.");
$newForm->registerValidation("six_chars",".{6,}","Enter at least six characters.");

//set up fields for validation using regexs above
$newForm->validateField("FName","required");
$newForm->validateField("Email","valid_email");
$newForm->validateField("Donation_Amount","currency_us");
$newForm->validateField("Password","six_chars");

//require the email field to be unique in the database (doesn't already exist)
$newForm->uniqueField("Email","Email is already registered.");

print_r($newForm->validate);
//set custom success message for update (after last page)
$newForm->msg_updateSuccess="<center><div style=\"width:455; padding:15px; background-color:#F1F3F3;\">
<p>Registration is now complete. Thanks for joining!</p></div></center>";

//set an encryption key so the record ID is encrypted to prevent tampering
$newForm->setEncryptionKey("g00D_3nCr4p7");

//retrieve record if get ID or post pkeyID
if( isset($_GET['ID']) ) $newForm->getRecord($_GET['ID']);
else if( isset($_POST['pkey']) ){
    $newForm->getRecord( $_POST['pkey'], isset($newForm->rc4key) );
} 
//output a feedback box at the top, and a line above each invalid field
#$newForm->feedback="both";
//test for last page and no errors to submit form, otherwise start form
    if( @$_POST['formitable_multipage']!="end" || isset($newForm->errMsg) ) $newForm->openForm();
    else $newForm->submitForm();
	#print_r($newForm->errMsg);
//first page - test for no submit OR errors set with a field on the first page
    if( !isset($_POST['submit']) || (isset($newForm->errMsg) && isset($_POST['FName'])) ):
    /*** open form pg 1 of 3 ***/ ?>
<h3>Page 1 of 3</h3>
<table align="center">
<tr> <!-- valign bottom to stay aligned when there is an error message. -->
<td width=225 valign="bottom"><? $newForm->printField("FName"); ?></td>
<td width=225 valign="bottom"><? $newForm->printField("MName"); ?></td>
<td width=225 valign="bottom"><? $newForm->printField("LName"); ?></td>
</tr>
<tr>
<td width=225 valign="bottom"><? $newForm->printField("Email"); ?></td>
<td width=225 valign="bottom"><? $newForm->printField("Password"); ?></td>
<td width=225 valign="bottom"><? $newForm->printField("Password","",true); ?></td>
</tr>
<tr>
<td width=225><? $newForm->printField("UserType"); ?></td>
<td width=225><? $newForm->printField("Age"); ?></td>
<td width=225><? $newForm->printField("gender"); ?></td>
</tr>
</table>

<? //on the first page set multipage to "start"

    $newForm->multiPage("start");
    $newForm->closeForm(); ?>

<? //test for a field on the previous page OR errors set with a field from this page
    elseif( isset($_POST['FName'] ) || ( isset($newForm->errMsg) && isset($_POST['City']) ) ):
    /*** open form pg 2 of 3 ***/ ?>
<h3>Page 2 of 3</h3>
<table>
<tr>
<td width=225><? $newForm->printField("Occupation"); ?></td>
<td width=225><? $newForm->printField("Address"); ?></td>
<td width=225><? $newForm->printField("Address2"); ?></td>
</tr>
<tr>
<td><? $newForm->printField("City"); ?></td>
<td><? $newForm->printField("StateCode"); ?></td>
<td><? $newForm->printField("PostalCode"); ?></td>
</tr>
<tr>
<td><? $newForm->printField("TelePhone"); ?></td>
<td><? $newForm->printField("Mobile"); ?></td>
<td><? $newForm->printField("Facsimile"); ?></td>
</tr>
</table>

<? //on the intermediate pages set multipage to "next"
    $newForm->multiPage("next"); 
    $newForm->closeForm(); ?>

<? //test for a field on the previous page OR errors set with a field from this page
    elseif( isset($_POST['City']) || (isset($newForm->errMsg) && isset($_POST['Donation'])) ):
    /*** open form pg 3 of 3 ***/ ?>
<h3>Page 3 of 3</h3>
<table>
<tr>
<td width=225 valign="top"><? $newForm->printField("FindUs"); ?></td>
<td width=225 valign="top"><? $newForm->printField("NewsLetter"); ?></td>
<td width=225 valign="top"><? $newForm->printField("volunteer"); ?></td>
</tr>
<tr>
<td width=450 height=100% colspan=2><? $newForm->printField("Details"); ?></td>
<td width=225 valign="top"><? $newForm->printField("WkDays"); ?></td>
</tr>
</table>

<table align="center">
<tr>
<td width=225 valign="bottom"><? $newForm->printField("Donation"); ?></td>
<td width=225 valign="bottom"><? $newForm->printField("Donation_Amount"); ?></td>
</tr>
</table>
<table align="center">
<tr>
<td width=225 valign="top"><? $newForm->printField("Donation_Type"); ?></td>
<td width=225 valign="top"><? $newForm->printField("recurring_Method"); ?></td>
</tr>
</table>

<? //on the last page set multipage to "end"
    $newForm->multiPage("end");
    $newForm->closeForm(); ?>

<? endif; ?>
</body>
</html>
