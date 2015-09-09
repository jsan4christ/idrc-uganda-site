<html>
<head>
<title>Formitable Demo</title>
<style type="text/css"> @import url("Formitable_style.css"); </style>

</head>

<body link="#777777" alink="#555555" vlink="#777777">

<table align="center" width="315" cellpadding=5 style="border:1px solid #888888;margin:10px;font-size:12px;">
<tr><td>
The following form was automatically created from a MySQL database table using the
Formitable PHP class. Formitable and this demo are available for download on the
<a href="https://sourceforge.net/projects/formitable/">Formitable homepage</a>.
Don't forget to try clicking on the field labels and also try
<a href="<?=$_SERVER['PHP_SELF'];?>?ID=1">retrieving a record</a>.
</td></tr></table>

<table align="center" cellpadding=5 style="border:1px solid #888888;">
<tr><td>

<?
require_once 'C:\apachefriends\xampp\htdocs\anyDB2\examples\connect.inc.php';
/*** change the following variables ***/
$user = "root";
$pass = "die8irmm";
$DB = "hesasys";

//include class, create new Formitable, set primary key field name
include("Formitable.class.php");
$newForm = new Formitable( $db,"formitable_demo" );
$newForm->setPrimaryKey("ID");
#$fields = $newForm->fields();
#$newForm->printField('f_name');
#echo $newForm->fields();
#print_r($fields);
#$i = 0;
#foreach ($fields as $field){
#	echo $newForm->getFieldType($i);
#	echo $newForm->getFieldLength($i).'<br>';
#	$i++;
#}
if( isset($_GET['ID']) ) $newForm->getRecord($_GET['ID']);
//call submit method if form has been submitted
if( !isset($_POST['submit']) ||
	(isset($_POST['submit']) && $newForm->submitForm() == -1) ){ $newForm->openForm(); }

	if (!isset($_POST['submit'])) $newForm->openForm();
	//hide primary key field, force a few field types
	$newForm->hideField("ID");
	$newForm->forceTypes(array("foods","day_of_week"),array("checkbox","radio"));

	//get data pairs from another table
	$newForm->normalizedField("toon","formitable_toons","ID","name","pkey ASC");
	#print_r($newForm->_getFieldData('toon')
	//set custom field labels
	$newForm->labelFields( array("f_name","l_name","description","pets","foods","color","day_of_week","b_day","toon"),
							array("First Name","Last Name","About Yourself","Your Pets","Favorite Foods","Favorite Color","Favorite Day","Your Birthday","Favorite Cartoon") );
	$newForm->registerValidation("required",".+","Input is required.");
	$newForm->validateField("f_name","required");
	$newForm->uniqueField("f_name","fname is already registered.");
	
	print_r($newForm->validate);
	echo isset($newForm->validate[f_name]);
	
	$newForm->printField("f_name");
	$newForm->printField("l_name");
	//output form
	#$newForm->printForm();
	#$newForm->printField('toon');
	$newForm->closeForm();
#$newForm = @mysql_list_fields($DB, "formitable_demo", @mysql_connect("localhost",$user,$pass));
#print($newForm);

?>

</td></tr></table>
</body></html>