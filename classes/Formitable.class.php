<?php

    //version 1.0
    class Formitable {

        //these vars determine whether to use default input type or an alternate based on field size
        //'enum' field default is SELECT, alternate is RADIO
        //'set' field default is MULTISELECT, alternate is CHECKBOX
        //'blob' or 'text' field default is TEXTAREA, alternate is TEXT
        var $enumField_toggle = 3;
        var $setField_toggle = 4;
        var $strField_toggle = 70;

        //these vars determine form input size attributes
        var $textInputLength = 50;
        var $textareaRows = 4;
        var $textareaCols = 50;
        var $multiSelectSize = 5;
        var $fileInputLength = 45;

        //these vars hold the string returned on success or fail of record INSERT/UPDATE
        var $msg_insertSuccess = "<label class=\"font\">Form has been submitted successfully.</label>";
        var $msg_insertFail = "<label class=\"font\"><b>An error occurred.</b><br/>Form submission failed.</label>";
        var $msg_updateSuccess = "<label class=\"font\">Record has been updated successfully.</label>";
        var $msg_updateFail = "<label class=\"font\"><b>An error occurred.</b><br/>Record update failed.</label>";

        //these vars hold the string outputted before and after error messages
        var $err_pre = "<br/><label class=\"err\">";
        var $err_post = "</label>";

        //toggle JavaScript labels
        var $jsLabels = false;

        //toggle print or return output
        var $returnOutput = false;

        //class constructor sets form name and gets table info. Args are DB link, DB name, table name.
        function Formitable(& $db, $table){

            //sniff for Netscape 4.x
            if( stristr(getenv("HTTP_USER_AGENT"), "Mozilla/4") && !stristr(getenv("HTTP_USER_AGENT"), "compatible" ) )
            $this->NS4 = true; else $this->NS4 = false;

            $this->_magic_quotes = get_magic_quotes_gpc();

            $this->db = $db;

            $this->formName = $this->table = $table;

            $this->fields = $this->db->execute("DESCRIBE $table ")
            or die("DB Form Connection Error ");

            $this->columns = count($this->fields);

            $this->pkey = "";

            $this->identifier = "";

            $this->optionBreak = $this->labelBreak = "<br/>\n";

            $this->fieldBreak = "<br/><br/>\n";

            $this->fieldSets = true;

            $this->feedback = "both";

            $this->db_errors = false;

            $this->hasFiles = false;

            $this->submitted = 0;

            $this->submitMsg = "";

            $this->skipFields( array("formitable_signature","formitable_multipage","formitable_setcheck","pkey","submit","x","y","MAX_FILE_SIZE") );

        }

        //this function submits the form to the database;
        //IF form 'pkey' value is set then UPDATE record
        //ELSE INSERT a new record
        function submitForm($echo=true){

            //return saved value if already submitted
            //this avoids double submit if called explicitly and then form is opened
            if($this->submitted){ return $this->submitted; }

            if( isset($_POST['formitable_signature']) ){
                $this->_signature = split( ",", $this->rc4->_decrypt($this->rc4key, $this->_check_magic_quotes($_POST['formitable_signature'])) );
                //cycle through formitable_setcheck POST variable to assign empty values if necessary
                foreach($this->_signature as $key){
                    if(!isset($_POST[$key])){ $_POST[$key]=""; }
                }
                //signature should always accompany encryption
            } else if( isset($this->rc4key) ) die($this->msg_insertFail);

            if( isset($_POST['pkey']) ){ //submit via UPDATE

                //decrypt primary key if encrypted
                if( isset($this->rc4key) ){
                    $_POST['pkey'] = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($_POST['pkey']) );
                    $_POST['pkey'] = str_replace($this->rc4key,"",$_POST['pkey']);
                }

                //set pkey for form output if validation fails
                $this->pkeyID = $_POST['pkey'];

                //cycle through formitable_setcheck POST variable to assign empty values if necessary
                if( isset($_POST['formitable_setcheck']) )
                foreach($_POST['formitable_setcheck'] as $key){
                    if( isset($this->rc4key) ){
                        $key = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($key) );
                    }
                    if(!isset($_POST[$key])){ $_POST[$key]=""; }
                }

                if($this->_checkValidation() == -1){ $this->submitted=-1; return -1; }

                //cycle through $_POST variables to form query assignments
                foreach($_POST as $key=>$value){
                    
                    //ignore formitable specific variables and fields not in signature
                    if( isset($this->skip[$key]) || strstr($key,"_verify") || strstr($key,"_day") || strstr($key,"_month") || strstr($key,"_year") ||
                        (isset($this->_signature) && !in_array($key, $this->_signature)) ) continue;

                    if( isset($this->dateField[$key])) {
                        $dateValue = $this->getDate($key);
                        @$fields .= ",`$key` = '".($this->_magic_quotes?$dateValue:addslashes($dateValue))."'";
                    }
                    #crypting password
                    else if ( isset($this->password[$key]) ){
                        #@$fields .= ",`".$key."`";
                        $encryptedPass = crypt($value,'yxpijaui93');
                        @$fields .= ",`$key` = '".($this->_magic_quotes?$encryptedPass:addslashes($encryptedPass))."'";
                    }
                    else{
                        //assign comma seperated value if checkbox or multiselect, otherwise normal assignment
                        if(is_array($value)) {@$fields .= ",`$key` = '".implode(",",$_POST[$key])."'";}
                        else @$fields .= ",`$key` = '".($this->_magic_quotes?$value:addslashes($value))."'";
                    }
                }

                //remove first comma
                $fields = substr($fields,1);

                if( is_array($this->pkey) ){

                    $SQLquery = "UPDATE $this->table SET $fields WHERE $this->priFields";
                }
                else{
                    //form and execute query, echoing results
                    $SQLquery = "UPDATE $this->table SET $fields WHERE `$this->pkey` = '".$_POST['pkey']."'";
                }

                #@mysql_select_db($this->DB,$this->conn);
                #@mysql_query($SQLquery,$this->conn);
                if(  $this->db->query($SQLquery) ){
                    //set pkeyID for output if multiple page form
                    if( @$_POST['formitable_multipage'] == "next" ){
                        //decrypt primary key if encrypted
                        if( isset($this->rc4key) ){
                            $this->pkeyID = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($_POST['pkey']) );
                        } $this->pkeyID = $_POST['pkey'];
                    } else {
                        if(@$_POST['formitable_multipage'] != "start"){
                            if($echo || !$this->returnOutput) echo $this->msg_updateSuccess;
                            else{
                                $this->submitMsg = $this->msg_updateSuccess;
                                return $this->msg_updateSuccess;
                            }
                        }
                    }
                    $this->submitted=1; return 1;
                } else {
                    if($echo) echo $this->msg_updateFail.($this->db_errors?"<br/>".$this->db->error:"");
                    else{
                        $this->submitMsg = $this->msg_updateFail.($this->db_errors?"<br/>".$this->db->error:"");
                        return $this->msg_updateFail.($this->db_errors?"<br/>".$this->db->error:"");
                    }
                    return 0;
                }
            } else { //submit via INSERT

                if($this->_checkValidation() == -1){ $this->submitted=-1; return -1; }

                foreach($_POST as $key=>$value){

                    if( isset($this->skip[$key]) || strstr($key,"_verify") || strstr($key,"_day") || strstr($key,"_month") || strstr($key,"_year") ||
                        (isset($this->_signature) && !in_array($key, $this->_signature)) ) continue;
                    #check for date fields
                    if( isset($this->dateField[$key])) {
                        #echo $this->pkey;
                        @$fields .= ",`".$key."`";
                        $dateValue = $this->getDate($key);
                        @$values .= ",'".($this->_magic_quotes?$dateValue:addslashes($dateValue))."'";
                    }
                    #check for pri key field
                    else if ( isset($this->priKey[$key])){
                        @$fields .= ",`".$key."`";
                        $priKey = $this->_getPriKey($this->id, $this->table);
                        @$values .= ",'".($this->_magic_quotes?$priKey:addslashes($priKey))."'";
                        $this->pkeyID =$priKey;
                    }
                    #crypting password
                    else if ( isset($this->password[$key]) ){
                        @$fields .= ",`".$key."`";
                        $encryptedPass = crypt($value,'yxpijaui93');
                        @$values .= ",'".($this->_magic_quotes?$encryptedPass:addslashes($encryptedPass))."'";
                    }
                    #identifier value
                    else if ( isset($this->identifier[$key])){
                    	@$fields .= ",`".$key."`";
                    	$id = $this->_getIdentifier($key, $this->table);
                    	@$values .= ",'".($this->_magic_quotes?$id:addslashes($id))."'";
                    }
                    else{
                        @$fields .= ",`".$key."`";

                        if(is_array($value)) @$values .= ",'".implode(",",$value)."'";
                        else @$values .= ",'".($this->_magic_quotes?$value:addslashes($value))."'";
                    }
                }

                //remove first comma
                $fields = substr($fields,1);
                $values = substr($values,1);

                //form and execute query, eventually echoing results
                $SQLquery = "INSERT INTO $this->table ($fields) VALUES ($values)";
                #@mysql_select_db($this->DB,$this->conn);
                if( $this->db->query($SQLquery) ){

                    //if multi page form, select last ID and set pkeyID
                    if( isset($_POST['formitable_multipage']) && $_POST['formitable_multipage'] == "start" ){
                        //$lastID = @mysql_insert_id($this->conn);
                        #$SQLquery = "SELECT `$this->pkey` FROM `$this->table` ORDER BY `$this->pkey` DESC LIMIT 1";
                        #$this->pkeyID = @mysql_result(@mysql_query($SQLquery,$this->conn),0);
                        $this->pkeyID = $priKey;
                    }
                    else if( !isset($_POST['formitable_multipage']) || $_POST['formitable_multipage']=="end" ){
                        if($echo) echo $this->msg_insertSuccess;
                        else{
                            $this->submitMsg = $this->msg_insertSuccess;
                            return $this->msg_insertSuccess;
                        }
                    }
                    $this->submitted=1; return 1;

                } else {
                    if($echo) echo $this->msg_insertFail.($this->db_errors?"<br/>".$this->db->error:"");
                    else{
                        $this->submitMsg = $this->msg_insertFail.($this->db_errors?"<br/>".$this->db->error:"");
                        return $this->msg_insertFail.($this->db_errors?"<br/>".$this->db->error:"");
                    }
                    return 0;

                }

            }

            unset($_POST['submit']);

        }

        //this function will query the table for the record with a primary key field value of argument $id
        //also see: setPrimaryKey();
        # method changed by Harold M to accommodate tables with more than one field making up the primary key
        #for that case $id should be the column names and $decode the values to be looked for
        function getRecord($id, $decode=false){

            if( is_array($id) && is_array($decode) ){
                #formulate sql values
                for($i=0;$i<sizeof($id);$i++){
                    $key = $id[$i];
                    $value = $decode[$i];
                    @$fields .= " AND $key = '".($this->_magic_quotes?$value:addslashes($value))."'";
                }
                $SQLquery = "SELECT * FROM $this->table WHERE 1 $fields ";
                $result = $this->db->execute($SQLquery);
                if( count($result) == 1){
                    $this->pkeyID = $decode[0];
                    $this->record = $result[0];
                    return true;
                }else
                return false;
            }
            else{
                if( isset($this->rc4key) && $decode ){
                    $id = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($id) );
                    $id = str_replace($this->rc4key,"",$id);
                }
                $SQLquery = "SELECT * FROM $this->table WHERE $this->pkey = '$id'";
                #@mysql_select_db($this->DB,$this->conn);
                $result = $this->db->execute($SQLquery);

                if( count($result) == 1 ){
                    $this->pkeyID = $id;
                    $this->record = $result[0];
                    return true;
                } else
                return false;
            }

        }

        //this function retrieves records from another table to be used as values for input
        //it is used for lookup tables / normalized data -New in version .98-
        function normalizedField($fieldName, $tableName, $tableKey = "ID", $tableValue = "name", $orderBy = "value ASC", $whereClause = "1"){

            $this->normalized[$fieldName]['tableName'] = $tableName;
            $this->normalized[$fieldName]['tableKey'] = $tableKey;
            $this->normalized[$fieldName]['tableValue'] = $tableValue;
            $this->normalized[$fieldName]['orderBy'] = $orderBy;
            $this->normalized[$fieldName]['whereClause'] = $whereClause;
        }

        //this function retrieves records from another table to be used as labels for enum/set fields
        //it is used to supply descriptions for smaller names -New in version .99-
        function getLabels($fieldName, $tableName, $tableKey = "ID", $tableValue = "name"){

            $this->labelValues[$fieldName]['tableName'] = $tableName;
            $this->labelValues[$fieldName]['tableKey'] = $tableKey;
            $this->labelValues[$fieldName]['tableValue'] = $tableValue;
        }

        //this function forces a form field to an explicit input type regardless of size
        //args are field name and input type, input types are as follows:
        //for enum field - "select" or "radio"
        //for set field- "multiselect" or "checkbox"
        //for string or blob field - "text" or "textarea"
        //string can also be forced as "password" or "file"
        function forceType($fieldName,$inputType){

            if($inputType == "file") $this->hasFiles = true;
            $this->forced[$fieldName] = $inputType;

        }

        function forceTypes($fieldNames,$inputTypes){

            if( sizeof($fieldNames) != sizeof($inputTypes) ) return false;

            for($i=0;$i<sizeof($fieldNames);$i++)
            $this->forceType($fieldNames[$i],$inputTypes[$i]);

            return true;

        }

        //this function sets a default value for the field
        function setDefaultValue($fieldName, $fieldValue="", $overrideRetrieved=false) {
            $this->defaultValues[$fieldName]['value'] = $fieldValue;
            if($overrideRetrieved) $this->defaultValues[$fieldName]['override'] = true;
        }

        //this function forces a form field to be skipped on INSERT or UPDATE
        //arg is field name
        function skipField($fieldName){

            $this->skip[$fieldName] = true;

        }

        function skipFields($fieldNames){

            if( !is_array($fieldNames) ) return false;

            for($i=0;$i<sizeof($fieldNames);$i++)
            $this->skip[$fieldNames[$i]] = true;

            return true;

        }

        //this function hides a field from HTML output
        //arg is field name, plural version below
        function hideField($fieldName){

            $this->hidden[$fieldName] = "hide";

        }

        function hideFields($fieldNames){

            for($i=0;$i<sizeof($fieldNames);$i++)
            $this->hidden[$fieldNames[$i]] = "hide";

        }

        //this function sets a field's label text
        //args are field name and label text, plural version below
        function labelField($fieldName,$fieldLabel){

            $this->labels[$fieldName] = $fieldLabel;

        }

        function labelFields($fieldNames,$fieldLabels){

            if( sizeof($fieldNames) != sizeof($fieldLabels) ) return false;

            for($i=0;$i<sizeof($fieldNames);$i++)
            $this->labels[$fieldNames[$i]] = $fieldLabels[$i];

            return true;

        }

        //this function sets the HTML immediately
        //following label tags, arg is HTML code
        function setLabelBreak($HTML){

            $this->labelBreak = $HTML;

        }

        //this function sets the HTML immediately
        //following each field type, arg is HTML code
        function setFieldBreak($HTML){

            $this->fieldBreak = $HTML;

        }

        //this function sets the HTML immediately
        //following each radio option, arg is HTML code
        function setOptionBreak($HTML){

            $this->optionBreak = $HTML;

        }

        //this function allows you set all breaks including label, field and option
        //it's useful for changing 2 or 3 breaks at the same time, option break is optional
        function setBreaks($label, $field, $option="*NONE*"){

            $this->labelBreak = $label;
            $this->fieldBreak = $field;
            if($option!="*NONE*") $this->optionBreak = $option;

        }

        //this function sets the name of the table's primary key,
        //it necessary to retrieve/update a record or for multiPage functionality
        #for update purposes on tables with multi-column primary key, the parameter should be an array
        function setPrimaryKey($pkey_name){

            if(is_array($pkey_name) ){

                $this->pkey = $pkey_name;
            }
            else{
                $this->pkey = $pkey_name;
                $this->priKey[$pkey_name] = true;
            }
        }
        #function sets the primary key values for tables with multi-column primary key
        function setPrimaryKeyValues($fields, $values){

            if( is_array($fields) && is_array($values) ){
                #formulate sql values
                for($i=0;$i<sizeof($fields);$i++){
                    $key = $fields[$i];
                    $value = $values[$i];
                    @$columns .= "$key = '".($this->_magic_quotes?$value:addslashes($value))."'";
                    if($i < sizeof($fields)-1 )
                    @$columns .= " AND ";
                }
                $this->priFields = $columns;
                return true;
            }
            else
            return false;
        }
        #sets identifier field for the table
        function setIdentifier($fieldName){

            $this->identifier[$fieldName] = true;
            $this->id = $fieldName;
        }
        #function to set password field
        function setPasswordField($fieldName){

            $this->password[$fieldName] = true;
        }
        //this function sets the fieldsets option, value is either true or false
        function toggleFieldSets($toggle){

            $this->fieldSets=$toggle;

        }

        //this function checks records for field value, arg is field name
        function uniqueField($fieldName,$msg="Already taken."){

            $this->unique[$fieldName]['msg'] = $msg;

        }

        //this function registers a new validation type
        //args are method name, regular expression, and optional error text
        function registerValidation($methodName, $regex, $errText = "Invalid input."){

            $this->validationExpression[$methodName]['regex'] = $regex;
            $this->validationExpression[$methodName]['err'] = $errText;

        }

        //this function sets a field's validation type
        //args are field name, method name, and optional custom error text
        function validateField($fieldName, $methodName, $errText = "*NONE*"){

            $this->validate[$fieldName]['method'] = $methodName;
            if($errText!="*NONE*") $this->validate[$fieldName]['err'] = $errText;

        }

        //this function opens the form tag and submits the form if pkey is set
        function openForm($attr="", $autoSubmit=true, $action=""){

            if( $this->returnOutput ){ ob_start(); }

            if( isset($_POST['submit']) && $autoSubmit ){
                //submit form and store results
                $submitStatus=$this->submitForm();
                //output error text box if validation failed and $feedback set
                if( $submitStatus==-1 && ($this->feedback=="box" || $this->feedback=="both") ){
                    echo "\n<center><div class=\"msgBox\">";
                    foreach($this->errMsg as $key=>$value){
                        if( isset($this->labels[$key]) ) $label = $this->labels[$key];
                        else $label = ucwords( str_replace("_", " ", $key) );
                        echo "<label class=\"msg\">".$label.":".$value."</label><br/>";
                    }
                    echo "\n</div></center>";
                }
                //don't open form if single page form or last page of multiple and no errors
                if( (!isset($_POST['formitable_multipage']) || $_POST['formitable_multipage']=="end") && $submitStatus!=-1 ) return;
            }

            echo "<form name=\"$this->formName\" action=\"".($action?$action:$_SERVER['PHP_SELF'])."\" method=\"POST\"".($this->hasFiles?" enctype=\"multipart/form-data\"":"").($attr!=""?" ".$attr:"").">\n";

            //output hidden MAX_FILE_SIZE field if files are present
            //to set the upload size smaller than the value in php.ini
            //create an .htaccess file with the following directive
            //php_value upload_max_filesize 1M
            //http://us3.php.net/manual/en/ini.core.php#ini.upload-max-filesize
            if($this->hasFiles){
                $maxBytes = trim(ini_get('upload_max_filesize'));
                $lastChar = strtolower($maxBytes[strlen($maxBytes)-1]);
                if($lastChar=="k"){ $maxBytes=$maxBytes*1024; }
                else if($lastChar=="m"){ $maxBytes=$maxBytes*1024*1024; }
                echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$maxBytes\">\n";
            }

            if( $this->returnOutput ){
                $html_block = ob_get_contents();
                ob_end_clean();
                return $html_block;
            }

        }

        //this function closes the form tag & prints a hidden field 'pkey' if a record has been set either manually or through multiPage
        //optional argument is the <div> alignment of the Reset and Submit buttons, value should be "right" or "left", "center" is default
        function closeForm($submitValue="Submit",$attr="",$resetValue="Reset Form",$printReset=true){

            if( $this->returnOutput ){ ob_start(); }

            //output hidden pkey field for update opertaions
            if( isset($this->pkeyID) ){
                if( isset($this->rc4key) ){
                    $pkeyVal = $this->rc4->_encrypt( $this->rc4key, $this->rc4key.$this->pkeyID );
                } else $pkeyVal = $this->pkeyID;
                echo "<input type=\"hidden\" name=\"pkey\" value=\"$pkeyVal\"/>\n";
            }
            //output hidden signature field for security check
            if( isset($this->rc4key) ){
                $sigVal = $this->rc4->_encrypt( $this->rc4key, implode(",",$this->signature) );
                echo "<input type=\"hidden\" name=\"formitable_signature\" value=\"$sigVal\"/>\n";
            }

            if( isset($this->multiPageSubmitValue) ) $submitValue=$this->multiPageSubmitValue;
            echo "<div class=\"button\">".($printReset?"<input type=\"reset\" value=\"$resetValue\" class=\"reset\"/>":"");
            if(strstr($submitValue,"image:"))
            echo "<input type=\"hidden\" name=\"submit\"><input type=\"image\" src=\"".str_replace("image:","",$submitValue)."\" class=\"img\"".($attr!=""?" ".$attr:"")."/>";
            else echo "<input type=\"submit\" name=\"submit\" value=\"$submitValue\" class=\"submit\"".($attr!=""?" ".$attr:"")."/>";
            echo "</div></form>\n";

            if( $this->returnOutput ){
                $html_block = ob_get_contents();
                ob_end_clean();
                return $html_block;
            }

        }

        //This function outputs a single field called by name. It searches the fields resource using mysql_field_name
        //until it finds the field provided in the argument, it then calls _outputField($n) where $n is the record offset
        function printField($fieldName,$attributes="",$verify=false){

            for ($n=0; $n < $this->columns; $n++){

                if( $fieldName == $this->getFieldName($n)  ){

                    if( $this->returnOutput ){ ob_start(); }

                    $this->_outputField($n, $attributes, $verify);

                    if( $this->returnOutput ){
                        $html_block = ob_get_contents();
                        ob_end_clean();
                        return $html_block;
                    }

                    return 1;
                }

            } return 0;

        }

        //this sets a key string for rc4 encryption of pkey
        function setEncryptionKey($key){
            if($key!=""){
                $this->rc4key=$key;
                $this->rc4 = new rc4crypt();
                return true;
            } else return false;
        }

        //this function outputs a hidden field that enables a multi page form, takes argument $step
        //$step should be "start" for first page, "end" for last page and "next" for intermediate pages
        function multiPage($step,$buttonValue="Continue"){

            if( $this->returnOutput ){ ob_start(); }

            if($step=="start" || $step=="next" || $step=="end")
            echo "<input type=\"hidden\" name=\"formitable_multipage\" value=\"$step\"/>";
            if($step=="end" && $buttonValue=="Continue") $this->multiPageSubmitValue="Finish";
            else $this->multiPageSubmitValue=$buttonValue;

            if( $this->returnOutput ){
                $html_block = ob_get_contents();
                ob_end_clean();
                return $html_block;
            }

        }

        //This function returns a single field value. It is useful to test a field value without printing it
        //this is equivilent to accessing a field like so: $FormitableObj->record["fieldName"] but with some error checking
        function getFieldValue($fieldName){

            if( isset($this->record[$fieldName]) ) return $this->record[$fieldName];
            else return false;

        }

        //This function returns a single field label. It is useful to get a field label without printing it
        //this is equivilent to accessing a field like so: $FormitableObj->labels["fieldName"] but with some error checking
        function getFieldLabel($fieldName){

            if( isset($this->labels[$fieldName]) ) return $this->labels[$fieldName];
            else return ucwords( str_replace("_", " ", $fieldName) );

        }

        //This function enables the submission of an arbitrary field when encryption is enabled
        //and the field was not output in the form (therefore not included in the form signature)
        function allowField($fieldName){

            if( $fieldName ) $this->signature[] = $fieldName;

        }

        //this function outputs the entire form, one field at a time
        function printForm(){

            if( $this->returnOutput ){

                ob_start();
                echo $this->openForm();
                for ($n=0; $n < $this->columns; $n++) $this->_outputField($n);
                echo $this->closeForm();
                $html_block = ob_get_contents();
                ob_end_clean();
                return $html_block;

            } else {

                $this->openForm();
                for ($n=0; $n < $this->columns; $n++) $this->_outputField($n);
                $this->closeForm();

            }

        }

        //this function sets the error feedback method
        function setFeedback($mode){

            if( @in_array($mode, array("line","box","both")) ){
                $this->feedback = $mode;
                return true;
            } else return false;

        }

        //this function sets a callback function
        function registerCallback($fieldName, $funcName, $mode = "post", $args = ""){

            if( @in_array(strtolower($mode), array("post","retrieve","both")) && is_callable($funcName) ){

                $this->callback[$fieldName]["args"] = $args;

                if($mode == "both"){
                    $this->callback[$fieldName]["post"] = $this->callback[$fieldName]["retrieve"] = $funcName;
                } else {
                    $this->callback[$fieldName][$mode] = $funcName;
                }

                return true;

            } else return false;

        }

        /*** BEGIN PRIVATE METHODS ***/

        //The following function is modified from php.net:
        //http://www.php.net/manual/en/function.mysql-fetch-field.php
        //Courtesy of: justin@quadmyre.com & chrisshaffer@bellsouth.net
        function _mysql_enum_values($tableName,$fieldName){

            #$result = @mysql_query("DESCRIBE $tableName");

            foreach($this->fields as $row){

                ereg('^([^ (]+)(\((.+)\))?([ ](.+))?$',$row['Type'],$fieldTypeSplit);

                //split type up into array
                $fieldType = $fieldTypeSplit[1];
                $fieldLen = $fieldTypeSplit[3];

                if ( ($fieldType=='enum' || $fieldType=='set') && ($row['Field']==$fieldName) ){
                    $fieldOptions = split("','",substr($fieldLen,1,-1));
                    return $fieldOptions;
                }
            }

            return FALSE;

        }
        #get current table identifier
        function _getIdentifier($fieldName, $tablename){

            $idSQL = "SELECT MAX($fieldName) FROM $tablename";
            $result = $this->db->execute($idSQL);
            $id = $result[0];
            return $id["MAX($fieldName)"] + 1;
        }
        #calculate the respective primary key
        function _getPriKey($fieldName, $tablename){

            $id = $this->_getIdentifier($fieldName, $tablename);
            
            if( strstr($tablename, "_land") ){
		$land_no = "L".$id;
		return $land_no;
            }
            elseif( strstr($tablename, "_house") ){
                $house_no = "H".$id;
                return $house_no;
            }
            else{
                return $id;
            }
        }

        //retrieve normalized data from another field
        function _getFieldData($fieldName){

            $SQLquery = "SELECT `"
            .$this->normalized[$fieldName]['tableKey']."` AS pkey".
                                        ", `"
            .$this->normalized[$fieldName]['tableValue']."` AS value ".
                                        "FROM `"
            .$this->normalized[$fieldName]['tableName']."` ".
                                        "WHERE "
            .$this->normalized[$fieldName]['whereClause']." ".
                                        "ORDER BY "
            .$this->normalized[$fieldName]['orderBy'];

            $retrievedData = $this->db->execute($SQLquery);
            if($this->db->error != ""){
                echo "ERROR: Unable to retrieve normalized data from '".$this->normalized[$fieldName]['tableName']."'".($this->db_errors?"<br/>".$this->db->error:"");
                return false;
            }
            $this->normalized[$fieldName]['pairs'] = count($retrievedData);
            $i = 0;
            foreach($retrievedData as $set){

                #$set = $retrievedData;
                $this->normalized[$fieldName]['keys'][$i] = $set['pkey'];
                $this->normalized[$fieldName]['values'][$i] = $set['value'];
                $i++;
            }
            return true;
        }

        //retrieve field labels from another field
        function _getFieldLabels($fieldName,$fieldOptions){

            $fieldOptions= "'".implode("','",$fieldOptions)."'";
            $SQLquery = "SELECT `"
            .$this->labelValues[$fieldName]['tableKey']."` AS pkey".
                                        ", `"
            .$this->labelValues[$fieldName]['tableValue']."` AS value ".
                                        "FROM `"
            .$this->labelValues[$fieldName]['tableName']."` ".
                                        "WHERE `".$this->labelValues[$fieldName]['tableKey']."` IN(".$fieldOptions.")";

            $retrievedData = $this->db->execute($SQLquery);
            if($this->db->error != ""){
                echo "ERROR: Unable to retrieve field labels from '".$this->labelValues[$fieldName]['tableName']."'.".($this->db_errors?"<br/>".$this->db->error:"");
                return false;
            }

            foreach($retrievedData as $set){

                $this->labelValues[$fieldName][$set['pkey']] = $set['value'];

            }

        }

        //outputs a hidden field that gets checked on submit to
        //prevent empty set/enum fields from being overlooked when empty (i.e. no fields checked)
        function _putSetCheckField($name){
            if(!isset($this->pkeyID) || isset($this->rc4key)) return;
            echo "<input type=\"hidden\" name=\"formitable_setcheck[]\" value=\"$name\"/>\n\n";
        }

        //prevent empty set/enum fields from being overlooked when empty (i.e. no fields checked)
        //cycle through formitable_setcheck POST variable to assign empty values if necessary
        function _setCheck(){
            if( isset($_POST['formitable_setcheck']) )
            foreach($_POST['formitable_setcheck'] as $key){
                if( isset($this->rc4key) ){
                    $key = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($key) );
                }
                if(!isset($_POST[$key])) $_POST[$key]="";
            }
        }

        //checks magic quotes and returns value accordingly
        function _check_magic_quotes($value){
            return $this->_magic_quotes?stripslashes($value):$value;
        }

        //validate field
        function _validateField($fieldName,$fieldValue,$methodName){

            //special case for verify fields
            if($methodName == "_verify"){

                if( $_POST[$fieldName] == $_POST[str_replace("_verify","",$fieldName)] ) return true;
                else{ $this->errMsg[$fieldName] = "Values do not match"; return false; }

            }else if($methodName == "validateDate"){

                if (empty($_POST[$fieldName.'_day']) || empty($_POST[$fieldName.'_month']) || empty($_POST[$fieldName.'_year']) ){
                    $this->errMsg[$fieldName] = 'All Fields Must be Filled in';
                    return false;
                }
                elseif ($this->validateDate($fieldName)) return true;
                else {
                    $this->errMsg[$fieldName] = "This Date is Invalid";
                    return false;
                }
            }
            else if( @ereg($this->validationExpression[$methodName]['regex'],$fieldValue) ){
                return true;
            } else {
                //test if custom error is set
                if( isset($this->validate[$fieldName]['err']) )
                $this->errMsg[$fieldName] = $this->validate[$fieldName]['err'];
                else //otherwise use default error
                $this->errMsg[$fieldName] = $this->validationExpression[$methodName]['err'];
                return false;
            }

        }

        //check validation
        function _checkValidation(){

            //cycle through $_POST variables to test for validation
            foreach($_POST as $key=>$value){

                //decrypt hidden values if encrypted
                if( isset($this->forced[$key]) && $this->forced[$key]=="hidden" && isset($this->rc4key) ){
                    $_POST[$key] = $value = $this->rc4->_decrypt( $this->rc4key, $this->_check_magic_quotes($value) );
                }

                $validated = true;
                if( isset($this->validate[$key]) )
                $validated = $this->_validateField($key,$value,$this->validate[$key]['method']);

                //run callback if set and is callable
                if( isset($this->callback[$key]["post"]) && $validated ){

                    $tmpValue = $this->callback[$key]["post"]($key,$value,$this->callback[$key]["args"]);
                    if( isset($tmpValue["status"]) && $tmpValue["status"] == "failed"){
                        $this->errMsg[$key] = $tmpValue["errMsg"];
                        $validated = false;
                    }
                    else $_POST[$key] = $tmpValue;

                }

                //special cases for unique and verify fields
                if( isset($this->unique[$key]) && $validated ) $this->_queryUnique($key);
                if( strstr($key,"_verify") && $validated ) $this->_validateField($key,$value,"_verify");

            }

            //test if there are errors from validation
            if( isset($this->errMsg) ) return -1;

        }

        //this function checks if a field value is unique (not already stored in a record)
        function _queryUnique($fieldName){

            $SQLquery = "SELECT `".$fieldName."` FROM ".$this->table." WHERE `".$fieldName."` ='".$_POST[$fieldName]."'";
            //if updating make sure it doesn't select self
            if( isset($_POST['pkey']) ) $SQLquery .= " AND ".$this->pkey." != '".$_POST['pkey']."'";
            if( count($this->db->execute($SQLquery)) ) $this->errMsg[$fieldName] = $this->unique[$fieldName]['msg'];

        }

        //this function is used by printForm to write the HTML for all label tags
        //args are field name and label text with optional css class, focus value and fieldset
        function _putLabel($fieldName, $fieldLabel, $css="text", $focus=true, $fieldSet=false){

            if($focus && $this->jsLabels) $onclick = " onClick=\"forms['$this->formName']['$fieldName'].select();\"";
            else $onclick = "";

            if( !$this->NS4 && !strstr($fieldName," ") ){
                echo "<label class=\"".$css."label\" for=\"".$fieldName."\"$onclick>".$fieldLabel."</label>";
                if(!$fieldSet) echo $this->labelBreak; else echo $this->optionBreak;
            } else {
                echo "<label class=\"".$css."label\" for=\"".$fieldName."\">".$fieldLabel."</label>";
                if(!$fieldSet) echo $this->labelBreak; else echo $this->optionBreak;
            }

        }

        //this function is called by _outputField. it returns the correct field value by
        //testing if a record has been retrieved using getRecord(), the form is posted
        //or a default value has been set.
        function _putValue($fieldName,$fieldType="text",$fieldValue="*NONE*"){

            $retrieved = isset($this->record);
            if($retrieved){
                $recordValue = isset($this->defaultValues[$fieldName]['override']) ?
                $this->defaultValues[$fieldName]['value'] : $this->record[$fieldName];
            }

            $posted = isset($_POST[$fieldName]);
            if($posted) $postValue = $_POST[$fieldName];

            $default = isset($this->defaultValues[$fieldName]);
            if($default) $defaultValue = $this->defaultValues[$fieldName]['value'];

            switch($fieldType){

                case "textarea":
                if( $posted && isset($postValue) )
                return $postValue;
                else if( $retrieved )
                return isset($this->callback[$fieldName]["retrieve"]) ?
                $this->callback[$fieldName]["retrieve"]($fieldName,$recordValue,$this->callback[$fieldName]["args"])
                : $recordValue;
                else if( isset($defaultValue) )
                return $defaultValue;
                break;

                case "hidden":
                case "text":
                if( isset($postValue) ){
                    if( $fieldType=="hidden" && isset($this->rc4key) )
                    $postValue = $this->rc4->_encrypt($this->rc4key, $postValue);
                    return " value=\"$postValue\"";
                }
                else if( isset($recordValue) ){
                    $value = isset($this->callback[$fieldName]["retrieve"]) ?
                    $this->callback[$fieldName]["retrieve"]($fieldName,$recordValue,$this->callback[$fieldName]["args"])
                    : $recordValue;
                    if( $fieldType=="hidden" && isset($this->rc4key) )
                    $value = $this->rc4->_encrypt($this->rc4key, $value);
                    return " value=\"$value\"";
                }
                else if( isset($defaultValue) ){
                    if( $fieldType=="hidden" && isset($this->rc4key) )
                    $defaultValue = $this->rc4->_encrypt($this->rc4key, $defaultValue);
                    return " value=\"$defaultValue\"";
                }
                //accounts for default date & time formats
                else if( $fieldValue != "*NONE*" )
                return " value=\"$fieldValue\"";
                break;

                case "radio":
                $selectedText = " checked";
                case "select":
                if(!isset($selectedText)) $selectedText = " selected";
                if( ($posted && $postValue == $fieldValue) ||
                    (!$posted && $retrieved && $recordValue == $fieldValue) ||
                    (!$posted && !$retrieved && $default && $defaultValue == $fieldValue)
                ) return $selectedText;
                break;

                case "checkbox":
                $selectedText = " checked";
                case "multi":
                if(!isset($selectedText)) $selectedText = " selected";
                if(
                    ($posted && $postValue && preg_match( '/\b'.$fieldValue.'\b/', implode(",",$postValue) )) ||
                    (!$posted && $retrieved && preg_match('/\b'.$fieldValue.'\b/', $recordValue)) ||
                    (!$posted && !$retrieved && $default && preg_match('/\b'.$fieldValue.'\b/', $defaultValue))
                ){ return $selectedText; }
                break;
                case "date":
                if( $posted && isset($postValue) )
                return $postValue;
                else if( $retrieved )
                #return isset($this->callback[$fieldName]["retrieve"]) ?
                #$this->callback[$fieldName]["retrieve"]($fieldName,$recordValue,$this->callback[$fieldName]["args"])
                return $recordValue;
                else if( isset($defaultValue) )
                return $defaultValue;
                break;
            }

            return "";

        }

        //Method to get name of Field
        function getFieldName($n){
            $field = $this->fields[$n]['Field'];
            return $field;
        }
        //Method to get type of Field Info
        function getFieldType($n){
            $type = $this->fields[$n]['Type'];
            //split type
            ereg('^([^ (]+)(\((.+)\))?([ ](.+))?$',$type,$split);
            if ($split[1] == 'enum' || $split[1] == 'set' || $split[1] == 'varchar')
            return 'string';
            else if ($split[1] == 'tinytext' || $split[1] == 'text' || $split[1] == 'mediumtext' || $split[1] == 'longtext')
            return 'blob';
            else if ($split[1] == 'tinyblob' || $split[1] == 'mediumblob' || $split[1] == 'longblob')
            return 'blob';
            else if ($split[1] == 'tinyint' || $split[1] == 'smallint' || $split[1] == 'mediumint' || $split[1] == 'bigint')
            return 'int';
            else
            return $split[1];
        }
        //Method to get lengh of Field
        function getFieldLength($n){
            $len = $this->fields[$n]['Type'];
            $enumLen = '';
            $blobLen = 65535;
            $dateLen = 10;
            //split type
            ereg('^([^ (]+)(\((.+)\))?([ ](.+))?$',$len,$split);
            if ($split[1] == 'enum' || $split[1] == 'set'){
                //split enum or set values into an array
                $elements = split("','",substr($split[3],1,-1));
                //calculating the total length of all elements thru use of a string with a comma after each element
                $i = 1; //Helper variable for the No. of commas needed
                foreach ($elements as $element){
                    $enumLen .= $element;
                    if ($i < count($elements))
                    $enumLen .= ',';
                    $i++;
                }
                return strlen($enumLen);
            }
            // default text Length
            else if ($this->getFieldType($n) == 'blob')
            return $blobLen;
            //default date Length
            else if ($this->getFieldType($n) == 'date')
            return $dateLen;
            else
            return $split[3];
        }
        //Method to get extra Field Info
        function getFieldFlags($n){
            $flags = '';
            // retrieve extra info from Type Array
            $extra = $this->fields[$n]['Type'];
            ereg('^([^ (]+)(\((.+)\))?([ ](.+))?$',$extra,$split);
            $flags .= ' '.$split[4];
            //if type is enum or set
            if ($split[1] == 'enum')
            $flags .= ' '.$split[1];
            if ($split[1] == 'set')
            $flags .= ' '.$split[1];
            //retrieve Null value status
            $null = $this->fields[$n]['Null'];
            if ($null == '')
            $flags .= ' not_null';
            //retrieve and add Kex status Info to flags
            $flags .= ' '.$this->fields[$n]['Key'];
            //retrieve and add Default Info to flags
            $flags .= ' '.$this->fields[$n]['Default'];
            //retrieve and add extra infos to flags
            $flags .= ' '.$this->fields[$n]['Extra'];

            return $flags;
        }
        //this function forms the core of the class;
        //it is called by public function printField and outputs a single field using a record offset
        function _outputField($n,$attr="",$verify=false){

            $name = $this->getFieldName($n);
            $type = $this->getFieldType($n);
            $len  = $this->getFieldLength($n);
            $flag = $this->getFieldFlags($n);
            $byForce = false;

            //automatically detect primay key
            if( strstr($flag,"primary_key") ) $this->setPrimaryKey($name);

            //check if type is forced, set var accordingly
            if( isset($this->forced[$name]) ) $byForce = $this->forced[$name];

            //if hidden, set type to skip
            if( isset($this->hidden[$name]) ) $type = "skip";
            else $this->signature[] = $name;

            //handle hidden type
            if( $byForce == "hidden" ){
                echo "<input type=\"hidden\" name=\"$name\"".$this->_putValue($name,"hidden").($attr!=""?" ".$attr:"")."/>\n";
                return;
            }

            //set custom label or uppercased-spaced field name
            if($verify) $verified="_verify"; else $verified="";
            if( isset($this->labels[$name.$verified]) ) $label = $this->labels[$name.$verified];
            else $label = ucwords( str_replace("_", " ", $name.$verified) );

            //add error text to label if validation failed
            if( $this->feedback=="line" || $this->feedback=="both" ){

                //test if verify field and validation failed
                if( $verify && isset($this->errMsg[$name."_verify"]) ) $label .= $this->err_pre.$this->errMsg[$name."_verify"].$this->err_post;
                //else test if regular field validation failed
                else if( isset($this->errMsg[$name]) && $byForce != "button" ) $label .= $this->err_pre.$this->errMsg[$name].$this->err_post;

            }

            //set vars if normalized data was retrieved
            if( isset($this->normalized[$name]) ) $valuePairs = true;	else $valuePairs = false;

            //set vars if enum labels were retrieved
            if( isset($this->labelValues[$name]) ) $labelPairs = true;	else $labelPairs = false;

            switch($type){

                case "real":
                case "float":
                case "double":
                case "decimal":
                case "int":
                if($valuePairs){
                    $this->_putLabel($name,$label,"select",false);
                    $this->_getFieldData($name);
                    echo "<select name=\"$name\" id=\"$name\" size=\"1\" class=\"select\"".($attr!=""?" ".$attr:"").">\n";
                    echo "<option value=''> </option>";#empty option
                    for($i=0;$i<$this->normalized[$name]['pairs'];$i++)
                    echo "	<option value=\"".$this->normalized[$name]['keys'][$i]."\"".$this->_putValue($name,"select",$this->normalized[$name]['keys'][$i]).">".$this->normalized[$name]['values'][$i]."</option>\n";
                    echo "</select>$this->fieldBreak";
                }
                else {
                    $this->_putLabel($name,$label);
                    if($len<$this->textInputLength) $length = $len; else $length=$this->textInputLength;
                    echo "<input type=\"text\" name=\"$name\" id=\"$name\" size=\"$length\" MAXLENGTH=\"$len\" class=\"text\"".$this->_putValue($name).($attr!=""?" ".$attr:"").">$this->fieldBreak";
                }
                break;

                case "blob":
                $this->_putLabel($name,$label);
                if( $byForce == "file" )
                echo "<input type=\"file\" name=\"$name\" id=\"$name\" size=\"$this->fileInputLength\" class=\"file\"".($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                else if( ($len>$this->strField_toggle || $byForce == "textarea") && $byForce != "text" )
                echo "<textarea name=\"$name\" id=\"$name\" rows=\"$this->textareaRows\" cols=\"$this->textareaCols\" class=\"textarea\"".($attr!=""?" ".$attr:"").">".$this->_putValue($name,"textarea")."</textarea>$this->fieldBreak";
                else echo "<input type=\"text\" name=\"$name\" id=\"$name\" size=\"$this->textInputLength\" MAXLENGTH=\"$len\" class=\"text\"".$this->_putValue($name).($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                break;

                case "string":

                if( strstr($flag,"enum") || $byForce == "select" ){

                    if($valuePairs){
                        $this->_getFieldData($name);
                        $len=sizeof($this->normalized[$name]);
                    } else {
                        $options = $this->_mysql_enum_values($this->table,$name);
                        if($labelPairs) $this->_getFieldLabels($name,$options);
                        $len=sizeof($options);
                    }

                    if( ($len > $this->enumField_toggle || $byForce == "select") && $byForce != "radio"){
                        $this->_putLabel($name,$label,"",false);
                        echo "<select name=\"$name\" id=\"$name\" size=\"1\" class=\"select\"".($attr!=""?" ".$attr:"").">\n";
                        echo "<option value=''> </option>";#empty option
                        if( $valuePairs )
                        for($i=0;$i<$this->normalized[$name]['pairs'];$i++)
                        echo "	<option value=\"".$this->normalized[$name]['keys'][$i]."\"".$this->_putValue($name,"select",$this->normalized[$name]['keys'][$i]).">".$this->normalized[$name]['values'][$i]."</option>\n";
                        else
                        foreach($options as $opt){
                            if( isset($this->labelValues[$name][$opt]) ) $optionLabel=$this->labelValues[$name][$opt]; else $optionLabel=$opt;
                            echo "	<option value=\"$opt\"".$this->_putValue($name,"select",$opt).">$optionLabel</option>\n";
                        }

                        echo "</select>$this->fieldBreak";
                    } else {
                        if($this->fieldSets){
                            echo "<fieldset class=\"fieldset\">\n";
                            echo "<legend class=\"legend\">$label</legend>\n";
                        } else $this->_putLabel($name,$label,"",false);
                        if( $valuePairs )
                        for($i=0;$i<$this->normalized[$name]['pairs'];$i++){
                            echo "	<input type=\"radio\" name=\"$name\" id=\"{$name}_".$this->normalized[$name]['keys'][$i]."\" value=\"".$this->normalized[$name]['keys'][$i]."\" class=\"radio\"".$this->_putValue($name,"radio",$this->normalized[$name]['keys'][$i]).($attr!=""?" ".$attr:"")."/>";
                            $this->_putLabel($name."_".$this->normalized[$name]['keys'][$i],$this->normalized[$name]['values'][$i],"radio",true,true);
                        }
                        else
                        foreach($options as $opt){
                            if( isset($this->labelValues[$name][$opt]) ) $optionLabel=$this->labelValues[$name][$opt]; else $optionLabel=$opt;
                            echo "	<input type=\"radio\" name=\"$name\" id=\"{$name}_{$opt}\" value=\"$opt\" class=\"radio\"".$this->_putValue($name,"radio",$opt).($attr!=""?" ".$attr:"")."/>";
                            $this->_putLabel($name."_".$opt,$optionLabel,"radio",true,true);
                        }
                        if($this->fieldSets) echo "</fieldset><br/>\n\n";
                    }

                } else if( strstr($flag,"set") ) {

                    if( $valuePairs ){
                        $this->_getFieldData($name);
                        $len=sizeof($this->normalized[$name]);
                    }
                    else {
                        $options = $this->_mysql_enum_values($this->table,$name);
                        if($labelPairs) $this->_getFieldLabels($name,$options);
                        $len=sizeof($options);
                    }
                    if( ($len > $this->enumField_toggle || $byForce == "multiselect") && $byForce != "checkbox" ){
                        $this->_putLabel($name,$label,"",false);
                        echo "<select name=\"".$name."[]\" id=\"$name\" size=\"$this->multiSelectSize\" multiple=\"multiple\" class=\"multiselect\"".($attr!=""?" ".$attr:"").">\n";
                        echo "<option value=''> </option>";#empty option
                        if( $valuePairs )
                        for($i=0;$i<$this->normalized[$name]['pairs'];$i++)
                        echo "	<option value=\"".$this->normalized[$name]['keys'][$i]."\"".$this->_putValue($name,"multi",$this->normalized[$name]['keys'][$i]).">".$this->normalized[$name]['values'][$i]."</option>\n";
                        else
                        foreach($options as $opt){
                            if( isset($this->labelValues[$name][$opt]) ) $optionLabel=$this->labelValues[$name][$opt]; else $optionLabel=$opt;
                            echo "	<option value=\"$opt\"".$this->_putValue($name,"multi",$opt).">$optionLabel</option>\n";
                        }
                        echo "</select>$this->fieldBreak";
                    } else {
                        if($this->fieldSets){
                            echo "<fieldset class=\"fieldset\">\n";
                            echo "<legend class=\"legend\">$label</legend>\n";
                        } else $this->_putLabel($name,$label,"",false);
                        $cb=0;
                        if( $valuePairs )
                        for($i=0;$i<$this->normalized[$name]['pairs'];$i++){
                            echo "	<input type=\"checkbox\" name=\"".$name."[]\" id=\"{$name}_{$cb}\" value=\"".$this->normalized[$name]['keys'][$i]."\"".$this->_putValue($name,"checkbox",$this->normalized[$name]['keys'][$i]).($attr!=""?" ".$attr:"")."/>";
                            $this->_putLabel($name."_".$cb,$this->normalized[$name]['values'][$i],"checkbox",true,true);
                            $cb++;
                        }
                        else
                        foreach($options as $opt){
                            if( isset($this->labelValues[$name][$opt]) ) $optionLabel=$this->labelValues[$name][$opt]; else $optionLabel=$opt;
                            echo "	<input type=\"checkbox\" name=\"".$name."[]\" id=\"{$name}_{$cb}\" value=\"$opt\"".$this->_putValue($name,"checkbox",$opt).($attr!=""?" ".$attr:"")."/>";
                            $this->_putLabel($name."_".$cb,$optionLabel,"checkbox",true,true);
                            $cb++;
                        }
                        if($this->fieldSets) echo "</fieldset><br/>\n\n";
                    }
                    $this->_putSetCheckField($name);

                } else { //plain text field

                    if($verify) $name = $name."_verify";
                    if( $byForce != "button" ){ $this->_putLabel($name,$label); }
                    if($len < $this->textInputLength) $length = $len; else $length=$this->textInputLength;

                    if( ($len>$this->strField_toggle || $byForce == "textarea") && $byForce != "text" && $byForce != "file" )
                    echo "<textarea name=\"$name\" id=\"$name\" rows=\"$this->textareaRows\" cols=\"$this->textareaCols\" class=\"textarea\"".($attr!=""?" ".$attr:"").">".$this->_putValue(str_replace("_verify","",$name),"textarea")."</textarea>$this->fieldBreak";
                    else {
                        if( $byForce == "file" ){
                            echo "<input type=\"file\" name=\"$name\" id=\"$name\" size=\"$this->fileInputLength\" class=\"file\"".($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                        } else if( $byForce == "button" ){
                            echo "<input type=\"button\" name=\"$name\" id=\"$name\" value=\"$label\" class=\"button\"".($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                        } else {
                            $fieldType = ($byForce=="password" ? "password" : "text");
                            echo "<input type=\"$fieldType\" name=\"$name\" id=\"$name\" size=\"$length\" MAXLENGTH=\"$len\" class=\"text\"".$this->_putValue(str_replace("_verify","",$name)).($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                        }
                    }

                }
                break;

                case "date":
                #$fieldVals["date"]		= array('size'=>"10",	'default'=>date("Y-m-d"));
                $this->_putLabel($name,$label);
                #dummy hidden text field for validation purposes
                echo "<input type=\"hidden\" name=\"$name\" >";

                #retrieved value
                $retrieved = $this->_putValue($name, "date" );
                $this->print_date_pulldown($name, $retrieved, 0, 0, date("Y") - 100, date("Y") + 5, 0, 1);
                echo $this->fieldBreak;
                break;

                case "datetime":
                $fieldVals["datetime"]	= array('size'=>"19",	'default'=>date("Y-m-d H:i:s"));

                case "timestamp":
                $fieldVals["timestamp"]	= array('size'=>$len,	'default'=>time());

                case "time":
                $fieldVals["time"]		= array('size'=>"8",	'default'=>date("H:i:s"));

                case "year":
                $fieldVals["year"]		= array('size'=>"4",	'default'=>date("Y"));

                $this->_putLabel($name,$label);

                echo "<input type=\"text\" name=\"$name\" id=\"$name\" size=\"".$fieldVals[$type]['size']."\" MAXLENGTH=\"".$fieldVals[$type]['size']."\" ".$this->_putValue($name,"text",$fieldVals[$type]['default'])." class=\"text\"".($attr!=""?" ".$attr:"")."/>$this->fieldBreak";
                #print_r($_REQUEST);
                break;

                case "skip":
                break;

            } //end switch

        } //end _outputField

        function print_date_pulldown($date_name, $date_value_row, $date_default_today = 0, $date_default_value = 0, $min_year = 0, $max_year = 0, $min_year_diff = 0, $max_year_diff = 0)
        {
            $default_min_year_diff = 80;
            $default_max_year_diff = 5;

            if ($min_year_diff <> 0) $min_year_diff = $default_min_year_diff;
            if ($max_year_diff <> 0) $max_year_diff = $default_max_year_diff;

            #if no max or min years are given, use defaults or derive from diffs if given
            $today = getdate();
            if ($min_year == 0) $min_year = $today[year] - $min_year_diff;
            if ($max_year == 0) $max_year = $today[year] + $max_year_diff;

            if ($date_value_row == "")
            {
                if ($date_default_today == 1) $date_value_row = getdate(); #use today's date as the default
                if ($date_default_value <> 0) $date_value_row = $date_default_value; #use provided date as the default
            }
            if ($date_value_row == "" and $date_default_today == 1) $date_value_row = getdate();
            $date_year = substr($date_value_row,0,4);
            $date_month = substr($date_value_row,5,2);
            $date_day = substr($date_value_row,8,2);

            $fill_array = array("");
            for ($i = 1;$i <= 31;$i++)
            {
                array_push($fill_array, $i);
            }
            $this->print_pulldown($date_name."_day", "DAY", $date_day, $_REQUEST[$date_name.'_day'], $fill_array);

            $fill_array = array("");
            for ($i = 1;$i <= 12;$i++)
            {
                array_push($fill_array, $i);
            }
            $this->print_pulldown($date_name."_month", "MON", $date_month, $_REQUEST[$date_name.'_month'], $fill_array);

            if ($date_year < $min_year and $date_year > 0) $min_year = $date_year;
            $fill_array = array("");
            for ($i = $max_year;$i > $min_year;$i--) array_push($fill_array, $i);
            $this->print_pulldown($date_name."_year", "YR", $date_year, $_REQUEST[$date_name.'_year'], $fill_array);
        }

        function print_pulldown($pulldown_name ,$pulldown_label, $value_row, $value_chosen, $value_option_array, $value_underlying_array = "", $auto_reload = 0)
        {
            #This function will fill a pulldown list intelligently, meaning it will check to see if the form has been reloaded due to bad data (and it will auto-select the previously selected item... so it has a "memory" of sorts)
            #It also will select a value that corresponds to a saved item in a database record
            #Otherwise it will select the first, blank option, by default

            ###########
            #PARAMETERS
            ###########

            #1) $pulldown_name:
            #	the name of the pulldown

            #2) $value_row:
            #	the value of the database record's field corresponding to this pulldown (ie which one was previously selected and saved into the database)

            #3) $value_chosen:
            #	usually $_REQUEST[$pulldown_name], the value that the user chose before submitting the form... used to re-select the correct entry in case the form needs to be reloaded before the record is saved due to incorrect or missing data entry

            #4) $value_option_array:
            #	an array of text values to be added to the array of pulldown items.

            #5) $value_underlying_array:
            #	an array of actual values to be added to the array of pulldown items.

            #6) $auto_reload:
            # whether to reload the html page when the item is changed

            if ($value_underlying_array == "")
            {
                $value_underlying_array = $value_option_array;
            }

            echo "<label> ".$pulldown_label." </label>";
            echo "<select name='".$pulldown_name."'";

            if ($auto_reload == 1) echo " onchange='JavaScript:submit()'";

            echo " class=\"select\">";
            $i = 0;
            foreach ($value_option_array as $value_option)
            {
                if ($value_underlying_array[$i] == "")
                {
                    #blank option (first option is blank)
                    echo '<option value="'.$value_underlying_array[$i].'"';
                    if (isset($_REQUEST[$pulldown_name]) and $value_chosen == $value_underlying_array[$i])
                    {echo 'selected';}
                    else
                    {
                        if ($value_row == $value_underlying_array[$i])
                        {
                            echo 'selected';
                        }
                    }
                    echo'></option>';
                }
                else
                {
                    #non-blank option
                    echo '<option value="'.$value_underlying_array[$i].'"';
                    if ($value_chosen == $value_underlying_array[$i])
                    {
                        echo 'selected';
                    }
                    else
                    {
                        if ($value_row == $value_underlying_array[$i])
                        {
                            echo 'selected';
                        }
                    }
                    echo'>'.$value_option.'</option>';
                }
                $i ++;
            }
            echo "</select>";

        }
        #retrieve date from respective select boxes
        function getDate($fieldName){
            return $_POST[$fieldName.'_year'].'-'.$_POST[$fieldName.'_month'].'-'.$_POST[$fieldName.'_day'];
        }
        #check to see that the date is valid
        function validateDate($fieldName){

            return checkdate($_POST[$fieldName.'_month'],$_POST[$fieldName.'_day'],$_POST[$fieldName.'_year']);
        }
        //this function marks a field as a date field in order to get the values from resp. select boxes for submission
        //arg is field name
        function setDateField($fieldName){

            $this->dateField[$fieldName] = true;

        }

    } //end Formitable class


    //RC4Crypt 3.2
    //(C) Copyright 2006 Mukul Sabharwal [http://mjsabby.com]
    //All Rights Reserved
    class rc4crypt {
        function _crypt ($pwd, $data, $ispwdHex = 0){
            if ($ispwdHex)
            $pwd = @pack('H*', $pwd); // valid input, please!

            $key[] = '';
            $box[] = '';
            $cipher = '';

            $pwd_length = strlen($pwd);
            $data_length = strlen($data);

            for ($i = 0; $i < 256; $i++){
                $key[$i] = ord($pwd[$i % $pwd_length]);
                $box[$i] = $i;
            }
            for ($j = $i = 0; $i < 256; $i++){
                $j = ($j + $box[$i] + $key[$i]) % 256;
                $tmp = $box[$i];
                $box[$i] = $box[$j];
                $box[$j] = $tmp;
            }
            for ($a = $j = $i = 0; $i < $data_length; $i++){
                $a = ($a + 1) % 256;
                $j = ($j + $box[$a]) % 256;
                $tmp = $box[$a];
                $box[$a] = $box[$j];
                $box[$j] = $tmp;
                $k = $box[(($box[$a] + $box[$j]) % 256)];
                $cipher .= chr(ord($data[$i]) ^ $k);
            }
            return $cipher;
        }
        function _encrypt ($pwd, $data, $ispwdHex = 0){
            return urlencode($this->_crypt($pwd, $data, $ispwdHex));
        }
        function _decrypt ($pwd, $data, $ispwdHex = 0){
            return $this->_crypt($pwd, urldecode(get_magic_quotes_gpc()?stripslashes($data):$data), $ispwdHex);
        }
    }

?>