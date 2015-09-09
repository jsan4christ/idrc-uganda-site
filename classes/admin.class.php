<?php

    class Admin{

        var $db;

        function Admin(& $db){

            $this->db = $db;
        }

        #get id for newly registered property
        function getId($tableName){

            $idSQL = "SELECT MAX(id) FROM $tableName";
            $this->db->query($idSQL);

            return $this->db->getValue() + 1;
        }
        #del info from db
        function delInfo($tableName, $id){
            #del info
            $delSQL = "DELETE FROM $tableName WHERE id = '$id'";

            if( $this->db->query($delSQL)  ){
                return true;
            }
            else{
                return false;
            }
        }
        #check to see whether user is allowed to upload more photos for a given property
        function allowUpload($no, $type = 'Normal'){

            #check photo type
            if( $type == '' )
            $type = 'Normal';

            $SQL = "SELECT * FROM sionapros_cs_photos WHERE case_no = '$no' AND type = '$type'";

            if( count($this->db->execute($SQL)) < 1 ){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>

