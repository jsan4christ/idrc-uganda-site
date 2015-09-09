<?php
    #require_once( './config/connect.inc.php' );
    // Class for user authentication
    Class Authentication {

        function authenticateUser($db, $username, $password){
            // Test the username and password parameters
            if (!isset($username) || !isset($password))
            return false;

            // Create a digest of the password collected from
            // the challenge
            $encrypted_password = crypt($password,'yxpijaui93');
            // Formulate the SQL find the user
            $query = "SELECT * FROM sionapros_users WHERE username LIKE BINARY '{$username}'";
            $query .= " AND password = '{$encrypted_password}'";

            // Execute the query
            $result = $db->execute($query);
            // exactly one row? then we have found the user
            if (count($result) != 1)
            return false;
            else
            return true;
        }

        // Connects to a session and checks that the user has
        // authenticated and that the remote IP address matches
        // the address used to create the session.
        function sessionAuthenticate(){
            // Check if the user hasn't logged in
            if (!isset($_SESSION["loginUsername"])){
                // The request does not identify a session
                $this->msg = "You are either not yet LOGGED IN or your Session has Expired.
                                                Please LOG IN ";
                return false;
            }
            // Check if the request is from a different IP address to previously
            else if (!isset($_SESSION["loginIP"]) || ($_SESSION["loginIP"] != $_SERVER["REMOTE_ADDR"])){
                // The request did not originate from the machine that was used to create the session.
                // THIS IS POSSIBLY A SESSION HIJACK ATTEMPT
                $this->msg = "You Are Using a Session That Is Already Assigned To Someone Else.
                                                Please LOG IN AGAIN";
                return false;
            }
            #session is ok
            else
            return true;
        }
        //Check User Account Status
        function accountStatus($db, $username){
            #query database for account_status
            $query = " SELECT account_status FROM sionapros_users WHERE username = '{$username}' ";
            if (!$db->query($query))
            die(' '.$db->error);
            else
            $status = $db->getColumn();

            if ($status[0] == 'Inactive')
            return false;
            else
            return true;
        }
        #function for changing user Password in db
        function chgPassword($db, $username, $newPass){
            // Test the username and password parameters
            if (!isset($username) || !isset($newPass))
            return false;

            $encrypted_password = crypt($newPass,'yxpijaui93');
            $updatePass = "UPDATE sionapros_users SET password = '{$encrypted_password}', change_password = 'No' WHERE username = '{$username}'";
            if ($db->query($updatePass))
            return true;
            else
            return false;

        }
        #function that checks whether the user is required to change their password
        function chgPassStatus($db, $username){
            #
            $query = "SELECT change_password FROM sionapros_users WHERE username = '{$username}'";
            $db->query($query);
            $chg_pass = $db->getColumn();

            if( $chg_pass[0] == 'Yes' )
            return true;
            else{
                $_SESSION['chg_pass'] = 'not required';
                return false;
            }

        }
    }
?>
