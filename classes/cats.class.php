<?php

    class Cats{

        var $db;

        function Cats(& $db){

            $this->db = $db;
        }

        #del Cats from db
        function delCategory($id){
            #del from object_profile table
            $delSQL = "DELETE FROM sionapros_categories WHERE id = '$id'";

            if( $this->db->query($delSQL)  )
            return true;
            else
            return false;
        }
        function delCat($tableName, $id){
            #del from object_profile table
            $delSQL = "DELETE FROM {$tableName} WHERE id = '$id'";

            if( $this->db->query($delSQL)  )
            return true;
            else
            return false;
        }
        #update Cats
        function updCategory($id, $new_name){
            #update in only profile main
            $updSQL = "UPDATE sionapros_categories SET value = '$new_name' WHERE id = '$id'";
            if($this->db->query($updSQL))
            return true;
            else
            return false;

        }
        function updCat($table, $id, $new_name){
            #update in only profile main
            $updSQL = "UPDATE {$table} SET value = '$new_name' WHERE id = '$id'";
            if($this->db->query($updSQL))
            return true;
            else
            return false;

        }
        #get next category id
        function getCatNo(){

            $SQL = "SELECT MAX(id) FROM sionapros_categories";
            $result = $this->db->execute($SQL);
            $id = $result[0];
            return $id['MAX(id)'] + 1;

        }
    }


?>

