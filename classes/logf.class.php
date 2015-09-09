<?php

    class Logf{

        var $db;

        function Logf(& $db){

            $this->db = $db;
        }
        #retrieve next mov_no value
        function getMovNo(){

            $SQL = "SELECT MAX(mov_no) FROM emes_perf_logf_movs";
            $result = $this->db->execute($SQL);
            $id = $result[0];
            return $id['MAX(mov_no)'] + 1;

        }
        #get the next info_no given for the given Proj and table
        function getInfoNo($tableName, $proj_no, $colName){

            $idSQL = "SELECT MAX($colName) FROM $tableName WHERE proj_no = '$proj_no'";
            $result = $this->db->query($idSQL);

            return $this->db->getValue() + 1;
        }
        #get the next_no for the result_no
        function getResultNo($proj_no, $info_no) {

            $idSQL = "SELECT MAX(result_no) FROM emes_perf_link_proj_obj_to_result WHERE proj_no = '$proj_no' AND info_no = '$info_no'";
            $this->db->query($idSQL);

            return $this->db->getValue() + 1;
        }
        #del all info that is under a given OVI
        #this includes targets, tactics and schedules
        function delTargetData($proj_no, $ovi_no = 0){
            #get target ids related to the given proj_nos and ovi_nos
            if( $ovi_no == 0 )
            $targSQL = "SELECT target_id FROM emes_perf_targets WHERE proj_no = '$proj_no'";
            else
            $targSQL = "SELECT target_id FROM emes_perf_targets WHERE proj_no = '$proj_no' AND ovi_no = '$ovi_no'";

            $result = $this->db->execute($targSQL);

            foreach( $result as $row ){
                $SQL3 = "DELETE FROM emes_perf_hr WHERE target_id = {$row['target_id']}";
                $this->db->query($SQL3);

                $SQL2 = "DELETE FROM emes_perf_tactics WHERE target_id = {$row['target_id']}";
                $this->db->query($SQL2);

                $SQL = "DELETE FROM emes_perf_targets WHERE target_id = {$row['target_id']}";
                $this->db->query($SQL);

            }

        }
        #del all data linked to a proj
        function delAll($proj_no){

            $delSQL = "DELETE FROM emes_perf_logf_activities WHERE proj_no = '$proj_no'";
            $delSQL2 = "DELETE FROM emes_perf_logf_assmptn WHERE proj_no = '$proj_no'";
            $delSQL3 = "DELETE FROM emes_perf_link_proj_info_to_assmptn WHERE proj_no = '$proj_no'";
            $delSQL4 = "DELETE FROM emes_perf_link_proj_info_to_activity WHERE proj_no = '$proj_no'";
            $delSQL5 = "DELETE FROM emes_perf_logf_inputs WHERE proj_no = '$proj_no'";
            $delSQL6 = "DELETE FROM emes_perf_proj_org WHERE proj_no = '$proj_no'";
            $delSQL7 = "DELETE FROM emes_perf_proj_donor WHERE proj_no = '$proj_no'";

            if( $this->db->query($delSQL) && $this->db->query($delSQL2) && $this->db->query($delSQL3)
                && $this->db->query($delSQL4) && $this->db->query($delSQL5) && $this->db->query($delSQL6) && $this->db->query($delSQL7) )
            return true;
            else
            return false;

        }


    }


?>

