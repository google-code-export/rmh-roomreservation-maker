<?php

/*
 * UserProfile class for RMH Reservation Maker
 * @author Linda Shek
 * @version April 03, 2012
 */

class User {
    private $userProfileId;         // userProfileId (unique key)
    private $userLoginInfoId;       // userLoginInfoId - string
    private $userEmail;             // email address
    private $password;              // password for database access: 
    private $userCategory;          // userCategory - string
    
/*
 * constructor for a User
 */
    function __construct($userProfileId, $userLoginInfoId, $userEmail, $password, $userCategory){                
        $this->userProfileId = $userProfileId; 
        $this->userLoginInfoId = $userLoginInfoId;
        $this->userEmail = $userEmail;
        $this->userCategory = $userCategory;
        
        if ($password=="")
            $this->password = md5($this->userProfileId);
        else $this->password = $password;       
    }
    
    //getter functions
    function get_userProfileId() {
        return $this->userProfileIdid;
    }
    
    function get_userLoginInfoId() {
        return $this->userLoginInfoId;
    }
    
    function get_userEmail() {
        return $this->userEmail;
    }
    
    function get_userCategory() {
        return $this->userCategory;
    }
    
    function get_password() {
        return $this->password;
    }
   
//setter functions
    function set_userProfileId($id) {
        $this->userProfileId = $id;
    }
    
    function set_userLoginInfoId($userid)
    {
        $this->userLoginInfoId = $userid;
    }
    
    function set_userEmail($em){
        $this->email = $em;
    }
    
    function set_userCategory($cat)
    {
        $this->userCategory = $cat;
    }
    
    function set_password ($pass) {
        $this->password = $pass;
    }

}
?>

