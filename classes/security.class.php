<?php

    class Security{

        var $db;

        function Security(& $db){

            $this->db = $db;
        }

        ###########
        #  Functions for the Access Security Component
        ######

        #show all profiles in db
        function showProfiles(){

            $profSQL = "SELECT profile FROM sionapros_profiles";
            $this->db->execute($profSQL);
            $profiles = $this->db->getColumn();

            return $profiles[0];

        }
        #get user profiles
        function userProfiles($username){

            $userSQL = "SELECT profiles.profile FROM sionapros_user_profiles AS user INNER JOIN sionapros_profiles AS profiles ON";
            $userSQL .= " user.profile_id = profiles.profile_id WHERE user.username = '$username'";
            $userProfiles = $this->db->execute($userSQL);

            return $userProfiles;

        }
        #check whether user has rights to access an object
        function accessCheck($username, $object){
            #Access Restrictions dont apply to user 'Admin'
            if( $username != 'SADMIN' ){
                #check whether object has restrictions on it at folder level
                $folder = dirname($object);
                $folderSQL = "SELECT * FROM sionapros_object_profile WHERE object = '$folder'";
                $folderRes = $this->db->execute($folderSQL);

                if( count($folderRes) != 0 ){
                    #now check if user has the necessary rights to view folder contents
                    $accessFolderSQL = "SELECT objects.object FROM sionapros_user_profiles AS profiles INNER JOIN sionapros_object_profile AS objects ON";
                    $accessFolderSQL .= " profiles.profile_id = objects.profile_id WHERE profiles.username = '$username' AND objects.object = '$folder'";
                    $accessFolderRes = $this->db->execute($accessFolderSQL);

                    if( count($accessFolderRes) == 0 )
                    return false;
                }
                #check whether object has restrictions applied to it at the function level(file level)
                #$file = basename($object);
                $file = $object;
                $fileSQL = "SELECT * FROM sionapros_object_profile WHERE object = '$file'";
                $fileRes = $this->db->execute($fileSQL);

                if( count($fileRes) != 0 ){
                    #check wheter user has rights to access the file/function
                    $accessFileSQL = "SELECT objects.object FROM sionapros_user_profiles AS profiles INNER JOIN sionapros_object_profile AS objects ON";
                    $accessFileSQL .= " profiles.profile_id = objects.profile_id WHERE profiles.username = '$username' AND objects.object = '$file'";
                    $accessFileRes = $this->db->execute($accessFileSQL);

                    if( count($accessFileRes) == 0 )
                    return false;
                }
            }
            #function returns true if user has the rights to view the object
            return true;

        }
        #view profile - object mapping from profile_id
        function objectProfiles($profile_id){

            $objectSQL = "SELECT objects.object FROM sionapros_object_profile AS objects INNER JOIN sionapros_profiles AS profiles ON";
            $objectSQL .= " objects.profile_id = profiles.profile_id WHERE profiles.profile_id = '$profile_id'";
            $objects = $this->db->execute($objectSQL);

            return $objects;

        }
        #view object - profile mapping from object_name
        function profileObjects($object){

            $objectSQL = "SELECT profiles.profile FROM sionapros_object_profile AS objects INNER JOIN sionapros_profiles AS profiles ON";
            $objectSQL .= " objects.profile_id = profiles.profile_id WHERE objects.object = '$object'";
            $objects = $this->db->execute($objectSQL);

            return $objects;
        }
        #del profile from db
        function delProfile($profile_id){
            #del from object_profile table
            $delSQL = "DELETE FROM sionapros_object_profile WHERE profile_id = '$profile_id'";
            #del from user_profile table
            $delSQL2 = "DELETE FROM sionapros_user_profiles WHERE profile_id = '$profile_id'";
            #del from profile main
            $delSQL3 = "DELETE FROM sionapros_profiles WHERE profile_id = '$profile_id'";

            if( ($this->db->query($delSQL) && $this->db->query($delSQL2)) && $this->db->query($delSQL3) )
            return true;
            else
            return false;


        }
        #update profile
        function updateProfile($profile_id, $new_name){
            #update in only profile main
            $updSQL = "UPDATE sionapros_profiles SET profile = '$new_name' WHERE profile_id = '$profile_id'";
            if($this->db->query($updSQL))
            return true;
            else
            return false;

        }
        #add user to profile
        function addUser($username, $profile_id){

            $usrSQL = "INSERT INTO sionapros_user_profiles (profile_id,username) VALUES('$profile_id','$username')";
            if($this->db->query($usrSQL))
            return true;
            else
            return false;
        }
        #remove user from profile
        function removeUser($username, $profile_id){

            $remSQL = "DELETE FROM sionapros_user_profiles WHERE profile_id = '$profile_id' AND username = '$username'";
            if( $this->db->query($remSQL) )
            return true;
            else
            return false;

        }
        #remove object from profile
        function removeObject($object, $profile_id){

            $remSQL = "DELETE FROM sionapros_object_profile WHERE profile_id = '$profile_id' AND object = '$object'";
            if( $this->db->query($remSQL) )
            return true;
            else
            return false;

        }
        #get current max profile_id
        function getProfileId(){

            $idSQL = "SELECT MAX(profile_id) FROM sionapros_profiles";
            $result = $this->db->execute($idSQL);
            $id = $result[0];

            return $id['MAX(profile_id)'] + 1;
        }
        #function to check whether a given profile name exists
        function profileExists($profile_name){

            $profSQL = "SELECT profile FROM sionapros_profiles WHERE profile = '$profile_name'";
            $profile = $this->db->execute($profSQL);

            if( count($profile) != 0 )
            return true;
            else
            return false;
        }
        #func checks to see that a system function being carried out is by the user who created the data being managed
        function checkUser($username1, $username2){

            if( $username1 == $username2 )
            return true;
            else
            return false;
        }


    }


?>

