<?php
    $host="localhost"; 
    $db_user="user"; 
    $db_password="1234"; 
    $database="MyWebsite"; 
    //timeout
    function check_timeout(){
        if (isset($_SESSION['LAST_ACTIVITY'])) {

            if(time() - $_SESSION['LAST_ACTIVITY'] > 300){
                // last request was more than 5 minutes ago
                session_unset();     // unset $_SESSION variable for the run-time 
                session_destroy();   // destroy session data in storage
            }
            else{
                $_SESSION['LAST_ACTIVITY'] = time();
            }
            
        }
    }
    
?>