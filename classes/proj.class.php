<?php

    class Proj{

        var $db;

        function Proj(& $db){

            $this->db = $db;
        }

        #del proj info opt from db
        function delProjOpt($id){
            #del from object_profile table
            $delSQL = "DELETE FROM sionapros_proj_info_opt WHERE id = '$id'";

            if( $this->db->query($delSQL)  )
            return true;
            else
            return false;

        }
        #update proj info option
        function updProjOpt($id, $new_name){
            #update in only profile main
            $updSQL = "UPDATE sionapros_proj_info_opt SET value = '$new_name' WHERE id = '$id'";
            if($this->db->query($updSQL))
            return true;
            else
            return false;

        }
        #retrieve next Proj_no value
        function getProjNo(){

            $SQL = "SELECT MAX(proj_no) FROM sionapros_proj_info";
            $result = $this->db->execute($SQL);
            $id = $result[0];
            return $id['MAX(proj_no)'] + 1;

        }
        #get the next info_no available for the given Proj
//        function getInfoNo($proj_no){
//
//            $idSQL = "SELECT MAX(info_no) FROM sionapros_proj_info2 WHERE proj_no = '$proj_no'";
//            $result = $this->db->execute($idSQL);
//            $id = $result[0];
//
//            return $id['MAX(info_no)'] + 1;
//        }
        #get the next info_no given for the given Proj and table
        function getInfoNo($tableName, $proj_no, $colName){

            $idSQL = "SELECT MAX($colName) FROM $tableName WHERE proj_no = '$proj_no'";
            $result = $this->db->query($idSQL);

            return $this->db->getValue() + 1;
        }
        #retrieve next donor_no given proj_no
        function getDonorNo($proj_no){

            $SQL = "SELECT MAX(donor_no) FROM sionapros_proj_donor WHERE proj_no = '$proj_no'";
            $result = $this->db->execute($SQL);
            $id = $result[0];

            return $id['MAX(donor_no)'] + 1;
        }
        #check to see whether for a given project, a lead donor exists
        function leadDonorExists($proj_no){

            $SQL = "SELECT * FROM sionapros_proj_donor WHERE proj_no = '$proj_no' AND status = 'Lead'";
            $result = $this->db->execute($SQL);

            if( count($result)>0 )
            return true;
            else
            return false;
        }
        #func retrieves the original value of the status of the donor
        #This helps to avoid updating the status to lead when they werent orginally in that state and already a lead donor exists
        function origDonorStatus($proj_no, $donor_no){

            $SQL = "SELECT status FROM sionapros_proj_donor WHERE proj_no = '$proj_no' AND donor_no = '$donor_no'";
            $this->db->query($SQL);

            return $this->db->getColumn();
        }
        #check to see whether for a given project, a lead org exists
        function leadOrgExists($proj_no){

            $SQL = "SELECT * FROM sionapros_proj_org WHERE proj_no = '$proj_no' AND status = 'Lead'";
            $result = $this->db->execute($SQL);

            if( count($result)>0 )
            return true;
            else
            return false;
        }

        function origOrgStatus($proj_no, $org_no){

            $SQL = "SELECT status FROM sionapros_proj_org WHERE proj_no = '$proj_no' AND org = '$org_no'";
            $this->db->query($SQL);

            return $this->db->getColumn();
        }
        #func that uses proj_no and donor_no to get the next available poc_no
        function getPoCNo($proj_no, $donor_no){

            $SQL = "SELECT MAX(poc_no) FROM sionapros_proj_donor_poc WHERE proj_no = '$proj_no' AND donor_no = '$donor_no'";
            $this->db->query($SQL);

            return $this->db->getValue() + 1;
        }

    }


?>

