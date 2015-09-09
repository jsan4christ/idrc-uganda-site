<?php
    // Class Listbox V 1.0
    // Created by DejiTaru
    // 16 october 2005
    // email: dejitaru@gmail.com
    // Email me please!!
    //
    class classListBox
    {
        var $LB_query;
        var $LB_name;
        var $LB_primary_key;
        var $LB_text;
        var $listBox;
        var $LB_selectedItemValue;
        var $LB_selectedItemKey;
        var $LB_postback;
        var $db;


        function classListBox(& $db, $pName)
        {
            $this->db = $db;
            $this->listBox = "";
            $this->LB_name = $pName;
            $this->LB_selectedItemValue = '';
            $this->LB_selectedItemKey = '';
        }
        function set_selectedItemValue($pItem)
        {
            $this->LB_selectedItemValue = $pItem;
        }
        function set_selectedItemKey($pItem)
        {
            $this->LB_selectedItemKey = $pItem;
        }

        function get_selectedItemValue()
        {
            return $this->LB_selectedItemValue;
        }

        function get_selectedItemKey()
        {
            return $this->LB_selectedItemKey;
        }

        function set_query($SQLquery,$primaryKey,$text)
        {
            $this->LB_query = $SQLquery;
            $this->LB_primary_key = $primaryKey;
            $this->LB_text = $text;
        }
        function set_postback($onChange)
        {
            $this->LB_postback = $onChange;
        }


        function display($default = '')
        {
            $SQLresult = $this->db->execute($this->LB_query);

            //user change selected item
            if(isset($_POST[$this->LB_name])){
                #save value in the session array
                $_SESSION[$this->LB_name] = $_POST[$this->LB_name];
            }
            $this->set_selectedItemKey($_SESSION[$this->LB_name]);
            #html for the select boxes
            $listBox = "<select name='".$this->LB_name."' class='select' size='1'";
            #set the onchange attribute if $LB_postback is set to true
            if($this->LB_postback == "true")
            $listBox .= "onchange='this.form.submit()'";

            $listBox .= ">";
            $listBox .= "<option value=''> SELECT </option>";
            #$rowCount = 0;
            #populate select box
            for($i=0; $i<count($SQLresult); $i++){
                $row = $SQLresult[$i];
                $listBox .= "<option value='".$row[$this->LB_primary_key]."' ";
                if( !isset($_POST[$this->LB_name]) && $default == $row[$this->LB_primary_key] )
                $listBox .= "selected";
                elseif ($this->get_selectedItemKey() == $row[$this->LB_primary_key])
                $listBox .= "selected";

                $listBox .= ">".$row[$this->LB_text]."</option>";
                #$rowCount++;
            }

            $listBox .= "</select>";
            ob_start();
            echo $listBox;
            $html_block = ob_get_contents();
            ob_end_clean();
            return $html_block;
            #return $row;
        }


    }
?>